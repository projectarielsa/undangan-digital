<?php
namespace App\Http\Controllers;
use App\Models\InvitationTemplate;
use App\Models\Package;
use App\Models\Testimonial;

class LandingPageController extends Controller
{
    public function index()
    {
        $packages = Package::active()->ordered()->get();
        $templates = InvitationTemplate::active()->orderBy("sort_order")->take(6)->get();
        $testimonials = Testimonial::active()->take(6)->get();
        return view("landing", compact("packages","templates","testimonials"));
    }
}