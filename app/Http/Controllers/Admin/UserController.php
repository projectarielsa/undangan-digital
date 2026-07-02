<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where("role","customer");
        if ($s = $request->input("search")) { $safe = addcslashes(trim($s), "%_"); $query->where(fn($q) => $q->where("name","like","%{$safe}%")->orWhere("email","like","%{$safe}%")); }
        return view("admin.users.index", ["users" => $query->withCount("invitations")->with("subscriptions")->latest()->paginate(20)]);
    }
    public function show(User $user) { 
        $user->load(["invitations","payments","subscriptions.package"]); 
        $packages = Package::active()->ordered()->get();
        return view("admin.users.show", compact("user", "packages")); 
    }
    public function toggleActive(User $user) { 
        $old = $user->is_active;
        $user->update(["is_active"=>!$user->is_active]); 
        ActivityLog::create([
            "user_id" => auth()->id(),
            "action" => "user." . ($user->is_active ? "activated" : "deactivated"),
            "subject_type" => get_class($user),
            "subject_id" => $user->id,
            "properties" => ["old_is_active" => $old, "new_is_active" => $user->is_active],
        ]);
        return back()->with("success", "User "  . ($user->is_active ? "diaktifkan" : "dinonaktifkan") . "."); 
    }
    
    public function addSubscription(Request $request, User $user)
    {
        $request->validate([
            "package_id" => "required|exists:packages,id",
            "duration_days" => "required|integer|min:1|max:365",
        ]);
        
        $package = Package::findOrFail($request->package_id);
        $days = (int) $request->duration_days;
        
        // Create subscription
        Subscription::create([
            "user_id" => $user->id,
            "package_id" => $package->id,
            "status" => "active",
            "starts_at" => now(),
            "expires_at" => now()->addDays($days),
        ]);
        
        return back()->with("success", "Langganan {$package->name} berhasil ditambahkan untuk {$user->name} selama {$days} hari.");
    }
    
    public function cancelSubscription(Subscription $subscription)
    {
        $subscription->update(["status" => "cancelled"]);
        return back()->with("success", "Langganan berhasil dibatalkan.");
    }
    
    public function extendSubscription(Request $request, Subscription $subscription)
    {
        $request->validate(["days" => "required|integer|min:1|max:365"]);
        $days = (int) $request->days;
        $subscription->update(["expires_at" => $subscription->expires_at->addDays($days)]);
        return back()->with("success", "Langganan diperpanjang {$days} hari.");
    }
}