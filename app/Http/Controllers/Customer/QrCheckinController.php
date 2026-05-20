<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QrCheckinController extends Controller
{
    public function index(Invitation $invitation)
    {
        $this->authorize('view', $invitation);
        
        // Check if user has QR check-in feature
        $package = $invitation->package;
        $hasQrCheckin = $package && $package->has_qr_checkin;
        
        if (!$hasQrCheckin) {
            return view('customer.qr-checkin.locked', compact('invitation'));
        }
        
        $guests = $invitation->guests()
            ->orderBy('is_checked_in')
            ->orderBy('name')
            ->paginate(20);
        
        $stats = [
            'total' => $invitation->guests()->count(),
            'checked_in' => $invitation->guests()->where('is_checked_in', true)->count(),
            'attending' => $invitation->guests()->where('rsvp_status', 'attending')->count(),
        ];
        
        return view('customer.qr-checkin.index', compact('invitation', 'guests', 'stats'));
    }

    public function generateQr(Invitation $invitation, Guest $guest)
    {
        $this->authorize('update', $invitation);
        
        // Generate unique QR code if not exists
        if (!$guest->qr_code) {
            $guest->update(['qr_code' => Str::uuid()->toString()]);
        }
        
        // Generate QR code using Google Charts API
        $checkinUrl = route('checkin.scan', ['code' => $guest->qr_code]);
        $qrUrl = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . urlencode($checkinUrl) . '&choe=UTF-8';
        
        return redirect($qrUrl);
    }

    public function generateAllQr(Invitation $invitation)
    {
        $this->authorize('update', $invitation);
        
        $guests = $invitation->guests()->whereNull('qr_code')->get();
        
        foreach ($guests as $guest) {
            $guest->update(['qr_code' => Str::uuid()->toString()]);
        }
        
        return back()->with('success', "QR code berhasil dibuat untuk {$guests->count()} tamu.");
    }

    public function scanner(Invitation $invitation)
    {
        $this->authorize('view', $invitation);
        
        $package = $invitation->package;
        if (!$package || !$package->has_qr_checkin) {
            return redirect()->route('customer.invitations.show', $invitation)
                ->with('error', 'Fitur QR Check-in tidak tersedia untuk paket Anda.');
        }
        
        return view('customer.qr-checkin.scanner', compact('invitation'));
    }

    public function processCheckin(Request $request)
    {
        $request->validate(['qr_code' => 'required|string']);
        
        $guest = Guest::where('qr_code', $request->qr_code)->first();
        
        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau tidak ditemukan.'
            ], 404);
        }
        
        if ($guest->is_checked_in) {
            return response()->json([
                'success' => false,
                'message' => 'Tamu sudah check-in sebelumnya.',
                'guest' => [
                    'name' => $guest->name,
                    'checked_in_at' => $guest->checked_in_at->format('d M Y H:i'),
                ]
            ], 400);
        }
        
        $guest->update([
            'is_checked_in' => true,
            'checked_in_at' => now(),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil!',
            'guest' => [
                'name' => $guest->name,
                'number_of_guests' => $guest->number_of_guests,
                'rsvp_status' => $guest->rsvp_status,
                'checked_in_at' => $guest->checked_in_at->format('d M Y H:i'),
            ]
        ]);
    }

    public function manualCheckin(Request $request, Invitation $invitation, Guest $guest)
    {
        $this->authorize('update', $invitation);
        
        $guest->update([
            'is_checked_in' => true,
            'checked_in_at' => now(),
        ]);
        
        return back()->with('success', "Tamu {$guest->name} berhasil check-in.");
    }

    public function undoCheckin(Request $request, Invitation $invitation, Guest $guest)
    {
        $this->authorize('update', $invitation);
        
        $guest->update([
            'is_checked_in' => false,
            'checked_in_at' => null,
        ]);
        
        return back()->with('success', "Check-in {$guest->name} dibatalkan.");
    }

    public function downloadQrCard(Invitation $invitation, Guest $guest)
    {
        $this->authorize('view', $invitation);
        
        if (!$guest->qr_code) {
            $guest->update(['qr_code' => Str::uuid()->toString()]);
        }
        
        return view('customer.qr-checkin.card', compact('invitation', 'guest'));
    }
}
