@extends('layouts.dashboard')
@section('page-title', 'Buat Undangan Baru')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-4xl">
    <div class="mb-6"><a href="{{ route('customer.invitations.index') }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>Kembali</a></div>

    @if($errors->any())<div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 rounded-2xl">@foreach($errors->all() as $error)<p class="text-sm text-red-600">{{ $error }}</p>@endforeach</div>@endif

    <form method="POST" action="{{ route('customer.invitations.store') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        <!-- Template Selection -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pilih Template</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($templates as $template)
                <label class="cursor-pointer group">
                    <input type="radio" name="template_id" value="{{ $template->id }}" class="peer hidden" {{ $loop->first ? 'checked' : '' }}>
                    <div class="p-4 rounded-2xl border-2 border-gray-200 dark:border-gray-600 peer-checked:border-amber-500 peer-checked:bg-amber-50 dark:peer-checked:bg-amber-900/10 transition-all">
                        <div class="aspect-[3/4] rounded-xl mb-3 flex items-center justify-center" style="background: linear-gradient(135deg, {{ $template->color_primary }}20, {{ $template->color_secondary }}20)">
                            <span class="text-xs font-medium" style="color: {{ $template->color_primary }}">{{ $template->name }}</span>
                        </div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $template->name }}</p>
                        @if($template->is_premium)<span class="text-xs text-amber-600 font-medium">Premium</span>@else<span class="text-xs text-gray-500">Gratis</span>@endif
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Couple Info -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Mempelai</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-700 dark:text-gray-300">Mempelai Pria</h4>
                    <div><label class="block text-sm text-gray-600 mb-1">Nama Lengkap *</label><input type="text" name="groom_name" value="{{ old('groom_name') }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-sm text-gray-600 mb-1">Nama Ayah</label><input type="text" name="groom_father" value="{{ old('groom_father') }}" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-sm text-gray-600 mb-1">Nama Ibu</label><input type="text" name="groom_mother" value="{{ old('groom_mother') }}" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-sm text-gray-600 mb-1">Instagram</label><input type="text" name="groom_instagram" value="{{ old('groom_instagram') }}" placeholder="@username" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-sm text-gray-600 mb-1">Foto</label><input type="file" name="groom_photo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100"></div>
                </div>
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-700 dark:text-gray-300">Mempelai Wanita</h4>
                    <div><label class="block text-sm text-gray-600 mb-1">Nama Lengkap *</label><input type="text" name="bride_name" value="{{ old('bride_name') }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-sm text-gray-600 mb-1">Nama Ayah</label><input type="text" name="bride_father" value="{{ old('bride_father') }}" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-sm text-gray-600 mb-1">Nama Ibu</label><input type="text" name="bride_mother" value="{{ old('bride_mother') }}" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-sm text-gray-600 mb-1">Instagram</label><input type="text" name="bride_instagram" value="{{ old('bride_instagram') }}" placeholder="@username" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-sm text-gray-600 mb-1">Foto</label><input type="file" name="bride_photo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100"></div>
                </div>
            </div>
        </div>

        <!-- Event Details -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Acara</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="block text-sm text-gray-600 mb-1">Tanggal Acara *</label><input type="date" name="event_date" value="{{ old('event_date') }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                <div><label class="block text-sm text-gray-600 mb-1">Jam Mulai *</label><input type="time" name="event_time_start" value="{{ old('event_time_start') }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                <div><label class="block text-sm text-gray-600 mb-1">Tempat Acara *</label><input type="text" name="event_venue" value="{{ old('event_venue') }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                <div><label class="block text-sm text-gray-600 mb-1">Jam Selesai</label><input type="time" name="event_time_end" value="{{ old('event_time_end') }}" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                <div class="md:col-span-2"><label class="block text-sm text-gray-600 mb-1">Alamat Lengkap</label><textarea name="event_address" rows="2" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">{{ old('event_address') }}</textarea></div>
                <div class="md:col-span-2"><label class="block text-sm text-gray-600 mb-1">Link Google Maps</label><input type="url" name="event_maps_url" value="{{ old('event_maps_url') }}" placeholder="https://maps.google.com/..." class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Konten Undangan</h3>
            <div class="space-y-4">
                <div><label class="block text-sm text-gray-600 mb-1">Kata Pembuka</label><textarea name="opening_text" rows="3" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="Dengan memohon rahmat dan ridho Allah SWT...">{{ old('opening_text') }}</textarea></div>
                <div><label class="block text-sm text-gray-600 mb-1">Kata Penutup</label><textarea name="closing_text" rows="3" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="Merupakan suatu kebahagiaan bagi kami...">{{ old('closing_text') }}</textarea></div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div><label class="block text-sm text-gray-600 mb-1">Dress Code</label><input type="text" name="dress_code" value="{{ old('dress_code') }}" placeholder="Sage Green / Formal" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-sm text-gray-600 mb-1">Cover Image</label><input type="file" name="cover_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100"></div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-amber-600 to-amber-700 text-white font-semibold rounded-xl shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all">Buat Undangan</button>
            <a href="{{ route('customer.invitations.index') }}" class="px-8 py-3 text-gray-600 hover:text-gray-900 font-medium transition">Batal</a>
        </div>
    </form>
</div>
@endsection
