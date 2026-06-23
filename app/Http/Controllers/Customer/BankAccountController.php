<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Invitation;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function store(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:100',
        ]);

        // Max 5 bank accounts per invitation
        if ($invitation->bankAccounts()->count() >= 5) {
            return back()->withErrors(['bank_name' => 'Maksimal 5 rekening bank per undangan.']);
        }

        $order = $invitation->bankAccounts()->max('sort_order') ?? 0;
        $isPrimary = $invitation->bankAccounts()->count() === 0;

        $invitation->bankAccounts()->create([
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'is_primary' => $isPrimary,
            'sort_order' => $order + 1,
        ]);

        return back()->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    public function destroy(Invitation $invitation, BankAccount $bankAccount)
    {
        $this->authorize('update', $invitation);
        $bankAccount->delete();

        // If deleted was primary, make first remaining one primary
        if ($bankAccount->is_primary) {
            $first = $invitation->bankAccounts()->first();
            if ($first) $first->update(['is_primary' => true]);
        }

        return back()->with('success', 'Rekening bank dihapus.');
    }
}
