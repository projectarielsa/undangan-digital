<!-- FAQ Section -->
<section id="faq" class="py-24 lg:py-32 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 dark:bg-blue-900/30 rounded-full mb-6">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-semibold text-blue-700 dark:text-blue-300">FAQ</span>
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                Pertanyaan yang <span class="text-blue-600 dark:text-blue-400">Sering Diajukan</span>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                Temukan jawaban untuk pertanyaan umum tentang layanan kami
            </p>
        </div>

        <!-- FAQ Accordion -->
        <div class="space-y-4" x-data="{ active: 1 }">
            @php
                $faqs = [
                    ['q' => 'Bagaimana cara membuat undangan digital?', 'a' => 'Sangat mudah! Cukup daftar akun, pilih template yang Anda suka, isi informasi pernikahan Anda, dan undangan siap dibagikan. Prosesnya hanya memakan waktu sekitar 5-10 menit.'],
                    ['q' => 'Apakah undangan bisa diedit setelah dibuat?', 'a' => 'Tentu saja! Anda dapat mengedit undangan kapan saja selama masa aktif paket Anda. Perubahan akan langsung terlihat di undangan yang sudah dibagikan.'],
                    ['q' => 'Bagaimana cara membagikan undangan ke tamu?', 'a' => 'Setelah undangan selesai, Anda akan mendapatkan link unik yang bisa dibagikan via WhatsApp, Instagram, Email, atau media sosial lainnya. Anda juga bisa generate QR Code untuk undangan fisik.'],
                    ['q' => 'Apakah ada batasan jumlah tamu?', 'a' => 'Tidak ada batasan jumlah tamu untuk paket berbayar. Anda bisa mengundang sebanyak mungkin tamu dan memantau RSVP mereka secara real-time melalui dashboard.'],
                    ['q' => 'Bagaimana dengan keamanan data?', 'a' => 'Kami sangat menjaga keamanan data Anda. Semua data dienkripsi dan disimpan dengan aman. Kami tidak akan membagikan informasi pribadi Anda kepada pihak ketiga.'],
                    ['q' => 'Apakah tersedia refund jika tidak puas?', 'a' => 'Ya, kami memberikan garansi 7 hari uang kembali. Jika Anda tidak puas dengan layanan kami dalam 7 hari pertama, kami akan mengembalikan pembayaran Anda secara penuh.'],
                ];
            @endphp

            @foreach($faqs as $index => $faq)
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300"
                 :class="active === {{ $index + 1 }} && 'ring-2 ring-blue-500/50'">
                <button 
                    @click="active = active === {{ $index + 1 }} ? null : {{ $index + 1 }}"
                    class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                >
                    <span class="font-semibold text-gray-900 dark:text-white pr-4">{{ $faq['q'] }}</span>
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center transition-transform duration-300"
                         :class="active === {{ $index + 1 }} && 'bg-blue-500 rotate-180'">
                        <svg class="w-4 h-4 transition-colors" 
                             :class="active === {{ $index + 1 }} ? 'text-white' : 'text-blue-600 dark:text-blue-400'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div 
                    x-show="active === {{ $index + 1 }}"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="px-6 pb-6"
                >
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Contact CTA -->
        <div class="mt-12 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">Masih punya pertanyaan?</p>
            <a href="mailto:support@ellori.com" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold hover:text-blue-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Hubungi Kami
            </a>
        </div>
    </div>
</section>
