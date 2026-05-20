@extends('layouts.dashboard')
@section('page-title', 'Edit Paket: ' . $package->name)
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('admin.packages.index') }}" class="text-sm text-gray-500 hover:text-blue-600 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Paket
        </a>
    </div>

    <form method="POST" action="{{ route('admin.packages.update', $package) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Info Dasar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Paket</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Paket</label>
                    <input type="text" name="name" value="{{ old('name', $package->name) }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                    <input type="text" name="description" value="{{ old('description', $package->description) }}" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Urutan</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $package->sort_order) }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Durasi (hari)</label>
                        <input type="number" name="duration_days" value="{{ old('duration_days', $package->duration_days) }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Harga -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Harga</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Normal (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', (int)$package->price) }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Diskon (Rp) <span class="text-gray-400">- opsional</span></label>
                    <input type="number" name="discount_price" value="{{ old('discount_price', $package->discount_price ? (int)$package->discount_price : '') }}" placeholder="Kosongkan jika tidak ada diskon" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    @error('discount_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Jika harga diskon diisi, pelanggan akan melihat harga coret dan harga diskon.</p>
        </div>

        <!-- Batasan -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Batasan</h3>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Maks Foto</label>
                    <input type="number" name="max_photos" value="{{ old('max_photos', $package->max_photos) }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Maks Tamu</label>
                    <input type="number" name="max_guests" value="{{ old('max_guests', $package->max_guests) }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Maks Template</label>
                    <input type="number" name="max_templates" value="{{ old('max_templates', $package->max_templates) }}" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Gunakan 999 atau 9999 untuk unlimited.</p>
        </div>

        <!-- Fitur Toggle -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Fitur</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @php $featureToggles = [
                    'has_rsvp' => 'RSVP Online',
                    'has_music' => 'Background Music',
                    'has_guestbook' => 'Buku Tamu',
                    'has_gallery' => 'Galeri Foto',
                    'has_countdown' => 'Countdown Timer',
                    'has_love_story' => 'Love Story',
                    'has_digital_envelope' => 'Amplop Digital',
                    'has_qr_checkin' => 'QR Check-in',
                    'has_custom_domain' => 'Custom Domain',
                    'has_analytics' => 'Analytics',
                ]; @endphp
                @foreach($featureToggles as $field => $label)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="{{ $field }}" value="1" {{ old($field, $package->$field) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Status -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Status</h3>
            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Aktif (tampil ke pelanggan)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $package->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Paling Populer (highlight)</span>
                </label>
            </div>
        </div>

        <!-- Daftar Fitur (text) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Daftar Fitur (tampil di pricing)</h3>
            <textarea name="features" rows="8" placeholder="Satu fitur per baris" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 text-sm">{{ old('features', $package->features ? implode("\n", $package->features) : '') }}</textarea>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Tulis satu fitur per baris. Fitur ini akan tampil di halaman harga.</p>
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-4">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.packages.index') }}" class="px-8 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
