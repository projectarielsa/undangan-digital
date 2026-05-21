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
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function __construct(
        protected InvitationService $service
    ) {}

    public function index(Request $request): View
    {
        $invitations = $request->user()
            ->invitations()
            ->with('template')
            ->latest()
            ->paginate(10);

        return view('customer.invitations.index', compact('invitations'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        $templates = InvitationTemplate::active()
            ->orderBy('sort_order')
            ->get();

        $hasActiveSubscription = $request->user()->activeSubscription() !== null;

        return view('customer.invitations.create', compact('templates', 'hasActiveSubscription'));
    }

    public function store(StoreInvitationRequest $request): RedirectResponse
    {
        try {
            $invitation = $this->service->create(
                $request->user(),
                $request->validated()
            );
        } catch (ValidationException $e) {
            return back()
                ->withInput()
                ->with('error', $e->validator->errors()->first('package'));
        }

        return redirect()
            ->route('customer.invitations.edit', $invitation)
            ->with('success', 'Undangan berhasil dibuat!');
    }

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

    public function update(UpdateInvitationRequest $request, Invitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);

        $this->service->update($invitation, $request->validated());

        return redirect()
            ->route('customer.invitations.edit', $invitation)
            ->with('success', 'Undangan berhasil diperbarui!');
    }

    public function destroy(Invitation $invitation): RedirectResponse
    {
        $this->authorize('delete', $invitation);

        $this->service->delete($invitation);

        return redirect()
            ->route('customer.invitations.index')
            ->with('success', 'Undangan berhasil dihapus.');
    }

    public function publish(Invitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);

        $invitation->publish();

        return back()->with('success', 'Undangan berhasil dipublikasikan!');
    }

    public function pause(Invitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);

        $invitation->pause();

        return back()->with('success', 'Undangan berhasil dijeda.');
    }

    public function duplicate(Invitation $invitation): RedirectResponse
    {
        $this->authorize('view', $invitation);

        try {
            $newInvitation = $this->service->duplicate($invitation);
        } catch (ValidationException $e) {
            return back()
                ->with('error', $e->validator->errors()->first('package'));
        }

        return redirect()
            ->route('customer.invitations.edit', $newInvitation)
            ->with('success', 'Undangan berhasil diduplikasi!');
    }
}