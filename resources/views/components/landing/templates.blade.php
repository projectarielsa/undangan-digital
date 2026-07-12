<!-- Templates Section -->
<section id="templates" class="py-24 lg:py-32 bg-gradient-to-b from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 relative overflow-hidden">

    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-50 pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-200/30 dark:bg-blue-800/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-sky-200/30 dark:bg-sky-800/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-sky-100 to-blue-100 dark:from-sky-900/30 dark:to-blue-900/30 rounded-full mb-6">
                <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"/>
                </svg>
                <span class="text-sm font-semibold text-sky-700 dark:text-sky-300">
                    Desain Eksklusif
                </span>
            </div>

            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                Template yang
                <span class="text-blue-600 dark:text-blue-400">
                    Memukau
                </span>
            </h2>

            <p class="text-xl text-gray-600 dark:text-gray-300">
                Dirancang oleh desainer profesional untuk momen pernikahan yang tak terlupakan
            </p>
        </div>

        <!-- Templates Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($templates as $template)

                <!-- CARD CLICKABLE -->
                <a href="{{ route('demo.show', $template->slug) }}"
                   class="group relative block no-underline">

                    <div class="relative bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 dark:border-gray-700 group-hover:border-transparent group-hover:-translate-y-2">

                        <!-- Preview Area -->
                        <div class="relative aspect-[3/4] overflow-hidden bg-gray-100 dark:bg-gray-700">

                            @if($template->thumbnail)
                            <!-- Real Screenshot Thumbnail -->
                            <img src="{{ asset($template->thumbnail) }}" alt="{{ $template->name }}"
                                 class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105"
                                 loading="lazy">
                            @else
                            <!-- Fallback: Gradient -->
                            <div class="absolute inset-0 transition-transform duration-700 group-hover:scale-110"
                                 style="background: linear-gradient(135deg, {{ $template->color_primary }}30, {{ $template->color_secondary }}20)">
                                <div class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center">
                                    <p class="text-xs font-medium uppercase tracking-[0.3em] mb-4 opacity-60"
                                       style="color: {{ $template->color_primary }}">
                                        {{ $template->category }}
                                    </p>
                                    <h3 class="text-3xl font-serif font-bold text-gray-900 dark:text-white">
                                        {{ $template->name }}
                                    </h3>
                                </div>
                            </div>
                            @endif

                            <!-- Premium Badge -->
                            @if($template->is_premium)
                                <div class="absolute top-4 right-4 z-20">
                                    <div class="px-3 py-1.5 bg-gradient-to-r from-blue-500 to-purple-500 text-white text-xs font-bold rounded-full shadow-lg">
                                        ⭐ PREMIUM
                                    </div>
                                </div>
                            @endif

                            <!-- Desktop Hover Overlay -->
                            <div class="hidden md:flex absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 items-end justify-center pb-8 z-20">
                                <span class="px-6 py-3 bg-white text-gray-900 font-semibold rounded-full transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 shadow-xl">
                                    Lihat Demo
                                </span>
                            </div>

                            <!-- Mobile Button -->
                            <div class="md:hidden absolute bottom-4 left-0 right-0 flex justify-center z-20">
                                <span class="px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-full shadow-lg">
                                    Lihat Demo
                                </span>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="p-6 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-1">
                                        {{ $template->name }}
                                    </h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 capitalize">
                                        {{ $template->category }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-1">
                                    <div class="w-5 h-5 rounded-full border-2 border-white shadow-sm" style="background: {{ $template->color_primary }}"></div>
                                    <div class="w-5 h-5 rounded-full border-2 border-white shadow-sm" style="background: {{ $template->color_secondary }}"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </a>

            @endforeach

        </div>

        <!-- View More -->
        <div class="mt-16 text-center">
            <a href="{{ route('demo.index') }}"
               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-sky-500 to-blue-500 text-white font-semibold rounded-full shadow-lg shadow-sky-500/25 hover:shadow-sky-500/40 transition-all hover:scale-105">
                Lihat Semua Demo Template
            </a>
        </div>

    </div>
</section>
