@extends('layouts.dashboard')
@section('page-title', 'Edit Undangan')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('customer.invitations.index') }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>Kembali</a>
        <div class="flex items-center gap-2">
            @if($invitation->isDraft())<form method="POST" action="{{ route('customer.invitations.publish', $invitation) }}">@csrf<button class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-xl hover:bg-green-700 transition">Publish</button></form>@endif
            @if($invitation->isPublished())<a href="{{ $invitation->getUrl() }}" target="_blank" class="px-4 py-2 border border-gray-200 text-sm font-medium rounded-xl hover:bg-gray-50 transition">Preview</a><form method="POST" action="{{ route('customer.invitations.pause', $invitation) }}">@csrf<button class="px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-xl hover:bg-yellow-700 transition">Pause</button></form>@endif
            <form method="POST" action="{{ route('customer.invitations.duplicate', $invitation) }}">@csrf<button class="px-4 py-2 border border-gray-200 text-sm font-medium rounded-xl hover:bg-gray-50 transition">Duplikat</button></form>
        </div>
    </div>

    @if($errors->any())<div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">@foreach($errors->all() as $error)<p class="text-sm text-red-600">{{ $error }}</p>@endforeach</div>@endif

    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-4 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 text-sm font-medium rounded-full {{ $invitation->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ ucfirst($invitation->status) }}</span>
            <span class="text-sm text-gray-500">Slug: <code class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">{{ $invitation->slug }}</code></span>
        </div>
        <span class="text-sm text-gray-500">{{ $invitation->view_count }} views</span>
    </div>

    <form method="POST" action="{{ route('customer.invitations.update', $invitation) }}" enctype="multipart/form-data" class="space-y-8">
        @csrf @method('PUT')
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Mempelai</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-700 dark:text-gray-300">Mempelai Pria</h4>
                    <input type="text" name="groom_name" value="{{ old('groom_name', $invitation->groom_name) }}" required placeholder="Nama Lengkap" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <input type="text" name="groom_father" value="{{ old('groom_father', $invitation->groom_father) }}" placeholder="Nama Ayah" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <input type="text" name="groom_mother" value="{{ old('groom_mother', $invitation->groom_mother) }}" placeholder="Nama Ibu" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <input type="text" name="groom_instagram" value="{{ old('groom_instagram', $invitation->groom_instagram) }}" placeholder="@instagram" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-700 dark:text-gray-300">Mempelai Wanita</h4>
                    <input type="text" name="bride_name" value="{{ old('bride_name', $invitation->bride_name) }}" required placeholder="Nama Lengkap" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <input type="text" name="bride_father" value="{{ old('bride_father', $invitation->bride_father) }}" placeholder="Nama Ayah" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <input type="text" name="bride_mother" value="{{ old('bride_mother', $invitation->bride_mother) }}" placeholder="Nama Ibu" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <input type="text" name="bride_instagram" value="{{ old('bride_instagram', $invitation->bride_instagram) }}" placeholder="@instagram" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Acara</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="block text-sm text-gray-600 mb-1">Tanggal *</label><input type="date" name="event_date" value="{{ old('event_date', $invitation->event_date->format('Y-m-d')) }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                <div><label class="block text-sm text-gray-600 mb-1">Jam Mulai *</label><input type="time" name="event_time_start" value="{{ old('event_time_start', $invitation->event_time_start) }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                <div><label class="block text-sm text-gray-600 mb-1">Tempat *</label><input type="text" name="event_venue" value="{{ old('event_venue', $invitation->event_venue) }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                <div><label class="block text-sm text-gray-600 mb-1">Google Maps</label><input type="url" name="event_maps_url" value="{{ old('event_maps_url', $invitation->event_maps_url) }}" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                <div class="md:col-span-2"><label class="block text-sm text-gray-600 mb-1">Alamat</label><textarea name="event_address" rows="2" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">{{ old('event_address', $invitation->event_address) }}</textarea></div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Konten & Media</h3>
            <div class="space-y-4">
                <textarea name="opening_text" rows="3" placeholder="Kata Pembuka" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">{{ old('opening_text', $invitation->opening_text) }}</textarea>
                <textarea name="closing_text" rows="3" placeholder="Kata Penutup" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">{{ old('closing_text', $invitation->closing_text) }}</textarea>
                <div class="grid md:grid-cols-2 gap-4">
                    <input type="text" name="dress_code" value="{{ old('dress_code', $invitation->dress_code) }}" placeholder="Dress Code" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <input type="text" name="slug" value="{{ old('slug', $invitation->slug) }}" placeholder="Custom Slug" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div><label class="block text-sm text-gray-600 mb-1">Cover Image</label><input type="file" name="cover_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700"></div>
                    <div><label class="block text-sm text-gray-600 mb-1">Music (MP3)</label><input type="file" name="music_file" accept=".mp3,.wav" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700"></div>
                </div>
            </div>
        </div>

        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-amber-600 to-amber-700 text-white font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all">Simpan Perubahan</button>
    </form>

    <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <div class="flex items-center justify-between">
            <div><h3 class="font-semibold text-gray-900 dark:text-white">Kelola Tamu</h3><p class="text-sm text-gray-500">Tambah tamu, lihat RSVP, dan kirim undangan personal</p></div>
            <a href="{{ route('customer.guests.index', $invitation) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 transition">Kelola Tamu &rarr;</a>
        </div>
    </div>
</div>
@endsection
