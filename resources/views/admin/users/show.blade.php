@extends('layouts.dashboard')
@section('page-title', 'Detail User')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="max-w-4xl bg-white dark:bg-gray-800 rounded-2xl border p-6">
    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">{{ $user->name }}</h3>
    <dl class="grid grid-cols-2 gap-4 text-sm">
        <div><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $user->email }}</dd></div>
        <div><dt class="text-gray-500">Bergabung</dt><dd class="font-medium">{{ $user->created_at->format('d M Y') }}</dd></div>
        <div><dt class="text-gray-500">Undangan</dt><dd class="font-medium">{{ $user->invitations->count() }}</dd></div>
        <div><dt class="text-gray-500">Status</dt><dd><span class="px-2 py-0.5 text-xs rounded-full {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span></dd></div>
    </dl>
</div>
@endsection
