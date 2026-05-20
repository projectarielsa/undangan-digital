<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Invitation;
use App\Services\QrCheckinService;
use Illuminate\Http\Request;

class QrCheckinController extends Controller
{
    public function __construct(protected QrCheckinService $qrService) {}

    /**
     * Display QR check-in management page
     */
    public function index(Request $request, Invitation $invitation)
    {
        $this->authorize('view', $invitation);

        // Check if user has QR check-in feature
        if (!$invitation->hasQrCheckinFeature()) {
            return redirect()->route('customer.packages')
                ->with('error', 'Fitur QR Check-in hanya tersedia untuk paket Exclusive. Silakan upgrade paket Anda.');
        }

        $guests = $invitation->guests()
            ->orderBy('name')
            ->paginate(20);

        $stats = $this->qrService->getCheckinStats($invitation);
        $recentCheckins = $this->qrService->getRecentCheckins($invitation);

        return view('customer.invitations.qr-checkin', compact('invitation', 'guests', 'stats', 'recentCheckins'));
    }

    /**
     * Generate QR codes for all guests
     */
    public function generateAll(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        if (!$invitation->hasQrCheckinFeature()) {
            return back()->with('error', 'Fitur QR Check-in tidak tersedia untuk paket Anda.');
        }

        $count = $this->qrService->generateAllQrCodes($invitation);

        return back()->with('success', "QR Code berhasil dibuat untuk {$count} tamu baru.");
    }

    /**
     * Generate QR code for single guest
     */
    public function generateSingle(Request $request, Invitation $invitation, Guest $guest)
    {
        $this->authorize('update', $invitation);

        if (!$invitation->hasQrCheckinFeature()) {
            return back()->with('error', 'Fitur QR Check-in tidak tersedia untuk paket Anda.');
        }

        // Verify guest belongs to invitation
        if ($guest->invitation_id !== $invitation->id) {
            abort(404);
        }

        $this->qrService->generateQrCode($guest);

        return back()->with('success', "QR Code berhasil dibuat untuk {$guest->name}.");
    }

    /**
     * Show QR code for guest (printable view)
     */
    public function showQrCode(Request $request, Invitation $invitation, Guest $guest)
    {
        $this->authorize('view', $invitation);

        if (!$invitation->hasQrCheckinFeature()) {
            abort(403, 'Fitur QR Check-in tidak tersedia untuk paket Anda.');
        }

        if ($guest->invitation_id !== $invitation->id) {
            abort(404);
        }

        if (!$guest->qr_code) {
            $this->qrService->generateQrCode($guest);
            $guest->refresh();
        }

        $qrSvg = $this->qrService->getQrCodeSvg($guest, 300);
        $checkinUrl = $this->qrService->getCheckinUrl($guest);

        return view('customer.invitations.qr-code-print', compact('invitation', 'guest', 'qrSvg', 'checkinUrl'));
    }

    /**
     * Scanner page for checking in guests
     */
    public function scanner(Request $request, Invitation $invitation)
    {
        $this->authorize('view', $invitation);

        if (!$invitation->hasQrCheckinFeature()) {
            return redirect()->route('customer.packages')
                ->with('error', 'Fitur QR Check-in hanya tersedia untuk paket Exclusive.');
        }

        $stats = $this->qrService->getCheckinStats($invitation);

        return view('customer.invitations.qr-scanner', compact('invitation', 'stats'));
    }

    /**
     * Manual check-in
     */
    public function manualCheckin(Request $request, Invitation $invitation, Guest $guest)
    {
        $this->authorize('update', $invitation);

        if ($guest->invitation_id !== $invitation->id) {
            abort(404);
        }

        $guest->update([
            'is_checked_in' => true,
            'checked_in_at' => now(),
        ]);

        return back()->with('success', "{$guest->name} berhasil check-in.");
    }

    /**
     * Undo check-in
     */
    public function undoCheckin(Request $request, Invitation $invitation, Guest $guest)
    {
        $this->authorize('update', $invitation);

        if ($guest->invitation_id !== $invitation->id) {
            abort(404);
        }

        $guest->update([
            'is_checked_in' => false,
            'checked_in_at' => null,
        ]);

        return back()->with('success', "Check-in {$guest->name} dibatalkan.");
    }

    /**
     * Welcome display page for showing on separate monitor
     */
    public function welcomeDisplay(Request $request, Invitation $invitation)
    {
        $this->authorize('view', $invitation);

        if (!$invitation->hasQrCheckinFeature()) {
            return redirect()->route('customer.packages')
                ->with('error', 'Fitur QR Check-in hanya tersedia untuk paket Exclusive.');
        }

        // Load template and galleries for styling
        $invitation->load(['template', 'galleries']);
        
        // Get gallery images (max 10 for slideshow)
        $galleryImages = $invitation->galleries->take(10)->map(function ($gallery) {
            return $gallery->getImageUrl();
        })->toArray();

        return view('customer.invitations.qr-welcome-display', compact('invitation', 'galleryImages'));
    }

    /**
     * API endpoint to get latest check-in for welcome display
     */
    public function latestCheckin(Request $request, Invitation $invitation)
    {
        $this->authorize('view', $invitation);

        // Get the most recent check-in within the last 15 seconds
        $latestGuest = $invitation->guests()
            ->where('is_checked_in', true)
            ->where('checked_in_at', '>=', now()->subSeconds(15))
            ->orderByDesc('checked_in_at')
            ->first();

        if ($latestGuest) {
            return response()->json([
                'has_recent' => true,
                'guest' => [
                    'id' => $latestGuest->id,
                    'name' => $latestGuest->name,
                    'number_of_guests' => $latestGuest->number_of_guests,
                    'checked_in_at' => $latestGuest->checked_in_at->format('H:i'),
                ],
            ]);
        }

        return response()->json([
            'has_recent' => false,
            'guest' => null,
        ]);
    }
}
