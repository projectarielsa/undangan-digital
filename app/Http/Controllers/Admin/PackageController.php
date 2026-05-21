<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('sort_order')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_photos' => 'required|integer|min:0',
            'max_guests' => 'required|integer|min:0',
            'max_templates' => 'required|integer|min:0',
            'has_rsvp' => 'boolean',
            'has_music' => 'boolean',
            'has_guestbook' => 'boolean',
            'has_gallery' => 'boolean',
            'has_countdown' => 'boolean',
            'has_love_story' => 'boolean',
            'has_digital_envelope' => 'boolean',
            'has_qr_checkin' => 'boolean',
            'has_custom_domain' => 'boolean',
            'has_analytics' => 'boolean',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'features' => 'nullable|string',
        ]);

        // Parse features from textarea (one per line)
        if (!empty($validated['features'])) {
            $validated['features'] = array_filter(array_map('trim', explode("\n", $validated['features'])));
        } else {
            $validated['features'] = [];
        }

        // Handle checkboxes
        $booleans = ['has_rsvp','has_music','has_guestbook','has_gallery','has_countdown','has_love_story','has_digital_envelope','has_qr_checkin','has_custom_domain','has_analytics','is_active','is_featured'];
        foreach ($booleans as $field) {
            $validated[$field] = $request->has($field);
        }

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket "' . $package->name . '" berhasil diperbarui.');
    }
}
