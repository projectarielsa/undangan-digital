<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Services\QrCheckinService;
use Illuminate\Http\Request;

class QrVerifyController extends Controller
{
    public function __construct(protected QrCheckinService $qrService) {}

    /**
     * Verify QR code and check in guest (public endpoint for scanning)
     */
    public function verify(Request $request, string $code)
    {
        $guest = $this->qrService->verifyAndCheckin($code);

        if (!$guest) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid atau tidak ditemukan.',
                ], 404);
            }
            return view('checkin.invalid');
        }

        $invitation = $guest->invitation;

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Check-in berhasil!',
                'guest' => [
                    'id' => $guest->id,
                    'name' => $guest->name,
                    'number_of_guests' => $guest->number_of_guests,
                    'rsvp_status' => $guest->rsvp_status,
                    'checked_in_at' => $guest->checked_in_at->format('H:i'),
                ],
            ]);
        }

        return view('checkin.success', compact('guest', 'invitation'));
    }

    /**
     * API endpoint untuk scanner
     */
    public function apiVerify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $guest = $this->qrService->verifyAndCheckin($request->code);

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil!',
            'guest' => [
                'id' => $guest->id,
                'name' => $guest->name,
                'number_of_guests' => $guest->number_of_guests,
                'rsvp_status' => $guest->rsvp_status,
                'checked_in_at' => $guest->checked_in_at->format('H:i'),
                'was_already_checked_in' => $guest->checked_in_at->lt(now()->subSeconds(5)),
            ],
        ]);
    }
}
