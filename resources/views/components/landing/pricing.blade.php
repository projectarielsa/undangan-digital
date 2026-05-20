<!-- Pricing Section -->
<section id="pricing" class="py-24 lg:py-32 bg-white dark:bg-gray-900 relative overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-r from-amber-100/50 to-rose-100/50 dark:from-amber-900/20 dark:to-rose-900/20 rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-100 to-rose-100 dark:from-amber-900/30 dark:to-rose-900/30 rounded-full mb-6">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-semibold text-amber-700 dark:text-amber-300">Harga Terjangkau</span>
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                Pilih Paket <span class="bg-gradient-to-r from-amber-500 to-rose-500 bg-clip-text text-transparent">Terbaik</span> untuk Anda
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                Investasi kecil untuk momen tak terlupakan. Semua paket sudah termasuk akses penuh ke semua fitur.
            </p>
        </div>
        
        <!-- One-time payment info -->
        <div class="flex items-center justify-center gap-2 mb-12">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Sekali bayar, aktif 1 tahun penuh. Tanpa biaya bulanan.</span>
        </div>
        
        <!-- Pricing Cards -->
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($packages as $index => $package)
            <div class="relative group" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <!-- Popular Badge -->
                @if($package->is_featured)
                <div class="absolute -top-5 left-1/2 -translate-x-1/2 z-10">
                    <div class="px-4 py-1.5 bg-gradient-to-r from-amber-500 to-rose-500 text-white text-xs font-bold rounded-full shadow-lg shadow-amber-500/30">
                        PALING POPULER
                    </div>
                </div>
                @endif


                <!-- Card -->
                <div class="relative h-full p-8 rounded-3xl transition-all duration-500 {{ $package->is_featured ? 'bg-gradient-to-b from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-900 text-white shadow-2xl shadow-gray-900/20 scale-105 border-2 border-amber-500/50' : 'bg-white dark:bg-gray-800 border-2 border-gray-100 dark:border-gray-700 hover:border-amber-200 dark:hover:border-amber-800 hover:shadow-xl' }} group-hover:-translate-y-2">
                    
                    <!-- Glow Effect for Featured -->
                    @if($package->is_featured)
                    <div class="absolute -inset-px bg-gradient-to-r from-amber-500 to-rose-500 rounded-3xl blur opacity-20"></div>
                    @endif
                    
                    <div class="relative">
                        <!-- Package Name -->
                        <div class="mb-6">
                            <h3 class="text-2xl font-bold {{ $package->is_featured ? 'text-white' : 'text-gray-900 dark:text-white' }} mb-2">{{ $package->name }}</h3>
                            <p class="text-sm {{ $package->is_featured ? 'text-gray-300' : 'text-gray-500 dark:text-gray-400' }}">{{ $package->description }}</p>
                        </div>
                        
                        <!-- Price -->
                        <div class="mb-8">
                            @if($package->discount_price)
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm {{ $package->is_featured ? 'text-gray-400' : 'text-gray-400' }} line-through">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                                <span class="px-2 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs font-semibold rounded">HEMAT {{ round((($package->price - $package->discount_price) / $package->price) * 100) }}%</span>
                            </div>
                            @endif
                            <div class="flex items-baseline gap-1">
                                <span class="text-sm {{ $package->is_featured ? 'text-gray-300' : 'text-gray-500' }}">Rp</span>
                                <span class="text-5xl font-bold {{ $package->is_featured ? 'text-white' : 'text-gray-900 dark:text-white' }}">{{ number_format($package->getEffectivePrice(), 0, ',', '.') }}</span>
                            </div>
                            <p class="text-sm {{ $package->is_featured ? 'text-gray-400' : 'text-gray-500 dark:text-gray-400' }} mt-1">/ {{ $package->duration_days }} hari</p>
                        </div>
                        
                        <!-- Features -->
                        <ul class="space-y-4 mb-8">
                            @if($package->features)
                            @foreach($package->features as $feature)
                            <li class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-full {{ $package->is_featured ? 'bg-amber-500' : 'bg-green-100 dark:bg-green-900/30' }} flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3 h-3 {{ $package->is_featured ? 'text-white' : 'text-green-600 dark:text-green-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm {{ $package->is_featured ? 'text-gray-300' : 'text-gray-600 dark:text-gray-300' }}">{{ $feature }}</span>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                        
                        <!-- CTA Button -->
                        <a href="{{ route('register') }}" class="block w-full py-4 text-center font-semibold rounded-2xl transition-all duration-300 {{ $package->is_featured ? 'bg-gradient-to-r from-amber-500 to-rose-500 text-white hover:shadow-lg hover:shadow-amber-500/30 hover:scale-105' : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-amber-500 hover:text-white' }}">
                            Pilih {{ $package->name }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Money Back Guarantee -->
        <div class="mt-16 text-center">
            <div class="inline-flex items-center gap-4 px-6 py-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <p class="font-semibold text-green-800 dark:text-green-300">Garansi 100% Uang Kembali</p>
                    <p class="text-sm text-green-600 dark:text-green-400">7 hari pertama tidak puas? Kami kembalikan uang Anda.</p>
                </div>
            </div>
        </div>
    </div>
</section>
