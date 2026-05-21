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
        $this->authorize('update', $invitation);

        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|max:5120',
        ]);

        $user = auth()->user();

        $activeSubscription = method_exists($user, 'activeSubscription')
            ? $user->activeSubscription()
            : null;

        $isPremium = $activeSubscription && ($activeSubscription->is_active ?? true);

        $maxImages = $isPremium ? 20 : 5;

        $existingImages = $invitation->galleries()->count();
        $newImages = count($request->file('images', []));
        $totalImages = $existingImages + $newImages;

        if ($totalImages > $maxImages) {
            return back()
                ->withInput()
                ->with('error', "Paket gratis maksimal {$maxImages} foto. Hapus beberapa foto atau upgrade paket untuk menambah galeri.");
        }

        $order = $invitation->galleries()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $img) {
            $path = $img->store('invitations/gallery/' . $invitation->id, 'public');

            $invitation->galleries()->create([
                'image_path' => $path,
                'sort_order' => ++$order,
            ]);
        }

        return back()->with('success', 'Foto diunggah.');
    }

    public function updateOrder(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer',
        ]);

        foreach ($request->order as $i => $id) {
            Gallery::where('id', $id)
                ->where('invitation_id', $invitation->id)
                ->update(['sort_order' => $i]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(Invitation $invitation, Gallery $gallery)
    {
        $this->authorize('update', $invitation);

        if ($gallery->invitation_id !== $invitation->id) {
            abort(404);
        }

        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return back()->with('success', 'Foto dihapus.');
    }
}