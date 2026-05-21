<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    /**
     * Display all tickets
     */
    public function index(Request $request)
    {
        $query = SupportTicket::with(['user', 'latestMessage']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Sort - urgent first, then by date
        $tickets = $query->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low')")
            ->orderByDesc('created_at')
            ->paginate(20);

        $stats = [
            'open' => SupportTicket::where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'waiting' => SupportTicket::where('status', 'waiting_customer')->count(),
            'resolved' => SupportTicket::where('status', 'resolved')->count(),
        ];

        return view('admin.support.index', compact('tickets', 'stats'));
    }

    /**
     * Show ticket detail
     */
    public function show(SupportTicket $ticket)
    {
        $ticket->load(['user', 'messages.user', 'invitation']);

        return view('admin.support.show', compact('ticket'));
    }

    /**
     * Reply to ticket
     */
    public function reply(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:5000',
            'attachment' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
            'new_status' => 'nullable|in:in_progress,waiting_customer,resolved',
        ]);

        $messageData = [
            'user_id' => $request->user()->id,
            'message' => $validated['message'],
            'is_admin_reply' => true,
        ];

        if ($request->hasFile('attachment')) {
            $messageData['attachment'] = $request->file('attachment')->store('ticket-attachments', 'public');
        }

        $ticket->messages()->create($messageData);

        // Update status if specified
        if (!empty($validated['new_status'])) {
            $ticket->update(['status' => $validated['new_status']]);
            
            if ($validated['new_status'] === 'resolved') {
                $ticket->update(['resolved_at' => now()]);
            }
        } else {
            // Default: mark as waiting for customer after admin reply
            $ticket->update(['status' => 'waiting_customer']);
        }

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    /**
     * Get messages as JSON (for live polling)
     */
    public function messages(SupportTicket $ticket)
    {
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
     * Update ticket status
     */
    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,waiting_customer,resolved,closed',
        ]);

        $updateData = ['status' => $validated['status']];
        
        if ($validated['status'] === 'resolved') {
            $updateData['resolved_at'] = now();
        } elseif (in_array($validated['status'], ['open', 'in_progress'])) {
            $updateData['resolved_at'] = null;
        }

        $ticket->update($updateData);

        return back()->with('success', 'Status tiket berhasil diperbarui.');
    }

    /**
     * Update ticket priority
     */
    public function updatePriority(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $ticket->update(['priority' => $validated['priority']]);

        return back()->with('success', 'Prioritas tiket berhasil diperbarui.');
    }
}
