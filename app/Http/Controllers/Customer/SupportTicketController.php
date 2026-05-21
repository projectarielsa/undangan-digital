<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    /**
     * Display list of tickets
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Check if user has priority support (Exclusive package)
        $subscription = $user->activeSubscription();
        $hasPrioritySupport = $subscription && $subscription->package->slug === 'exclusive';

        $tickets = $user->supportTickets()
            ->with('latestMessage')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('customer.support.index', compact('tickets', 'hasPrioritySupport'));
    }

    /**
     * Show create ticket form
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $subscription = $user->activeSubscription();
        $hasPrioritySupport = $subscription && $subscription->package->slug === 'exclusive';

        if (!$hasPrioritySupport) {
            return redirect()->route('customer.packages')
                ->with('error', 'Fitur Priority Support hanya tersedia untuk paket Exclusive. Silakan upgrade paket Anda.');
        }

        $invitations = $user->invitations()->orderBy('title')->get();

        return view('customer.support.create', compact('invitations'));
    }

    /**
     * Store new ticket
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $subscription = $user->activeSubscription();

        if (!$subscription || $subscription->package->slug !== 'exclusive') {
            return redirect()->route('customer.packages')
                ->with('error', 'Fitur Priority Support hanya tersedia untuk paket Exclusive.');
        }

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'required|in:technical,billing,feature,other',
            'invitation_id' => 'nullable|exists:invitations,id',
            'message' => 'required|string|max:5000',
            'attachment' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        // Verify invitation belongs to user
        if ($validated['invitation_id']) {
            $invitation = $user->invitations()->find($validated['invitation_id']);
            if (!$invitation) {
                return back()->withErrors(['invitation_id' => 'Undangan tidak ditemukan.']);
            }
        }

        // Create ticket
        $ticket = $user->supportTickets()->create([
            'subject' => $validated['subject'],
            'category' => $validated['category'],
            'invitation_id' => $validated['invitation_id'] ?? null,
            'priority' => 'high', // Exclusive users get high priority by default
            'status' => 'open',
        ]);

        // Create initial message
        $messageData = [
            'user_id' => $user->id,
            'message' => $validated['message'],
            'is_admin_reply' => false,
        ];

        if ($request->hasFile('attachment')) {
            $messageData['attachment'] = $request->file('attachment')->store('ticket-attachments', 'public');
        }

        $ticket->messages()->create($messageData);

        return redirect()->route('customer.support.show', $ticket)
            ->with('success', 'Tiket berhasil dibuat. Tim kami akan segera merespons.');
    }

    /**
     * Show ticket detail
     */
    public function show(Request $request, SupportTicket $ticket)
    {
        // Verify ownership
        if ($ticket->user_id !== $request->user()->id) {
            abort(403);
        }

        $ticket->load(['messages.user', 'invitation']);

        return view('customer.support.show', compact('ticket'));
    }

    /**
     * Reply to ticket
     */
    public function reply(Request $request, SupportTicket $ticket)
    {
        // Verify ownership
        if ($ticket->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($ticket->status === 'closed') {
            return back()->with('error', 'Tiket sudah ditutup. Silakan buat tiket baru.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
            'attachment' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        $messageData = [
            'user_id' => $request->user()->id,
            'message' => $validated['message'],
            'is_admin_reply' => false,
        ];

        if ($request->hasFile('attachment')) {
            $messageData['attachment'] = $request->file('attachment')->store('ticket-attachments', 'public');
        }

        $ticket->messages()->create($messageData);

        // Update status to open if was waiting for customer
        if ($ticket->status === 'waiting_customer') {
            $ticket->update(['status' => 'open']);
        }

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    /**
     * Close ticket
     */
    public function close(Request $request, SupportTicket $ticket)
    {
        if ($ticket->user_id !== $request->user()->id) {
            abort(403);
        }

        $ticket->close();

        return back()->with('success', 'Tiket berhasil ditutup.');
    }

    /**
     * Get messages as JSON (for live polling)
     */
    public function messages(Request $request, SupportTicket $ticket)
    {
        if ($ticket->user_id !== $request->user()->id) {
            abort(403);
        }

        $ticket->load(['messages.user']);

        $messages = $ticket->messages->map(function ($message) {
            return [
                'id' => $message->id,
                'is_admin_reply' => $message->is_admin_reply,
                'user_name' => $message->is_admin_reply ? 'Tim Support' : $message->user->name,
                'user_initial' => substr($message->user->name, 0, 1),
                'message' => $message->message,
                'attachment_url' => $message->attachment ? $message->attachment_url : null,
                'created_at' => $message->created_at->format('d M Y H:i'),
            ];
        });

        return response()->json(['messages' => $messages, 'status' => $ticket->status]);
    }

    /**
     * Reopen ticket
     */
    public function reopen(Request $request, SupportTicket $ticket)
    {
        if ($ticket->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($ticket->status !== 'closed' && $ticket->status !== 'resolved') {
            return back()->with('error', 'Tiket tidak dalam status yang bisa dibuka kembali.');
        }

        $ticket->reopen();

        return back()->with('success', 'Tiket berhasil dibuka kembali.');
    }
}
