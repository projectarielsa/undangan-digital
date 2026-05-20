<!-- Templates Section -->
<section id="templates" class="py-24 lg:py-32 bg-gradient-to-b from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-50">
        <div class="absolute top-20 left-10 w-72 h-72 bg-amber-200/30 dark:bg-amber-800/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-rose-200/30 dark:bg-rose-800/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-rose-100 to-amber-100 dark:from-rose-900/30 dark:to-amber-900/30 rounded-full mb-6">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"/>
                </svg>
                <span class="text-sm font-semibold text-rose-700 dark:text-rose-300">Desain Eksklusif</span>
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                Template yang <span class="bg-gradient-to-r from-rose-500 to-amber-500 bg-clip-text text-transparent">Memukau</span>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                Dirancang oleh desainer profesional untuk momen pernikahan yang tak terlupakan
            </p>
        </div>
        
        <!-- Template Filter -->
        <div class="flex flex-wrap items-center justify-center gap-3 mb-12" x-data="{ active: 'all' }">
            <button @click="active = 'all'" :class="active === 'all' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'" class="px-5 py-2 text-sm font-medium rounded-full border border-gray-200 dark:border-gray-700 transition-all">
                Semua
            </button>
            <button @click="active = 'elegant'" :class="active === 'elegant' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'" class="px-5 py-2 text-sm font-medium rounded-full border border-gray-200 dark:border-gray-700 transition-all">
                Elegant
            </button>
            <button @click="active = 'modern'" :class="active === 'modern' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'" class="px-5 py-2 text-sm font-medium rounded-full border border-gray-200 dark:border-gray-700 transition-all">
                Modern
            </button>
            <button @click="active = 'rustic'" :class="active === 'rustic' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'" class="px-5 py-2 text-sm font-medium rounded-full border border-gray-200 dark:border-gray-700 transition-all">
                Rustic
            </button>
            <button @click="active = 'minimalist'" :class="active === 'minimalist' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'" class="px-5 py-2 text-sm font-medium rounded-full border border-gray-200 dark:border-gray-700 transition-all">
                Minimalist
            </button>
        </div>


        <!-- Templates Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($templates as $index => $template)
            <div class="group relative">
                <!-- Card -->
                <div class="relative bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 dark:border-gray-700 group-hover:border-transparent group-hover:-translate-y-2">
                    
                    <!-- Preview Area -->
                    <div class="relative aspect-[3/4] overflow-hidden">
                        <!-- Gradient Background -->
                        <div class="absolute inset-0 transition-transform duration-700 group-hover:scale-110" style="background: linear-gradient(135deg, {{ $template->color_primary }}30, {{ $template->color_secondary }}20)">
                            <!-- Decorative Elements -->
                            <div class="absolute top-8 left-1/2 -translate-x-1/2 w-32 h-32 border border-current opacity-10 rounded-full" style="color: {{ $template->color_primary }}"></div>
                            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 w-48 h-48 border border-current opacity-10 rounded-full" style="color: {{ $template->color_secondary }}"></div>
                        </div>
                        
                        <!-- Template Preview Content -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center">
                            <p class="text-xs font-medium uppercase tracking-[0.3em] mb-4 opacity-60" style="color: {{ $template->color_primary }}">{{ $template->category }}</p>
                            <h3 class="text-3xl font-serif font-bold text-gray-900 dark:text-white mb-2">{{ $template->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-[200px]">{{ $template->description ?? 'Template undangan yang elegan dan modern' }}</p>
                            
                            <!-- Color Palette -->
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full border-2 border-white shadow-md transition-transform group-hover:scale-110" style="background: {{ $template->color_primary }}"></div>
                                <div class="w-8 h-8 rounded-full border-2 border-white shadow-md transition-transform group-hover:scale-110 delay-75" style="background: {{ $template->color_secondary }}"></div>
                            </div>
                        </div>
                        
                        <!-- Premium Badge -->
                        @if($template->is_premium)
                        <div class="absolute top-4 right-4">
                            <div class="px-3 py-1.5 bg-gradient-to-r from-amber-500 to-amber-600 text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                PREMIUM
                            </div>
                        </div>
                        @endif
                        
                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-8">
                            <a href="{{ route('demo.show', $template->slug) }}" class="px-6 py-3 bg-white text-gray-900 font-semibold rounded-full transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 hover:bg-amber-500 hover:text-white">
                                Lihat Demo
                            </a>
                        </div>
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="p-6 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $template->name }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $template->font_heading ?? 'Elegant Font' }}</p>
                            </div>
                            <div class="flex items-center gap-1 text-amber-500">
                                @for($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- View More -->
        <div class="mt-16 text-center">
            <a href="{{ route('demo.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-rose-500 to-amber-500 text-white font-semibold rounded-full shadow-lg shadow-rose-500/25 hover:shadow-rose-500/40 transition-all hover:scale-105">
                Lihat Semua Demo Template
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
