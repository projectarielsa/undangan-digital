<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
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
    public function show(User $user) { $user->load(["invitations","payments","subscriptions"]); return view("admin.users.show", compact("user")); }
    public function toggleActive(User $user) { $user->update(["is_active"=>!$user->is_active]); return back()->with("success", "User "  . ($user->is_active ? "diaktifkan" : "dinonaktifkan") . "."); }
}