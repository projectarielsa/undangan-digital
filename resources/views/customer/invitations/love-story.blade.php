@extends('layouts.dashboard')
@section('page-title', 'Love Story')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('customer.invitations.edit', $invitation) }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>Kembali ke Undangan
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Love Story Timeline</h1>
            <p class="text-gray-500">{{ $invitation->title }}</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl">
        <p class="text-sm text-green-600">{{ session('success') }}</p>
    </div>
    @endif

    @if(!$hasFeature)
    <div class="mb-6 p-6 bg-amber-50 border border-amber-200 rounded-2xl">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-amber-800 mb-1">Fitur Premium</h3>
                <p class="text-sm text-amber-700 mb-3">Love Story Timeline tersedia untuk paket Premium dan Exclusive.</p>
                <a href="{{ route('customer.packages') }}" class="inline-flex items-center gap-1 text-sm font-medium text-amber-700 hover:text-amber-800">
                    Upgrade Paket <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('customer.invitations.love-story.update', $invitation) }}" id="love-story-form">
        @csrf @method('PUT')
        
        <div class="space-y-4" id="timeline-container">
            @forelse($loveStory as $index => $story)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 timeline-item" data-index="{{ $index }}">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                            <span class="text-amber-600 font-bold item-number">{{ $index + 1 }}</span>
                        </div>
                        <h3 class="font-medium text-gray-900 dark:text-white">Momen #{{ $index + 1 }}</h3>
                    </div>
                    <button type="button" onclick="removeItem(this)" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition {{ !$hasFeature ? 'opacity-50 cursor-not-allowed' : '' }}" {{ !$hasFeature ? 'disabled' : '' }}>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Tanggal / Tahun</label>
                        <input type="text" name="love_story[{{ $index }}][date]" value="{{ $story['date'] ?? '' }}" placeholder="Contoh: 2020 atau Januari 2020" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent" {{ !$hasFeature ? 'disabled' : '' }}>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Judul Momen</label>
                        <input type="text" name="love_story[{{ $index }}][title]" value="{{ $story['title'] ?? '' }}" placeholder="Contoh: Pertama Kali Bertemu" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent" {{ !$hasFeature ? 'disabled' : '' }}>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-600 mb-1">Deskripsi</label>
                        <textarea name="love_story[{{ $index }}][description]" rows="2" placeholder="Ceritakan momen ini..." class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent" {{ !$hasFeature ? 'disabled' : '' }}>{{ $story['description'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 timeline-item" data-index="0">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                            <span class="text-amber-600 font-bold item-number">1</span>
                        </div>
                        <h3 class="font-medium text-gray-900 dark:text-white">Momen #1</h3>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Tanggal / Tahun</label>
                        <input type="text" name="love_story[0][date]" placeholder="Contoh: 2020" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl" {{ !$hasFeature ? 'disabled' : '' }}>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Judul Momen</label>
                        <input type="text" name="love_story[0][title]" placeholder="Contoh: Pertama Kali Bertemu" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl" {{ !$hasFeature ? 'disabled' : '' }}>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-600 mb-1">Deskripsi</label>
                        <textarea name="love_story[0][description]" rows="2" placeholder="Ceritakan momen ini..." class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl" {{ !$hasFeature ? 'disabled' : '' }}></textarea>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <div class="mt-6 flex items-center justify-between">
            <button type="button" onclick="addItem()" class="px-4 py-2 border border-gray-200 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-50 transition flex items-center gap-2 {{ !$hasFeature ? 'opacity-50 cursor-not-allowed' : '' }}" {{ !$hasFeature ? 'disabled' : '' }}>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Momen
            </button>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-amber-600 to-amber-700 text-white font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all hover:shadow-xl {{ !$hasFeature ? 'opacity-50 cursor-not-allowed' : '' }}" {{ !$hasFeature ? 'disabled' : '' }}>
                Simpan Love Story
            </button>
        </div>
    </form>
</div>

<script>
let itemCount = {{ count($loveStory) ?: 1 }};

function addItem() {
    const container = document.getElementById('timeline-container');
    const newItem = document.createElement('div');
    newItem.className = 'bg-white dark:bg-gray-800 rounded-2xl border p-6 timeline-item';
    newItem.dataset.index = itemCount;
    newItem.innerHTML = `
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                    <span class="text-amber-600 font-bold item-number">${itemCount + 1}</span>
                </div>
                <h3 class="font-medium text-gray-900 dark:text-white">Momen #${itemCount + 1}</h3>
            </div>
            <button type="button" onclick="removeItem(this)" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Tanggal / Tahun</label>
                <input type="text" name="love_story[${itemCount}][date]" placeholder="Contoh: 2020" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Judul Momen</label>
                <input type="text" name="love_story[${itemCount}][title]" placeholder="Contoh: Pertama Kali Bertemu" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm text-gray-600 mb-1">Deskripsi</label>
                <textarea name="love_story[${itemCount}][description]" rows="2" placeholder="Ceritakan momen ini..." class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl"></textarea>
            </div>
        </div>
    `;
    container.appendChild(newItem);
    itemCount++;
}

function removeItem(btn) {
    const item = btn.closest('.timeline-item');
    if (document.querySelectorAll('.timeline-item').length > 1) {
        item.remove();
        reindexItems();
    }
}

function reindexItems() {
    document.querySelectorAll('.timeline-item').forEach((item, idx) => {
        item.querySelector('.item-number').textContent = idx + 1;
        item.querySelector('h3').textContent = 'Momen #' + (idx + 1);
        item.querySelectorAll('input, textarea').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, '[' + idx + ']');
        });
    });
}
</script>
@endsection
