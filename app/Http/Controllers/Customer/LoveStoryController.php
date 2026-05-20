<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;

class LoveStoryController extends Controller
{
    /**
     * Show love story editor
     */
    public function edit(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        // Check if user has love story feature
        if (!$invitation->hasLoveStoryFeature()) {
            return redirect()->route('customer.packages')
                ->with('error', 'Fitur Love Story Timeline hanya tersedia untuk paket Premium dan Exclusive. Silakan upgrade paket Anda.');
        }

        $loveStory = $invitation->love_story ?? [];

        return view('customer.invitations.love-story', compact('invitation', 'loveStory'));
    }

    /**
     * Update love story
     */
    public function update(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        if (!$invitation->hasLoveStoryFeature()) {
            return back()->with('error', 'Fitur Love Story tidak tersedia untuk paket Anda.');
        }

        $validated = $request->validate([
            'love_story' => 'nullable|array|max:10',
            'love_story.*.date' => 'nullable|string|max:100',
            'love_story.*.title' => 'required|string|max:255',
            'love_story.*.description' => 'required|string|max:1000',
            'love_story.*.image' => 'nullable|image|max:2048',
        ]);

        $loveStory = [];
        $existingStory = $invitation->love_story ?? [];

        if (isset($validated['love_story'])) {
            foreach ($validated['love_story'] as $index => $story) {
                $storyData = [
                    'date' => $story['date'] ?? null,
                    'title' => $story['title'],
                    'description' => $story['description'],
                    'image' => $existingStory[$index]['image'] ?? null,
                ];

                // Handle image upload
                if ($request->hasFile("love_story.{$index}.image")) {
                    $path = $request->file("love_story.{$index}.image")->store('love-story', 'public');
                    $storyData['image'] = $path;
                }

                $loveStory[] = $storyData;
            }
        }

        $invitation->update(['love_story' => $loveStory]);

        return back()->with('success', 'Love Story berhasil diperbarui!');
    }

    /**
     * Delete a love story entry
     */
    public function deleteEntry(Request $request, Invitation $invitation, int $index)
    {
        $this->authorize('update', $invitation);

        $loveStory = $invitation->love_story ?? [];

        if (isset($loveStory[$index])) {
            // Delete image if exists
            if (!empty($loveStory[$index]['image'])) {
                \Storage::disk('public')->delete($loveStory[$index]['image']);
            }
            
            array_splice($loveStory, $index, 1);
            $invitation->update(['love_story' => array_values($loveStory)]);
        }

        return back()->with('success', 'Entry Love Story berhasil dihapus.');
    }
}
