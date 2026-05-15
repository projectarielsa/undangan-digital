@extends('layouts.dashboard')
@section('page-title', 'Edit Undangan')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-4xl">
    <!-- Header Actions -->
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('customer.invitations.index') }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>Kembali
        </a>
        <div class="flex items-center gap-2 flex-wrap">
            @if($invitation->isDraft())
            <form method="POST" action="{{ route('customer.invitations.publish', $invitation) }}">@csrf
                <button class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-xl hover:bg-green-700 transition">Publish</button>
            </form>
            @endif
            @if($invitation->isPublished())
            <a href="{{ $invitation->getUrl() }}" target="_blank" class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition">Preview</a>
            <form method="POST" action="{{ route('customer.invitations.pause', $invitation) }}">@csrf
                <button class="px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-xl hover:bg-yellow-700 transition">Pause</button>
            </form>
            @endif
            <form method="POST" action="{{ route('customer.invitations.duplicate', $invitation) }}">@csrf
                <button class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition">Duplikat</button>
            </form>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl">
        @foreach($errors->all() as $error)<p class="text-sm text-red-600 dark:text-red-400">{{ $error }}</p>@endforeach
    </div>
    @endif

    <!-- Status Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-4 mb-6 flex items-center justify-between flex-wrap gap-2">
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $invitation->status === 'published' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($invitation->status === 'paused' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600') }}">{{ ucfirst($invitation->status) }}</span>
            <span class="text-sm text-gray-500 dark:text-gray-400">URL: <code class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded text-xs">{{ url('/' . $invitation->slug) }}</code></span>
        </div>
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($invitation->view_count) }} views</span>
    </div>

    <!-- ====== MAIN FORM ====== -->
    <form method="POST" action="{{ route('customer.invitations.update', $invitation) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        <!-- 1. Informasi Mempelai -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Informasi Mempelai</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Data lengkap kedua mempelai</p>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <h4 class="text-sm font-medium text-amber-700 dark:text-amber-400 uppercase tracking-wide">Mempelai Pria</h4>
                    <div><label class="block text-xs text-gray-500 mb-1">Nama Lengkap *</label><input type="text" name="groom_name" value="{{ old('groom_name', $invitation->groom_name) }}" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-xs text-gray-500 mb-1">Nama Ayah</label><input type="text" name="groom_father" value="{{ old('groom_father', $invitation->groom_father) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-xs text-gray-500 mb-1">Nama Ibu</label><input type="text" name="groom_mother" value="{{ old('groom_mother', $invitation->groom_mother) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-xs text-gray-500 mb-1">Instagram</label><input type="text" name="groom_instagram" value="{{ old('groom_instagram', $invitation->groom_instagram) }}" placeholder="@username" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-xs text-gray-500 mb-1">Foto Mempelai Pria</label><input type="file" name="groom_photo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                    @if($invitation->groom_photo)<p class="text-xs text-green-600 mt-1">✓ Foto sudah diupload</p>@endif</div>
                </div>
                <div class="space-y-3">
                    <h4 class="text-sm font-medium text-amber-700 dark:text-amber-400 uppercase tracking-wide">Mempelai Wanita</h4>
                    <div><label class="block text-xs text-gray-500 mb-1">Nama Lengkap *</label><input type="text" name="bride_name" value="{{ old('bride_name', $invitation->bride_name) }}" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-xs text-gray-500 mb-1">Nama Ayah</label><input type="text" name="bride_father" value="{{ old('bride_father', $invitation->bride_father) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-xs text-gray-500 mb-1">Nama Ibu</label><input type="text" name="bride_mother" value="{{ old('bride_mother', $invitation->bride_mother) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-xs text-gray-500 mb-1">Instagram</label><input type="text" name="bride_instagram" value="{{ old('bride_instagram', $invitation->bride_instagram) }}" placeholder="@username" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-xs text-gray-500 mb-1">Foto Mempelai Wanita</label><input type="file" name="bride_photo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                    @if($invitation->bride_photo)<p class="text-xs text-green-600 mt-1">✓ Foto sudah diupload</p>@endif</div>
                </div>
            </div>
        </div>

        <!-- 2. Detail Acara -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Detail Acara</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Waktu dan tempat pernikahan</p>
            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="block text-xs text-gray-500 mb-1">Tanggal Acara *</label><input type="date" name="event_date" value="{{ old('event_date', $invitation->event_date->format('Y-m-d')) }}" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                <div><label class="block text-xs text-gray-500 mb-1">Jam Mulai *</label><input type="time" name="event_time_start" value="{{ old('event_time_start', $invitation->event_time_start) }}" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                <div><label class="block text-xs text-gray-500 mb-1">Jam Selesai</label><input type="time" name="event_time_end" value="{{ old('event_time_end', $invitation->event_time_end) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                <div><label class="block text-xs text-gray-500 mb-1">Tempat / Venue *</label><input type="text" name="event_venue" value="{{ old('event_venue', $invitation->event_venue) }}" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                <div class="md:col-span-2"><label class="block text-xs text-gray-500 mb-1">Alamat Lengkap</label><textarea name="event_address" rows="2" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">{{ old('event_address', $invitation->event_address) }}</textarea></div>
                <div class="md:col-span-2"><label class="block text-xs text-gray-500 mb-1">Link Google Maps</label><input type="url" name="event_maps_url" value="{{ old('event_maps_url', $invitation->event_maps_url) }}" placeholder="https://maps.google.com/..." class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
            </div>
        </div>

        <!-- 3. Konten Undangan -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Konten Undangan</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Kata-kata pembuka, penutup, dan pengaturan</p>
            <div class="space-y-4">
                <div><label class="block text-xs text-gray-500 mb-1">Kata Pembuka</label><textarea name="opening_text" rows="3" placeholder="Contoh: Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan..." class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">{{ old('opening_text', $invitation->opening_text) }}</textarea></div>
                <div><label class="block text-xs text-gray-500 mb-1">Kata Penutup</label><textarea name="closing_text" rows="3" placeholder="Contoh: Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila..." class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">{{ old('closing_text', $invitation->closing_text) }}</textarea></div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div><label class="block text-xs text-gray-500 mb-1">Dress Code</label><input type="text" name="dress_code" value="{{ old('dress_code', $invitation->dress_code) }}" placeholder="Contoh: Sage Green / Formal" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-xs text-gray-500 mb-1">Custom URL Slug</label><input type="text" name="slug" value="{{ old('slug', $invitation->slug) }}" placeholder="ariel-rina" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div><label class="block text-xs text-gray-500 mb-1">Cover Image</label><input type="file" name="cover_image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">@if($invitation->cover_image)<p class="text-xs text-green-600 mt-1">✓ Cover sudah diupload</p>@endif</div>
                    <div><label class="block text-xs text-gray-500 mb-1">Background Music (MP3)</label><input type="file" name="music_file" accept=".mp3,.wav" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">@if($invitation->music_url)<p class="text-xs text-green-600 mt-1">✓ Musik sudah diupload</p>@endif</div>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="music_autoplay" value="1" {{ old('music_autoplay', $invitation->music_autoplay) ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                    <label class="text-sm text-gray-600 dark:text-gray-400">Autoplay musik saat undangan dibuka</label>
                </div>
            </div>
        </div>

        <!-- 4. Amplop Digital -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Amplop Digital</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Informasi transfer bank dan QRIS untuk hadiah digital</p>
            <div class="space-y-4">
                <div><label class="block text-xs text-gray-500 mb-1">Informasi Hadiah (opsional)</label><textarea name="gift_info" rows="2" placeholder="Contoh: Tanpa mengurangi rasa hormat, bagi Anda yang ingin memberikan tanda kasih..." class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">{{ old('gift_info', $invitation->gift_info) }}</textarea></div>
                <div class="grid md:grid-cols-3 gap-4">
                    <div><label class="block text-xs text-gray-500 mb-1">Nama Bank</label><input type="text" name="bank_name" value="{{ old('bank_name', $invitation->bank_name) }}" placeholder="BCA / BNI / Mandiri" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-xs text-gray-500 mb-1">No. Rekening</label><input type="text" name="bank_account_number" value="{{ old('bank_account_number', $invitation->bank_account_number) }}" placeholder="1234567890" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                    <div><label class="block text-xs text-gray-500 mb-1">Atas Nama</label><input type="text" name="bank_account_name" value="{{ old('bank_account_name', $invitation->bank_account_name) }}" placeholder="Nama pemilik rekening" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent"></div>
                </div>
                <div><label class="block text-xs text-gray-500 mb-1">Upload QRIS (opsional)</label><input type="file" name="qris_image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">@if($invitation->qris_image)<p class="text-xs text-green-600 mt-1">✓ QRIS sudah diupload</p>@endif</div>
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-amber-600 to-amber-700 text-white font-semibold rounded-xl shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all">
            Simpan Perubahan
        </button>
    </form>

    <!-- 5. Galeri Foto (Separate form) -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Galeri Foto</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Upload foto-foto prewedding atau momen bersama (maks 5MB/foto)</p>

        <!-- Upload Form -->
        <form method="POST" action="{{ route('customer.gallery.store', $invitation) }}" enctype="multipart/form-data" class="mb-6">
            @csrf
            <div class="border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-xl p-6 text-center hover:border-amber-400 transition-colors">
                <svg class="w-10 h-10 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Pilih foto atau drag & drop</p>
                <input type="file" name="images[]" multiple accept="image/*" required class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG, WebP. Bisa pilih banyak foto sekaligus.</p>
            </div>
            <button type="submit" class="mt-4 px-6 py-2.5 bg-amber-600 text-white text-sm font-medium rounded-xl hover:bg-amber-700 transition">
                Upload Foto
            </button>
        </form>

        <!-- Existing Gallery -->
        @if($invitation->galleries->count() > 0)
        <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
            @foreach($invitation->galleries as $photo)
            <div class="relative group aspect-square rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <form method="POST" action="{{ route('customer.gallery.destroy', [$invitation, $photo]) }}" onsubmit="return confirm('Hapus foto ini?')">
                        @csrf @method('DELETE')
                        <button class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <p class="text-xs text-gray-400 mt-3">{{ $invitation->galleries->count() }} foto • Hover untuk hapus</p>
        @else
        <div class="text-center py-6">
            <svg class="w-12 h-12 text-gray-200 dark:text-gray-700 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-sm text-gray-400">Belum ada foto. Upload foto pertama Anda.</p>
        </div>
        @endif
    </div>

    <!-- 6. Kelola Tamu -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white">Kelola Tamu & RSVP</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tambah tamu, import dari Excel, lihat RSVP, kirim undangan personal</p>
            </div>
            <a href="{{ route('customer.guests.index', $invitation) }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition flex items-center gap-2">
                Kelola Tamu
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>
@endsection