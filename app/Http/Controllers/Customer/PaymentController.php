<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected MidtransService $midtrans) {}
    public function packages() { $packages = Package::active()->ordered()->get(); return view("customer.payments.packages", compact("packages")); }
    public function checkout(Request $request, Package $package) { $payment = $this->midtrans->createTransaction($request->user(), $package, $request->input("invitation_id")); return view("customer.payments.checkout", compact("payment","package")); }
    public function finish(Request $request) { $payment = Payment::where("order_id", $request->input("order_id"))->first(); return redirect()->route("customer.dashboard")->with($payment?->isPaid() ? "success" : "info", $payment?->isPaid() ? "Pembayaran berhasil!" : "Pembayaran diproses."); }
    public function history(Request $request) { $payments = $request->user()->payments()->with("package")->latest()->paginate(10); return view("customer.payments.history", compact("payments")); }
}