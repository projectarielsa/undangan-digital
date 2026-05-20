<!-- Testimonials Section -->
<section id="testimonials" class="py-24 lg:py-32 bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 relative overflow-hidden">
    <!-- Background decoration -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-gradient-to-r from-blue-100/30 to-sky-100/30 dark:from-blue-900/10 dark:to-sky-900/10 rounded-full blur-3xl"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-sky-100 to-blue-100 dark:from-sky-900/30 dark:to-blue-900/30 rounded-full mb-6">
                <svg class="w-4 h-4 text-sky-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-sm font-semibold text-sky-700 dark:text-sky-300">4.9/5 Rating</span>
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                Apa Kata <span class="bg-gradient-to-r from-sky-500 to-blue-500 bg-clip-text text-transparent">Mereka?</span>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                Ribuan pasangan telah mempercayakan momen spesial mereka kepada kami
            </p>
        </div>

        <!-- Testimonials Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($testimonials ?? [] as $testimonial)
            <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:-translate-y-1">
                <!-- Quote icon -->
                <div class="absolute -top-4 left-8">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-sky-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Rating -->
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    @endfor
                </div>
                
                <!-- Content -->
                <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                    "{{ $testimonial->content ?? 'Undangan digital dari platform ini sangat membantu kami. Desainnya cantik dan fiturnya lengkap!' }}"
                </p>
                
                <!-- Author -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-200 to-sky-200 dark:from-blue-800 dark:to-sky-800 flex items-center justify-center">
                        <span class="text-blue-700 dark:text-blue-200 font-semibold">{{ strtoupper(substr($testimonial->name ?? 'U', 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $testimonial->name ?? 'Happy Customer' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $testimonial->event_date ?? 'Wedding 2024' }}</p>
                    </div>
                </div>
            </div>
            @empty
            @for($i = 0; $i < 3; $i++)
            <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:-translate-y-1">
                <div class="absolute -top-4 left-8">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-sky-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center gap-1 mb-4">
                    @for($j = 0; $j < 5; $j++)
                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    @endfor
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                    "{{ ['Sangat puas dengan hasilnya! Template-nya cantik dan mudah digunakan. Tamu undangan kami banyak yang memuji.', 'Platform terbaik untuk undangan digital! Fitur RSVP dan galeri fotonya sangat membantu mengorganisir acara kami.', 'Harga terjangkau dengan kualitas premium. Customer service-nya juga sangat responsif dan helpful.'][$i] }}"
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-200 to-sky-200 dark:from-blue-800 dark:to-sky-800 flex items-center justify-center">
                        <span class="text-blue-700 dark:text-blue-200 font-semibold">{{ ['A', 'B', 'R'][$i] }}</span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ ['Andi & Sarah', 'Budi & Lisa', 'Reza & Maya'][$i] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ ['Wedding Mei 2024', 'Wedding April 2024', 'Wedding Juni 2024'][$i] }}</p>
                    </div>
                </div>
            </div>
            @endfor
            @endforelse
        </div>
    </div>
</section>
