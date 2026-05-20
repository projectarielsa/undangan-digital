<!-- Features Section -->
<section id="features" class="py-24 lg:py-32 bg-white dark:bg-gray-900 relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-blue-50/50 to-transparent dark:from-blue-900/10 dark:to-transparent"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-sky-100/50 dark:bg-sky-900/10 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-20">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 dark:bg-blue-900/30 rounded-full mb-6">
                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-sm font-semibold text-blue-700 dark:text-blue-300">Fitur Premium</span>
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                Semua yang Anda Butuhkan untuk
                <span class="bg-gradient-to-r from-blue-500 to-sky-500 bg-clip-text text-transparent">Hari Spesial</span>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                Fitur lengkap untuk undangan pernikahan digital yang sempurna dan berkesan
            </p>
        </div>
        
        <!-- Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @php $features = [
                [
                    'icon' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z',
                    'title' => 'Template Premium',
                    'desc' => 'Pilihan template elegan yang dirancang khusus oleh desainer profesional untuk pernikahan impian',
                    'color' => 'blue'
                ],
                [
                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                    'title' => 'Countdown Timer',
                    'desc' => 'Hitung mundur otomatis yang cantik menuju hari bahagia Anda dengan tampilan yang memukau',
                    'color' => 'sky'
                ],
                [
                    'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
                    'title' => 'RSVP Online',
                    'desc' => 'Kelola konfirmasi kehadiran tamu dengan mudah, real-time, dan otomatis terintegrasi',
                    'color' => 'emerald'
                ],
                [
                    'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3',
                    'title' => 'Background Music',
                    'desc' => 'Tambahkan musik latar romantis pilihan Anda untuk pengalaman yang lebih berkesan',
                    'color' => 'violet'
                ],
                [
                    'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                    'title' => 'Galeri Foto',
                    'desc' => 'Tampilkan momen indah prewedding dengan galeri foto yang elegan dan interaktif',
                    'color' => 'pink'
                ],
                [
                    'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
                    'title' => 'Amplop Digital',
                    'desc' => 'Terima hadiah secara digital melalui transfer bank atau QRIS dengan mudah dan aman',
                    'color' => 'blue'
                ],
            ]; @endphp


            @foreach($features as $index => $f)
            <div class="group relative" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <!-- Card -->
                <div class="relative h-full p-8 bg-gray-50 dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-500 group-hover:bg-white dark:group-hover:bg-gray-750 group-hover:shadow-2xl group-hover:shadow-{{ $f['color'] }}-500/10 group-hover:border-{{ $f['color'] }}-200 dark:group-hover:border-{{ $f['color'] }}-800 group-hover:-translate-y-2">
                    
                    <!-- Background Gradient on Hover -->
                    <div class="absolute inset-0 bg-gradient-to-br from-{{ $f['color'] }}-50 to-transparent dark:from-{{ $f['color'] }}-900/20 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Icon -->
                    <div class="relative mb-6">
                        <div class="w-14 h-14 bg-{{ $f['color'] }}-100 dark:bg-{{ $f['color'] }}-900/30 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-7 h-7 text-{{ $f['color'] }}-600 dark:text-{{ $f['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}"/>
                            </svg>
                        </div>
                        <!-- Decorative ring -->
                        <div class="absolute -inset-2 border-2 border-{{ $f['color'] }}-200 dark:border-{{ $f['color'] }}-800 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 group-hover:animate-ping-once"></div>
                    </div>
                    
                    <!-- Content -->
                    <h3 class="relative text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-{{ $f['color'] }}-600 dark:group-hover:text-{{ $f['color'] }}-400 transition-colors">
                        {{ $f['title'] }}
                    </h3>
                    <p class="relative text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ $f['desc'] }}
                    </p>
                    
                    <!-- Arrow indicator -->
                    <div class="relative mt-6 flex items-center gap-2 text-{{ $f['color'] }}-600 dark:text-{{ $f['color'] }}-400 opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-2 transition-all duration-300">
                        <span class="text-sm font-medium">Pelajari lebih lanjut</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Number Badge -->
                <div class="absolute -top-3 -right-3 w-8 h-8 bg-gradient-to-br from-{{ $f['color'] }}-400 to-{{ $f['color'] }}-600 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg opacity-0 group-hover:opacity-100 transform scale-0 group-hover:scale-100 transition-all duration-300">
                    {{ $index + 1 }}
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Bottom CTA -->
        <div class="mt-16 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">Dan masih banyak fitur lainnya...</p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-semibold rounded-full hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                Coba Semua Fitur
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
</section>
