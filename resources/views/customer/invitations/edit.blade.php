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

    @if(session('success'))<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl"><p class="text-sm text-green-600">{{ session('success') }}</p></div>@endif
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
                    <div><label class="block text-sm text-gray-600 mb-1">Cover Image</label><input type="file" name="cover_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700">@if($invitation->cover_image)<p class="text-xs text-green-600 mt-1">Cover saat ini: tersimpan</p>@endif</div>
                    <div><label class="block text-sm text-gray-600 mb-1">Music (MP3)</label><input type="file" name="music_file" accept=".mp3,.wav" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700">@if($invitation->music_url)<p class="text-xs text-green-600 mt-1">Musik saat ini: tersimpan</p>@endif</div>
                </div>
            </div>
        </div>


        <!-- Section Info Bank / Amplop Digital -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Amplop Digital (Gift)</h3>
            <p class="text-sm text-gray-500 mb-4">Informasi rekening untuk tamu yang ingin memberikan hadiah</p>
            <div class="space-y-4">
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nama Bank</label>
                        <select name="bank_name" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            <option value="">Pilih Bank</option>
                            <option value="BCA" {{ old('bank_name', $invitation->bank_name) == 'BCA' ? 'selected' : '' }}>BCA</option>
                            <option value="BNI" {{ old('bank_name', $invitation->bank_name) == 'BNI' ? 'selected' : '' }}>BNI</option>
                            <option value="BRI" {{ old('bank_name', $invitation->bank_name) == 'BRI' ? 'selected' : '' }}>BRI</option>
                            <option value="Mandiri" {{ old('bank_name', $invitation->bank_name) == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                            <option value="BSI" {{ old('bank_name', $invitation->bank_name) == 'BSI' ? 'selected' : '' }}>BSI</option>
                            <option value="CIMB Niaga" {{ old('bank_name', $invitation->bank_name) == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                            <option value="Permata" {{ old('bank_name', $invitation->bank_name) == 'Permata' ? 'selected' : '' }}>Permata</option>
                            <option value="Danamon" {{ old('bank_name', $invitation->bank_name) == 'Danamon' ? 'selected' : '' }}>Danamon</option>
                            <option value="OCBC NISP" {{ old('bank_name', $invitation->bank_name) == 'OCBC NISP' ? 'selected' : '' }}>OCBC NISP</option>
                            <option value="Maybank" {{ old('bank_name', $invitation->bank_name) == 'Maybank' ? 'selected' : '' }}>Maybank</option>
                            <option value="Jenius" {{ old('bank_name', $invitation->bank_name) == 'Jenius' ? 'selected' : '' }}>Jenius</option>
                            <option value="Jago" {{ old('bank_name', $invitation->bank_name) == 'Jago' ? 'selected' : '' }}>Jago</option>
                            <option value="SeaBank" {{ old('bank_name', $invitation->bank_name) == 'SeaBank' ? 'selected' : '' }}>SeaBank</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nomor Rekening</label>
                        <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $invitation->bank_account_number) }}" placeholder="1234567890" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nama Pemilik Rekening</label>
                        <input type="text" name="bank_account_name" value="{{ old('bank_account_name', $invitation->bank_account_name) }}" placeholder="Nama sesuai buku rekening" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">QRIS (Opsional)</label>
                    <input type="file" name="qris_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700">
                    @if($invitation->qris_image)<p class="text-xs text-green-600 mt-1">QRIS tersimpan</p>@endif
                    <p class="text-xs text-gray-400 mt-1">Upload gambar QRIS untuk pembayaran via e-wallet</p>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Pesan untuk Gift (Opsional)</label>
                    <textarea name="gift_info" rows="2" placeholder="Contoh: Doa restu Anda adalah hadiah terindah bagi kami..." class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">{{ old('gift_info', $invitation->gift_info) }}</textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-amber-600 to-amber-700 text-white font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all hover:shadow-xl">Simpan Perubahan</button>
    </form>


    <!-- Section Galeri Foto -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Galeri Foto</h3>
                <p class="text-sm text-gray-500">Upload foto-foto untuk ditampilkan di undangan (max 20 foto)</p>
            </div>
        </div>
        
        <!-- Upload Form -->
        <form method="POST" action="{{ route('customer.gallery.store', $invitation) }}" enctype="multipart/form-data" class="mb-6">
            @csrf
            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-amber-400 transition">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <input type="file" name="images[]" id="gallery-upload" multiple accept="image/*" class="hidden" onchange="this.form.submit()">
                <label for="gallery-upload" class="cursor-pointer">
                    <span class="text-amber-600 hover:text-amber-700 font-medium">Klik untuk upload</span>
                    <span class="text-gray-500"> atau drag & drop</span>
                </label>
                <p class="text-xs text-gray-400 mt-2">PNG, JPG, JPEG (max 5MB per foto)</p>
            </div>
        </form>

        <!-- Gallery Grid -->
        @if($invitation->galleries && $invitation->galleries->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4" id="gallery-grid">
            @foreach($invitation->galleries as $gallery)
            <div class="relative group aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-700">
                <img src="{{ $gallery->getImageUrl() }}" alt="Gallery" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                    <form method="POST" action="{{ route('customer.gallery.destroy', [$invitation, $gallery]) }}" onsubmit="return confirm('Hapus foto ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
                @if($gallery->caption)<p class="absolute bottom-0 left-0 right-0 bg-black/60 text-white text-xs p-2 truncate">{{ $gallery->caption }}</p>@endif
            </div>
            @endforeach
        </div>
        <p class="text-sm text-gray-500 mt-4">{{ $invitation->galleries->count() }} foto terupload</p>
        @else
        <div class="text-center py-8 text-gray-500">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p>Belum ada foto di galeri</p>
        </div>
        @endif
    </div>

    <!-- Section Kelola Tamu -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <div class="flex items-center justify-between">
            <div><h3 class="font-semibold text-gray-900 dark:text-white">Kelola Tamu</h3><p class="text-sm text-gray-500">Tambah tamu, lihat RSVP, dan kirim undangan personal</p></div>
            <a href="{{ route('customer.guests.index', $invitation) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 transition">Kelola Tamu &rarr;</a>
        </div>
    </div>

    <!-- Section Love Story -->
    <div class="mt-4 bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Love Story Timeline</h3>
                    @if(!$invitation->package || !$invitation->package->has_love_story)
                    <span class="px-2 py-0.5 text-xs font-medium bg-amber-100 text-amber-700 rounded-full">Premium</span>
                    @endif
                </div>
                <p class="text-sm text-gray-500">Ceritakan perjalanan cinta kalian</p>
            </div>
            <a href="{{ route('customer.invitations.love-story', $invitation) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 transition">Kelola Love Story &rarr;</a>
        </div>
    </div>

    <!-- Section Analytics -->
    <div class="mt-4 bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Analytics Pengunjung</h3>
                    @if(!$invitation->package || !$invitation->package->has_analytics)
                    <span class="px-2 py-0.5 text-xs font-medium bg-amber-100 text-amber-700 rounded-full">Premium</span>
                    @endif
                </div>
                <p class="text-sm text-gray-500">Lihat statistik lengkap pengunjung undangan</p>
            </div>
            <a href="{{ route('customer.invitations.analytics', $invitation) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 transition">Lihat Analytics &rarr;</a>
        </div>
    </div>

    <!-- Section QR Check-in -->
    <div class="mt-4 bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="font-semibold text-gray-900 dark:text-white">QR Check-in</h3>
                    @if(!$invitation->package || !$invitation->package->has_qr_checkin)
                    <span class="px-2 py-0.5 text-xs font-medium bg-purple-100 text-purple-700 rounded-full">Exclusive</span>
                    @endif
                </div>
                <p class="text-sm text-gray-500">Scan QR untuk check-in tamu di hari H</p>
            </div>
            <a href="{{ route('customer.qr-checkin.index', $invitation) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 transition">QR Check-in &rarr;</a>
        </div>
    </div>
</div>
@endsection
