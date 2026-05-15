<!-- Templates -->
<section id="templates" class="py-20 lg:py-32 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4 font-serif">Template yang Memukau</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Dirancang oleh desainer profesional untuk pernikahan impian Anda</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($templates as $template)
            <div class="group relative bg-white dark:bg-gray-900 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                <div class="aspect-[3/4] relative overflow-hidden flex items-center justify-center" style="background: linear-gradient(135deg, {{ $template->color_primary }}20, {{ $template->color_secondary }}20)">
                    <div class="text-center p-6">
                        <p class="text-sm font-medium uppercase tracking-widest mb-2" style="color: {{ $template->color_primary }}">{{ $template->category }}</p>
                        <h3 class="text-2xl font-serif font-bold text-gray-900 dark:text-white">{{ $template->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">{{ $template->description }}</p>
                    </div>
                    @if($template->is_premium)<div class="absolute top-4 right-4 px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded-full">PREMIUM</div>@endif
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $template->name }}</h4>
                            <p class="text-sm text-gray-500">Font: {{ $template->font_heading }}</p>
                        </div>
                        <div class="flex gap-1">
                            <div class="w-6 h-6 rounded-full border-2 border-white shadow-sm" style="background: {{ $template->color_primary }}"></div>
                            <div class="w-6 h-6 rounded-full border-2 border-white shadow-sm" style="background: {{ $template->color_secondary }}"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
