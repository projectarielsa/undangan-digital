<!-- Features -->
<section id="features" class="py-20 lg:py-32 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4 font-serif">Fitur Premium untuk Hari Spesial Anda</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Semua yang Anda butuhkan untuk undangan pernikahan digital yang sempurna</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php $features = [
                ['icon'=>'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z','title'=>'Template Premium','desc'=>'Pilihan template elegan dirancang khusus untuk pernikahan impian'],
                ['icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','title'=>'Countdown Timer','desc'=>'Hitung mundur otomatis menuju hari bahagia yang membuat tamu excited'],
                ['icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01','title'=>'RSVP Online','desc'=>'Kelola konfirmasi kehadiran tamu dengan mudah dan real-time'],
                ['icon'=>'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3','title'=>'Background Music','desc'=>'Tambahkan musik latar romantis untuk pengalaman yang lebih berkesan'],
                ['icon'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z','title'=>'Galeri Foto','desc'=>'Tampilkan momen indah prewedding dengan galeri foto yang elegan'],
                ['icon'=>'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z','title'=>'Amplop Digital','desc'=>'Terima hadiah secara digital melalui transfer bank atau QRIS'],
            ]; @endphp
            @foreach($features as $f)
            <div class="group p-8 bg-gray-50 dark:bg-gray-800 rounded-3xl hover:bg-amber-50 dark:hover:bg-amber-900/10 border border-gray-100 dark:border-gray-700 hover:border-amber-200 transition-all duration-300">
                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-amber-200 transition-colors">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $f['title'] }}</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
