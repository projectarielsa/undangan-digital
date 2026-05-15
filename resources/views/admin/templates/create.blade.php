@extends('layouts.dashboard')
@section('page-title', 'Tambah Template')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.templates.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 space-y-4">
            <div><label class="block text-sm font-medium mb-1">Nama</label><input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
            <div><label class="block text-sm font-medium mb-1">Kategori</label><input type="text" name="category" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
            <div><label class="block text-sm font-medium mb-1">Blade View</label><input type="text" name="blade_view" required placeholder="templates.nama-template" class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
            <div class="grid grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium mb-1">Primary</label><input type="color" name="color_primary" value="#D4AF37" class="w-full h-12 rounded-xl border cursor-pointer"></div>
                <div><label class="block text-sm font-medium mb-1">Secondary</label><input type="color" name="color_secondary" value="#1a1a2e" class="w-full h-12 rounded-xl border cursor-pointer"></div>
                <div><label class="block text-sm font-medium mb-1">Accent</label><input type="color" name="color_accent" value="#f8f0e3" class="w-full h-12 rounded-xl border cursor-pointer"></div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium mb-1">Font Heading</label><input type="text" name="font_heading" value="Playfair Display" class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
                <div><label class="block text-sm font-medium mb-1">Font Body</label><input type="text" name="font_body" value="Lato" class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
            </div>
            <div><label class="block text-sm font-medium mb-1">Deskripsi</label><textarea name="description" rows="3" class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></textarea></div>
            <div><label class="block text-sm font-medium mb-1">Thumbnail</label><input type="file" name="thumbnail" accept="image/*" class="text-sm"></div>
            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2"><input type="checkbox" name="is_premium" value="1" class="rounded text-amber-600"><span class="text-sm">Premium</span></label>
                <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" checked class="rounded text-amber-600"><span class="text-sm">Aktif</span></label>
            </div>
        </div>
        <button type="submit" class="px-8 py-3 bg-amber-600 text-white font-semibold rounded-xl hover:bg-amber-700 transition">Simpan Template</button>
    </form>
</div>
@endsection
