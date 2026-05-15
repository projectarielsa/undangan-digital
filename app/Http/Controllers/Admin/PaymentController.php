<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request) {
        $query = Payment::with(["user","package"]);
        if ($s = $request->input("status")) $query->where("status", $s);
        $payments = $query->latest()->paginate(20);
        $totalRevenue = Payment::where("status","paid")->sum("total_amount");
        $monthlyRevenue = Payment::where("status","paid")->whereMonth("paid_at",now()->month)->whereYear("paid_at",now()->year)->sum("total_amount");
        return view("admin.payments.index", compact("payments","totalRevenue","monthlyRevenue"));
    }
    public function show(Payment $payment) { $payment->load(["user","package","invitation"]); return view("admin.payments.show", compact("payment")); }
}