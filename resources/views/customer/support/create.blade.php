@extends('layouts.dashboard')
@section('page-title', 'Buat Tiket Support')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('customer.support.index') }}" class="text-sm text-gray-500 hover:text-blue-600 flex items-center gap-1 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Buat Tiket Baru</h2>

        <form method="POST" action="{{ route('customer.support.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori *</label>
                <select name="category" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Kategori</option>
                    <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>Teknis</option>
                    <option value="billing" {{ old('category') == 'billing' ? 'selected' : '' }}>Pembayaran</option>
                    <option value="feature" {{ old('category') == 'feature' ? 'selected' : '' }}>Permintaan Fitur</option>
                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('category')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subjek *</label>
                <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="Judul masalah Anda" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                @error('subject')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Undangan Terkait (Opsional)</label>
                <select name="invitation_id" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">Tidak terkait undangan tertentu</option>
                    @foreach($invitations as $inv)
                    <option value="{{ $inv->id }}" {{ old('invitation_id') == $inv->id ? 'selected' : '' }}>{{ $inv->title }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pesan *</label>
                <textarea name="message" rows="5" required placeholder="Jelaskan masalah Anda secara detail..." class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('message') }}</textarea>
                @error('message')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lampiran (Opsional)</label>
                <input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF, DOC (max 5MB)</p>
            </div>

            <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/25 hover:shadow-xl transition">Kirim Tiket</button>
        </form>
    </div>
</div>
@endsection
