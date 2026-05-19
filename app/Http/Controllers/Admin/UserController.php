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
        return view("admin.users.index", ["users" => $query->withCount("invitations")->latest()->paginate(20)]);
    }
    public function show(User $user)
    {
        $user->load(["invitations","payments","subscriptions.package"]);
        $packages = Package::active()->ordered()->get();
        $activeSubscription = $user->activeSubscription();
        return view("admin.users.show", compact("user","packages","activeSubscription"));
    }
    public function toggleActive(User $user) { $user->update(["is_active"=>!$user->is_active]); return back()->with("success", "User "  . ($user->is_active ? "diaktifkan" : "dinonaktifkan") . "."); }

    public function grantSubscription(Request $request, User $user)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'duration_days' => 'required|integer|min:1|max:3650',
        ]);

        $package = Package::findOrFail($request->package_id);

        // Expire existing active subscription
        Subscription::where('user_id', $user->id)->where('status', 'active')->update(['status' => 'expired']);

        // Create new subscription
        Subscription::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'payment_id' => null,
            'invitation_id' => null,
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => now()->addDays((int) $request->duration_days),
        ]);

        return back()->with('success', "Berhasil! {$user->name} sekarang berlangganan paket {$package->name} selama {$request->duration_days} hari.");
    }

    public function revokeSubscription(User $user)
    {
        Subscription::where('user_id', $user->id)->where('status', 'active')->update(['status' => 'expired']);
        return back()->with('success', "Langganan {$user->name} telah dicabut.");
    }
}