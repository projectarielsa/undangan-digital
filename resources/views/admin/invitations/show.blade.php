@extends('layouts.dashboard')
@section('page-title', 'Detail Undangan')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ $invitation->title }}</h3>
    <dl class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
        <div><dt class="text-gray-500">Owner</dt><dd class="font-medium">{{ $invitation->user->name }}</dd></div>
        <div><dt class="text-gray-500">Tanggal</dt><dd class="font-medium">{{ $invitation->event_date->format('d M Y') }}</dd></div>
        <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ ucfirst($invitation->status) }}</dd></div>
        <div><dt class="text-gray-500">Views</dt><dd class="font-medium">{{ number_format($invitation->view_count) }}</dd></div>
        <div><dt class="text-gray-500">Tamu</dt><dd class="font-medium">{{ $invitation->guests->count() }}</dd></div>
        <div><dt class="text-gray-500">Ucapan</dt><dd class="font-medium">{{ $invitation->guestbooks->count() }}</dd></div>
    </dl>
</div>
@endsection
