<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where("role","customer");
        if ($s = $request->input("search")) $query->where(fn($q) => $q->where("name","like","%$s%")->orWhere("email","like","%$s%"));
        return view("admin.users.index", ["users" => $query->withCount("invitations")->with("subscriptions")->latest()->paginate(20)]);
    }
    public function show(User $user) { 
        $user->load(["invitations","payments","subscriptions.package"]); 
        $packages = Package::active()->ordered()->get();
        return view("admin.users.show", compact("user", "packages")); 
    }
    public function toggleActive(User $user) { $user->update(["is_active"=>!$user->is_active]); return back()->with("success", "User "  . ($user->is_active ? "diaktifkan" : "dinonaktifkan") . "."); }
    
    public function addSubscription(Request $request, User $user)
    {
        $request->validate([
            "package_id" => "required|exists:packages,id",
            "duration_days" => "required|integer|min:1|max:365",
        ]);
        
        $package = Package::findOrFail($request->package_id);
        
        // Create subscription
        Subscription::create([
            "user_id" => $user->id,
            "package_id" => $package->id,
            "status" => "active",
            "starts_at" => now(),
            "expires_at" => now()->addDays($request->duration_days),
        ]);
        
        return back()->with("success", "Langganan {$package->name} berhasil ditambahkan untuk {$user->name} selama {$request->duration_days} hari.");
    }
    
    public function cancelSubscription(Subscription $subscription)
    {
        $subscription->update(["status" => "cancelled"]);
        return back()->with("success", "Langganan berhasil dibatalkan.");
    }
    
    public function extendSubscription(Request $request, Subscription $subscription)
    {
        $request->validate(["days" => "required|integer|min:1|max:365"]);
        $subscription->update(["expires_at" => $subscription->expires_at->addDays($request->days)]);
        return back()->with("success", "Langganan diperpanjang {$request->days} hari.");
    }
}