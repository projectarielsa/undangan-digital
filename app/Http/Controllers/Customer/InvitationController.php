<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreInvitationRequest;
use App\Http\Requests\Customer\UpdateInvitationRequest;
use App\Models\Invitation;
use App\Models\InvitationTemplate;
use App\Services\InvitationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function __construct(
        protected InvitationService $service
    ) {}

    /**
     * Display a listing of the user's invitations.
     */
    public function index(Request $request): View
    {
        $invitations = $request->user()
            ->invitations()
            ->with('template')
            ->latest()
            ->paginate(10);

        return view('customer.invitations.index', compact('invitations'));
    }

    /**
     * Show the form for creating a new invitation.
     */
    public function create(Request $request): View
    {
        $templates = InvitationTemplate::active()
            ->orderBy('sort_order')
            ->get();

        $hasActiveSubscription = $request->user()->activeSubscription() !== null;

        return view('customer.invitations.create', compact('templates', 'hasActiveSubscription'));
    }

    /**
     * Store a newly created invitation.
     */
    public function store(StoreInvitationRequest $request): RedirectResponse
    {
        $invitation = $this->service->create(
            $request->user(),
            $request->validated()
        );

        return redirect()
            ->route('customer.invitations.edit', $invitation)
            ->with('success', 'Undangan berhasil dibuat!');
    }

    /**
     * Display the specified invitation.
     */
    public function show(Invitation $invitation): View
    {
        $this->authorize('view', $invitation);

        $invitation->load(['template', 'galleries', 'guests', 'guestbooks']);

        return view('customer.invitations.show', [
            'invitation' => $invitation,
            'rsvpStats' => $invitation->getRsvpStats(),
            'limits' => $this->service->getFeatureLimits($invitation),
        ]);
    }

    /**
     * Show the form for editing the specified invitation.
     */
    public function edit(Invitation $invitation, Request $request): View
    {
        $this->authorize('update', $invitation);

        $invitation->load('galleries');

        $templates = InvitationTemplate::active()
            ->orderBy('sort_order')
            ->get();

        $hasActiveSubscription = $request->user()->activeSubscription() !== null;

        return view('customer.invitations.edit', compact('invitation', 'templates', 'hasActiveSubscription'));
    }

    /**
     * Update the specified invitation.
     */
    public function update(UpdateInvitationRequest $request, Invitation $invitation): RedirectResponse
    {
        $this->service->update($invitation, $request->validated());

        return redirect()
            ->route('customer.invitations.edit', $invitation)
            ->with('success', 'Undangan berhasil diperbarui!');
    }

    /**
     * Remove the specified invitation.
     */
    public function destroy(Invitation $invitation): RedirectResponse
    {
        $this->authorize('delete', $invitation);

        $this->service->delete($invitation);

        return redirect()
            ->route('customer.invitations.index')
            ->with('success', 'Undangan berhasil dihapus.');
    }

    /**
     * Publish the invitation (make it public).
     */
    public function publish(Invitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);

        $invitation->publish();

        return back()->with('success', 'Undangan berhasil dipublikasikan!');
    }

    /**
     * Pause the invitation (hide from public).
     */
    public function pause(Invitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);

        $invitation->pause();

        return back()->with('success', 'Undangan berhasil dijeda.');
    }

    /**
     * Duplicate the invitation.
     */
    public function duplicate(Invitation $invitation): RedirectResponse
    {
        $this->authorize('view', $invitation);

        $newInvitation = $this->service->duplicate($invitation);

        return redirect()
            ->route('customer.invitations.edit', $newInvitation)
            ->with('success', 'Undangan berhasil diduplikasi!');
    }
}