@extends('layouts.dashboard')
@section('page-title', 'Kelola Template')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Template</h2>
    <a href="{{ route('admin.templates.create') }}" class="px-5 py-2.5 bg-amber-600 text-white text-sm font-semibold rounded-xl hover:bg-amber-700 transition">+ Template Baru</a>
</div>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($templates as $template)
    <div class="bg-white dark:bg-gray-800 rounded-2xl border overflow-hidden">
        <div class="aspect-video flex items-center justify-center" style="background: linear-gradient(135deg, {{ $template->color_primary }}30, {{ $template->color_secondary }}20)">
            <span class="font-serif text-lg font-bold" style="color: {{ $template->color_primary }}">{{ $template->name }}</span>
        </div>
        <div class="p-4">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $template->name }}</h3>
                @if($template->is_premium)<span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Premium</span>@endif
            </div>
            <p class="text-sm text-gray-500 mb-3">{{ $template->category }} | {{ $template->blade_view }}</p>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.templates.edit', $template) }}" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">Edit</a>
                <form method="POST" action="{{ route('admin.templates.destroy', $template) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="px-3 py-1.5 text-red-600 text-sm hover:bg-red-50 rounded-lg transition">Hapus</button></form>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-6">{{ $templates->links() }}</div>
@endsection
