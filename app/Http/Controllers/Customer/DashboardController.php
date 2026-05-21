<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $invitations = $user->invitations()->latest()->take(5)->get();
        $activeSubscription = $user->activeSubscription();
        $stats = ["total_invitations" => $user->invitations()->count(), "published" => $user->invitations()->where("status","published")->count(), "total_views" => $user->invitations()->sum("view_count"), "total_guests" => $user->invitations()->withCount("guests")->get()->sum("guests_count")];
        return view("customer.dashboard", compact("invitations", "activeSubscription", "stats"));
    }
}