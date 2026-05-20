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
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6" x-data="bankAccountsManager()">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Amplop Digital (Gift)</h3>
                    <p class="text-sm text-gray-500 mb-4">Informasi rekening untuk tamu yang ingin memberikan hadiah</p>
                </div>
                <button type="button" @click="addAccount()" class="px-4 py-2 bg-amber-50 text-amber-700 text-sm font-medium rounded-xl hover:bg-amber-100 transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Rekening
                </button>
            </div>
            
            <div class="space-y-4">
                <!-- Bank Accounts Repeater -->
                <template x-for="(account, index) in accounts" :key="index">
                    <div class="relative border border-gray-200 dark:border-gray-600 rounded-xl p-4">
                        <!-- Remove button -->
                        <button type="button" @click="removeAccount(index)" x-show="accounts.length > 1" class="absolute top-3 right-3 w-7 h-7 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                        
                        <p class="text-xs font-medium text-gray-400 mb-3" x-text="'Rekening #' + (index + 1)"></p>
                        
                        <div class="grid md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Nama Bank</label>
                                <select :name="'bank_accounts[' + index + '][bank_name]'" x-model="account.bank_name" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    <option value="">Pilih Bank</option>
                                    <option value="BCA">BCA</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BRI">BRI</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="BSI">BSI</option>
                                    <option value="CIMB Niaga">CIMB Niaga</option>
                                    <option value="Permata">Permata</option>
                                    <option value="Danamon">Danamon</option>
                                    <option value="OCBC NISP">OCBC NISP</option>
                                    <option value="Maybank">Maybank</option>
                                    <option value="Jenius">Jenius</option>
                                    <option value="Jago">Jago</option>
                                    <option value="SeaBank">SeaBank</option>
                                    <option value="GoPay">GoPay</option>
                                    <option value="OVO">OVO</option>
                                    <option value="DANA">DANA</option>
                                    <option value="ShopeePay">ShopeePay</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Nomor Rekening</label>
                                <input type="text" :name="'bank_accounts[' + index + '][account_number]'" x-model="account.account_number" placeholder="1234567890" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Nama Pemilik</label>
                                <input type="text" :name="'bank_accounts[' + index + '][account_name]'" x-model="account.account_name" placeholder="Nama sesuai rekening" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Empty state -->
                <div x-show="accounts.length === 0" class="text-center py-6 border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-xl">
                    <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <p class="text-sm text-gray-400">Belum ada rekening. Klik "Tambah Rekening" untuk menambahkan.</p>
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

        <script>
        function bankAccountsManager() {
            return {
                accounts: @json($invitation->bank_accounts_list ?? []),
                addAccount() {
                    this.accounts.push({ bank_name: '', account_number: '', account_name: '' });
                },
                removeAccount(index) {
                    this.accounts.splice(index, 1);
                }
            }
        }
        </script>

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

    <!-- Premium Features Section -->
    <div class="mt-8 grid md:grid-cols-2 gap-4">
        <!-- Love Story -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-pink-100 dark:bg-pink-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Love Story Timeline</h3>
                    <p class="text-sm text-gray-500 mt-1">Ceritakan perjalanan cinta kalian</p>
                    @if($invitation->hasLoveStoryFeature())
                    <a href="{{ route('customer.invitations.love-story', $invitation) }}" class="inline-block mt-3 text-sm text-amber-600 hover:text-amber-700 font-medium">Edit Love Story &rarr;</a>
                    @else
                    <p class="mt-3 text-xs text-gray-400">Premium & Exclusive</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Analytics -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Analytics</h3>
                    <p class="text-sm text-gray-500 mt-1">Statistik pengunjung & RSVP detail</p>
                    @if($invitation->hasAnalyticsFeature())
                    <a href="{{ route('customer.invitations.analytics', $invitation) }}" class="inline-block mt-3 text-sm text-amber-600 hover:text-amber-700 font-medium">Lihat Analytics &rarr;</a>
                    @else
                    <p class="mt-3 text-xs text-gray-400">Premium & Exclusive</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- QR Check-in -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 dark:text-white">QR Check-in</h3>
                    <p class="text-sm text-gray-500 mt-1">Scan QR untuk check-in tamu</p>
                    @if($invitation->hasQrCheckinFeature())
                    <a href="{{ route('customer.invitations.qr-checkin', $invitation) }}" class="inline-block mt-3 text-sm text-amber-600 hover:text-amber-700 font-medium">Kelola QR Check-in &rarr;</a>
                    @else
                    <p class="mt-3 text-xs text-gray-400">Exclusive only</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Custom Domain -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Custom Domain</h3>
                    <p class="text-sm text-gray-500 mt-1">Gunakan domain pribadi Anda</p>
                    @if($invitation->hasCustomDomainFeature())
                    <a href="{{ route('customer.invitations.custom-domain', $invitation) }}" class="inline-block mt-3 text-sm text-amber-600 hover:text-amber-700 font-medium">Setting Domain &rarr;</a>
                    @else
                    <p class="mt-3 text-xs text-gray-400">Exclusive only</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
