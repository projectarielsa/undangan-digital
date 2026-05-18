<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\InvitationTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    public function index() { return view("admin.templates.index", ["templates" => InvitationTemplate::orderBy("sort_order")->paginate(20)]); }
    public function create() { return view("admin.templates.create"); }
    public function store(Request $request) {
        $v = $request->validate(["name"=>"required|string|max:255","category"=>"required|string","blade_view"=>"required|string","color_primary"=>"required|string","color_secondary"=>"required|string","color_accent"=>"required|string","font_heading"=>"required|string","font_body"=>"required|string","description"=>"nullable|string","is_premium"=>"boolean","is_active"=>"boolean"]);
        $v["slug"] = Str::slug($v["name"]);
        $v["is_premium"] = $request->boolean("is_premium");
        $v["is_active"] = $request->boolean("is_active");
        if ($request->hasFile("thumbnail")) $v["thumbnail"] = $request->file("thumbnail")->store("templates", "public");
        InvitationTemplate::create($v);
        return redirect()->route("admin.templates.index")->with("success", "Template dibuat.");
    }
    public function edit(InvitationTemplate $template) { return view("admin.templates.edit", compact("template")); }
    public function update(Request $request, InvitationTemplate $template) {
        $v = $request->validate(["name"=>"required|string|max:255","category"=>"required|string","blade_view"=>"required|string","color_primary"=>"required|string","color_secondary"=>"required|string","color_accent"=>"required|string","font_heading"=>"required|string","font_body"=>"required|string","description"=>"nullable|string","is_premium"=>"boolean","is_active"=>"boolean"]);
        $v["is_premium"] = $request->boolean("is_premium");
        $v["is_active"] = $request->boolean("is_active");
        if ($request->hasFile("thumbnail")) $v["thumbnail"] = $request->file("thumbnail")->store("templates", "public");
        $template->update($v);
        return redirect()->route("admin.templates.index")->with("success", "Template diperbarui.");
    }
    public function destroy(InvitationTemplate $template) { $template->delete(); return redirect()->route("admin.templates.index")->with("success", "Dihapus."); }
}