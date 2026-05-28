<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        protected MidtransService $midtrans
    ) {}

    /**
     * List available packages
     */
    public function packages()
    {
        $packages = Package::active()
            ->ordered()
            ->get();

        return view('customer.payments.packages', compact('packages'));
    }

    /**
     * Checkout payment
     */
    public function checkout(Request $request, Package $package)
    {
        // Cari payment pending yang masih aktif
        $payment = Payment::where('user_id', $request->user()->id)
            ->where('package_id', $package->id)
            ->where('status', 'pending')
            ->where('expired_at', '>', now())
            ->latest()
            ->first();

        // Jika belum ada payment aktif, buat baru
        if (!$payment) {
            $payment = $this->midtrans->createTransaction(
                $request->user(),
                $package,
                $request->input('invitation_id')
            );
        }

        return view('customer.payments.checkout', compact('payment', 'package'));
    }

    /**
     * Finish payment callback
     */
    public function finish(Request $request)
    {
        $payment = Payment::where(
            'order_id',
            $request->input('order_id')
        )->first();

        return redirect()
            ->route('customer.dashboard')
            ->with(
                $payment?->isPaid() ? 'success' : 'info',
                $payment?->isPaid()
                    ? 'Pembayaran berhasil!'
                    : 'Pembayaran sedang diproses.'
            );
    }

    /**
     * Payment history
     */
    public function history(Request $request)
    {
        $payments = $request->user()
            ->payments()
            ->with('package')
            ->latest()
            ->paginate(10);

        return view('customer.payments.history', compact('payments'));
    }
}