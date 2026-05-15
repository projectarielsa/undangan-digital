<!-- Pricing -->
<section id="pricing" class="py-20 lg:py-32 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4 font-serif">Pilih Paket Terbaik</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Harga terjangkau untuk undangan digital berkualitas premium</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            @foreach($packages as $package)
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl p-8 border-2 {{ $package->is_featured ? 'border-amber-500 shadow-xl shadow-amber-500/10' : 'border-gray-100 dark:border-gray-700' }} transition-all hover:shadow-lg">
                @if($package->is_featured)<div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 bg-gradient-to-r from-amber-500 to-amber-600 text-white text-xs font-bold rounded-full">PALING POPULER</div>@endif
                <div class="text-center mb-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $package->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $package->description }}</p>
                    @if($package->discount_price)<span class="text-sm text-gray-400 line-through">Rp {{ number_format($package->price, 0, ',', '.') }}</span>@endif
                    <div class="flex items-baseline justify-center gap-1"><span class="text-4xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($package->getEffectivePrice(), 0, ',', '.') }}</span></div>
                    <p class="text-sm text-gray-500 mt-1">/ {{ $package->duration_days }} hari</p>
                </div>
                <ul class="space-y-3 mb-8">
                    @if($package->features)@foreach($package->features as $feature)
                    <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-300">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"/></svg>{{ $feature }}
                    </li>
                    @endforeach @endif
                </ul>
                <a href="{{ route('register') }}" class="block w-full py-3 px-4 text-center font-semibold rounded-2xl transition-all {{ $package->is_featured ? 'bg-gradient-to-r from-amber-600 to-amber-700 text-white shadow-lg shadow-amber-500/25' : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-200' }}">Pilih {{ $package->name }}</a>
            </div>
            @endforeach
        </div>
    </div>
</section>
