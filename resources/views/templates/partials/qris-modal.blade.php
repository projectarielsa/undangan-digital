{{-- QRIS Lightbox Modal - Click to enlarge QRIS for screenshot --}}
@if($invitation->qris_image)
<div x-data="{ open: false }" @open-qris.window="open = true" x-cloak>
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" @click.self="open = false">
        <div class="relative max-w-lg w-full bg-white rounded-2xl p-6 shadow-2xl" @click.stop>
            <!-- Close button -->
            <button @click="open = false" class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            
            <!-- QRIS Image Full Size -->
            <div class="text-center">
                <p class="text-sm font-medium text-gray-700 mb-4">Scan QR Code untuk pembayaran</p>
                <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-full max-w-sm mx-auto object-contain rounded-lg">
                <p class="text-xs text-gray-400 mt-4">Screenshot gambar ini untuk melakukan pembayaran</p>
            </div>
        </div>
    </div>
</div>
@endif
