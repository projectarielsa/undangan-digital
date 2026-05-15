<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function store(Request $request, Invitation $invitation)
    {
        $this->authorize("update", $invitation);
        $request->validate(["images"=>"required|array|max:20","images.*"=>"image|max:5120"]);
        $order = $invitation->galleries()->max("sort_order") ?? 0;
        foreach ($request->file("images") as $img) { $path = $img->store("invitations/gallery/".$invitation->id, "public"); $invitation->galleries()->create(["image_path"=>$path,"sort_order"=>++$order]); }
        return back()->with("success", "Foto diunggah.");
    }
    public function updateOrder(Request $request, Invitation $invitation) { $this->authorize("update", $invitation); foreach ($request->order as $i => $id) Gallery::where("id",$id)->where("invitation_id",$invitation->id)->update(["sort_order"=>$i]); return response()->json(["success"=>true]); }
    public function destroy(Invitation $invitation, Gallery $gallery) { $this->authorize("update", $invitation); Storage::disk("public")->delete($gallery->image_path); $gallery->delete(); return back()->with("success", "Foto dihapus."); }
}