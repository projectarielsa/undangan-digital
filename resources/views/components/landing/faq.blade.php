<!-- FAQ -->
<section id="faq" class="py-20 lg:py-32 bg-white dark:bg-gray-900">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4 font-serif">Pertanyaan Umum</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Jawaban untuk pertanyaan yang sering ditanyakan</p>
        </div>
        <div class="space-y-4" x-data="{ open: null }">
            @php $faqs = [
                ['q'=>'Apa itu undangan digital?','a'=>'Undangan digital adalah undangan pernikahan dalam bentuk website yang dapat diakses melalui smartphone atau komputer. Lebih modern, hemat biaya, dan ramah lingkungan.'],
                ['q'=>'Berapa lama proses pembuatan?','a'=>'Hanya butuh 5-10 menit! Cukup pilih template, isi data, dan undangan Anda siap dibagikan.'],
                ['q'=>'Apakah bisa diakses di semua device?','a'=>'Ya! Undangan kami responsive dan dapat diakses sempurna di smartphone, tablet, maupun komputer.'],
                ['q'=>'Bagaimana cara membagikan?','a'=>'Setelah dipublikasikan, Anda mendapat link unik yang bisa dibagikan via WhatsApp, Instagram, atau media sosial lainnya.'],
                ['q'=>'Apakah ada batasan jumlah tamu?','a'=>'Tergantung paket. Basic 100 tamu, Premium 500 tamu, dan Exclusive unlimited.'],
                ['q'=>'Bisa mengubah setelah publish?','a'=>'Tentu! Anda bebas mengedit konten kapan saja selama masa aktif, perubahan langsung terlihat oleh tamu.'],
            ]; @endphp
            @foreach($faqs as $i => $faq)
            <div class="border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
                <button @click="open = open === {{ $i }} ? null : {{ $i }}" class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    <span class="font-semibold text-gray-900 dark:text-white pr-4">{{ $faq['q'] }}</span>
                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0 transition-transform" :class="open === {{ $i }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open === {{ $i }}" x-collapse class="px-6 pb-6"><p class="text-gray-600 dark:text-gray-300">{{ $faq['a'] }}</p></div>
            </div>
            @endforeach
        </div>
    </div>
</section>
