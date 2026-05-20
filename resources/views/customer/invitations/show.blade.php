@extends('layouts.dashboard')
@section('page-title', $invitation->title)
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Detail Undangan</h3>
        <dl class="grid grid-cols-2 gap-4 text-sm">
            <div><dt class="text-gray-500">Mempelai</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</dd></div>
            <div><dt class="text-gray-500">Tanggal</dt><dd class="font-medium">{{ $invitation->event_date->format('d M Y') }}</dd></div>
            <div><dt class="text-gray-500">Tempat</dt><dd class="font-medium">{{ $invitation->event_venue }}</dd></div>
            <div><dt class="text-gray-500">Status</dt><dd><span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-700">{{ ucfirst($invitation->status) }}</span></dd></div>
            <div><dt class="text-gray-500">Views</dt><dd class="font-medium">{{ number_format($invitation->view_count) }}</dd></div>
            <div><dt class="text-gray-500">URL</dt><dd><a href="{{ $invitation->getUrl() }}" target="_blank" class="text-blue-600 hover:underline">{{ $invitation->slug }}</a></dd></div>
        </dl>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">RSVP Stats</h3>
        <div class="space-y-3">
            <div class="flex justify-between text-sm"><span class="text-gray-500">Total Tamu</span><span class="font-medium">{{ $rsvpStats['total'] }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-green-600">Hadir</span><span class="font-medium">{{ $rsvpStats['attending'] }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-red-600">Tidak Hadir</span><span class="font-medium">{{ $rsvpStats['not_attending'] }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-yellow-600">Mungkin</span><span class="font-medium">{{ $rsvpStats['maybe'] }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-gray-500">Pending</span><span class="font-medium">{{ $rsvpStats['pending'] }}</span></div>
        </div>
    </div>
</div>
@endsection
