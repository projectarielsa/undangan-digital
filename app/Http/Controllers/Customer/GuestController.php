<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\ImportGuestRequest;
use App\Http\Requests\Customer\StoreGuestRequest;
use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GuestController extends Controller
{
    /**
     * Display the list of guests for an invitation.
     */
    public function index(Invitation $invitation): View
    {
        $this->authorize('view', $invitation);

        $guests = $invitation->guests()
            ->latest()
            ->paginate(20);

        return view('customer.guests.index', [
            'invitation' => $invitation,
            'guests' => $guests,
            'rsvpStats' => $invitation->getRsvpStats(),
        ]);
    }

    /**
     * Store a new guest for an invitation.
     */
    public function store(StoreGuestRequest $request, Invitation $invitation): RedirectResponse
    {
        $invitation->guests()->create($request->validated());

        return back()->with('success', 'Tamu berhasil ditambahkan.');
    }

    /**
     * Delete a guest from an invitation.
     */
    public function destroy(Invitation $invitation, Guest $guest): RedirectResponse
    {
        $this->authorize('update', $invitation);

        $guest->delete();

        return back()->with('success', 'Tamu berhasil dihapus.');
    }

    /**
     * Import guests from a file (CSV/Excel).
     */
    public function import(ImportGuestRequest $request, Invitation $invitation): RedirectResponse
    {
        $file = $request->file('file');
        $imported = 0;
        $skipped = 0;

        $extension = strtolower($file->getClientOriginalExtension());

        if (in_array($extension, ['csv', 'txt'])) {
            $handle = fopen($file->getPathname(), 'r');
            
            // Skip header row
            fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {
                if (!empty(trim($row[0] ?? ''))) {
                    $invitation->guests()->create([
                        'name' => trim($row[0]),
                        'phone' => trim($row[1] ?? '') ?: null,
                        'email' => trim($row[2] ?? '') ?: null,
                    ]);
                    $imported++;
                } else {
                    $skipped++;
                }
            }

            fclose($handle);
        }

        $message = "Berhasil mengimpor {$imported} tamu.";
        if ($skipped > 0) {
            $message .= " ({$skipped} baris dilewati karena nama kosong)";
        }

        return back()->with('success', $message);
    }
}