@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-16 px-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Preview Template</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Lihat demo undangan digital kami. Klik template untuk melihat preview lengkap dengan data contoh.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-6 text-amber-600 hover:text-amber-700 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- Template Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($templates as $template)
            <a href="{{ route('demo.show', $template->slug) }}" class="group block bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-amber-200">
                <!-- Preview -->
                <div class="aspect-[3/4] relative overflow-hidden" style="background: linear-gradient(135deg, {{ $template->color_primary }}20, {{ $template->color_secondary }}10)">
                    <div class="absolute inset-0 flex items-center justify-center p-8">
                        <div class="text-center">
                            <p class="text-xs uppercase tracking-[0.3em] opacity-60 mb-3" style="color: {{ $template->color_primary }}">{{ $template->category }}</p>
                            <h3 class="text-2xl font-serif font-semibold text-gray-800 mb-2">{{ $template->name }}</h3>
                            <p class="text-sm text-gray-500 mb-6">{{ $template->description ?? 'Template undangan digital' }}</p>
                            
                            <!-- Color Palette -->
                            <div class="flex items-center justify-center gap-2 mb-6">
                                <div class="w-6 h-6 rounded-full border-2 border-white shadow-sm" style="background: {{ $template->color_primary }}"></div>
                                <div class="w-6 h-6 rounded-full border-2 border-white shadow-sm" style="background: {{ $template->color_secondary }}"></div>
                                @if($template->color_accent)
                                <div class="w-6 h-6 rounded-full border-2 border-white shadow-sm" style="background: {{ $template->color_accent }}"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hover overlay -->
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-center justify-center">
                        <div class="px-8 py-3 bg-white text-gray-900 font-semibold rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                            Lihat Demo
                        </div>
                    </div>
                    
                    @if($template->is_premium)
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded-full flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            PRO
                        </span>
                    </div>
                    @endif
                </div>
                
                <!-- Info -->
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $template->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $template->category }} {{ $template->is_premium ? '• Premium' : '• Gratis' }}</p>
                </div>
            </a>
            @endforeach
        </div>

        <!-- CTA -->
        <div class="text-center mt-16">
            <p class="text-gray-600 mb-6">Suka dengan template-nya? Buat undangan digital Anda sekarang!</p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-amber-700 transition-all shadow-lg shadow-amber-500/25">
                Mulai Buat Undangan
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</div>
@endsection
