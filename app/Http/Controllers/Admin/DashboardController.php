<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Payment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = ["total_users"=>User::where("role","customer")->count(),"total_invitations"=>Invitation::count(),"published_invitations"=>Invitation::where("status","published")->count(),"total_revenue"=>Payment::where("status","paid")->sum("total_amount"),"monthly_revenue"=>Payment::where("status","paid")->whereMonth("paid_at",now()->month)->sum("total_amount"),"pending_payments"=>Payment::where("status","pending")->count()];
        $recentPayments = Payment::with(["user","package"])->where("status","paid")->latest("paid_at")->take(10)->get();
        $recentUsers = User::where("role","customer")->latest()->take(10)->get();
        return view("admin.dashboard", compact("stats","recentPayments","recentUsers"));
    }
}