@extends('layouts.dashboard')
@section('page-title', 'Edit Template')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.templates.update', $template) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 space-y-4">
            <div><label class="block text-sm font-medium mb-1">Nama</label><input type="text" name="name" value="{{ $template->name }}" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
            <div><label class="block text-sm font-medium mb-1">Kategori</label><input type="text" name="category" value="{{ $template->category }}" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
            <div><label class="block text-sm font-medium mb-1">Blade View</label><input type="text" name="blade_view" value="{{ $template->blade_view }}" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
            <div class="grid grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium mb-1">Primary</label><input type="color" name="color_primary" value="{{ $template->color_primary }}" class="w-full h-12 rounded-xl border cursor-pointer"></div>
                <div><label class="block text-sm font-medium mb-1">Secondary</label><input type="color" name="color_secondary" value="{{ $template->color_secondary }}" class="w-full h-12 rounded-xl border cursor-pointer"></div>
                <div><label class="block text-sm font-medium mb-1">Accent</label><input type="color" name="color_accent" value="{{ $template->color_accent }}" class="w-full h-12 rounded-xl border cursor-pointer"></div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium mb-1">Font Heading</label><input type="text" name="font_heading" value="{{ $template->font_heading }}" class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
                <div><label class="block text-sm font-medium mb-1">Font Body</label><input type="text" name="font_body" value="{{ $template->font_body }}" class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
            </div>
            <div><label class="block text-sm font-medium mb-1">Deskripsi</label><textarea name="description" rows="3" class="w-full px-4 py-3 bg-gray-50 border rounded-xl">{{ $template->description }}</textarea></div>
            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2"><input type="checkbox" name="is_premium" value="1" {{ $template->is_premium ? 'checked' : '' }} class="rounded text-amber-600"><span class="text-sm">Premium</span></label>
                <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ $template->is_active ? 'checked' : '' }} class="rounded text-amber-600"><span class="text-sm">Aktif</span></label>
            </div>
        </div>
        <button type="submit" class="px-8 py-3 bg-amber-600 text-white font-semibold rounded-xl hover:bg-amber-700 transition">Simpan Perubahan</button>
    </form>
</div>
@endsection
