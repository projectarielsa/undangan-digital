@extends('layouts.dashboard')
@section('page-title', 'Custom Domain')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-3xl">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('customer.invitations.edit', $invitation) }}" class="text-sm text-gray-500 hover:text-blue-600 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Edit
        </a>
        <span class="px-3 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-700">Exclusive Feature</span>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 mb-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Custom Domain</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Gunakan domain pribadi Anda untuk undangan pernikahan.</p>
            </div>
        </div>
    </div>

    @if($customDomain)
    <!-- Current Domain Status -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 mb-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Domain Aktif</h3>
        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
            <div>
                <p class="font-mono text-lg text-gray-900 dark:text-white">{{ $customDomain->domain }}</p>
                <div class="flex items-center gap-2 mt-1">
                    @if($customDomain->isActive())
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-700">Aktif</span>
                    @elseif($customDomain->isPending())
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Menunggu Verifikasi</span>
                    @else
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-700">Gagal</span>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if(!$customDomain->isActive())
                <form method="POST" action="{{ route('customer.invitations.custom-domain.verify', $invitation) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition">Verifikasi</button>
                </form>
                @endif
                <form method="POST" action="{{ route('customer.invitations.custom-domain.destroy', $invitation) }}" onsubmit="return confirm('Hapus domain ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2 border border-red-200 text-red-600 text-sm font-medium rounded-xl hover:bg-red-50 transition">Hapus</button>
                </form>
            </div>
        </div>

        @if($customDomain->isPending() || $customDomain->isFailed())
        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
            <h4 class="font-medium text-blue-800 dark:text-blue-300 mb-2">Instruksi DNS</h4>
            <pre class="text-sm text-blue-700 dark:text-blue-400 whitespace-pre-wrap">{{ $customDomain->dns_instructions }}</pre>
        </div>
        @endif
    </div>
    @else
    <!-- Add Domain Form -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Tambah Custom Domain</h3>
        <form method="POST" action="{{ route('customer.invitations.custom-domain.store', $invitation) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Domain</label>
                <input type="text" name="domain" value="{{ old('domain') }}" required placeholder="undangan.namadomain.com" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono">
                @error('domain')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                <p class="text-xs text-gray-500 mt-2">Gunakan subdomain seperti undangan.namadomain.com atau domain khusus seperti wedding.com</p>
            </div>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl">Tambah Domain</button>
        </form>
    </div>
    @endif

    <!-- How it works -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Cara Kerja</h3>
        <div class="space-y-4">
            <div class="flex gap-4">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0"><span class="font-bold text-blue-700">1</span></div>
                <div><p class="font-medium text-gray-900 dark:text-white">Tambahkan domain</p><p class="text-sm text-gray-500">Masukkan domain atau subdomain yang ingin Anda gunakan.</p></div>
            </div>
            <div class="flex gap-4">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0"><span class="font-bold text-blue-700">2</span></div>
                <div><p class="font-medium text-gray-900 dark:text-white">Setup DNS</p><p class="text-sm text-gray-500">Tambahkan CNAME record di provider domain Anda sesuai instruksi.</p></div>
            </div>
            <div class="flex gap-4">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0"><span class="font-bold text-blue-700">3</span></div>
                <div><p class="font-medium text-gray-900 dark:text-white">Verifikasi</p><p class="text-sm text-gray-500">Klik tombol verifikasi setelah DNS selesai propagasi (biasanya 24-48 jam).</p></div>
            </div>
        </div>
    </div>
</div>
@endsection
