@extends('layouts.dashboard')
@section('page-title', 'Detail Tiket')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('admin.support.index') }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Ticket Info -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-sm font-mono text-gray-400">{{ $ticket->ticket_number }}</span>
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-{{ $ticket->status_color }}-100 text-{{ $ticket->status_color }}-700">{{ $ticket->status_label }}</span>
                </div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $ticket->subject }}</h1>
                <p class="text-sm text-gray-500 mt-2">Dibuat {{ $ticket->created_at->format('d M Y H:i') }}</p>
            </div>

            <!-- Messages -->
            <div class="space-y-4">
                @foreach($ticket->messages as $message)
                <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5 {{ $message->is_admin_reply ? 'border-l-4 border-l-amber-500' : '' }}">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 {{ $message->is_admin_reply ? 'bg-amber-100' : 'bg-gray-100' }}">
                            <span class="font-medium {{ $message->is_admin_reply ? 'text-amber-600' : 'text-gray-600' }}">{{ substr($message->user->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $message->user->name }}</span>
                                @if($message->is_admin_reply)<span class="px-1.5 py-0.5 text-xs bg-amber-100 text-amber-700 rounded">Admin</span>@endif
                                <span class="text-xs text-gray-400">{{ $message->created_at->format('d M H:i') }}</span>
                            </div>
                            <div class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $message->message }}</div>
                            @if($message->attachment)
                            <a href="{{ $message->attachment_url }}" target="_blank" class="inline-flex items-center gap-1 mt-2 text-sm text-amber-600 hover:underline">📎 Lampiran</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Reply Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Balas Tiket</h3>
                <form method="POST" action="{{ route('admin.support.reply', $ticket) }}" enctype="multipart/form-data">
                    @csrf
                    <textarea name="message" rows="4" required placeholder="Tulis balasan..." class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl mb-4"></textarea>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <input type="file" name="attachment" class="text-sm text-gray-500">
                            <select name="new_status" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                                <option value="">Status tetap</option>
                                <option value="in_progress">Dalam Proses</option>
                                <option value="waiting_customer">Menunggu Customer</option>
                                <option value="resolved">Selesai</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-amber-600 text-white font-semibold rounded-xl hover:bg-amber-700">Kirim</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-4">
            <!-- Customer Info -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Customer</h3>
                <p class="font-medium text-gray-900 dark:text-white">{{ $ticket->user->name }}</p>
                <p class="text-sm text-gray-500">{{ $ticket->user->email }}</p>
                @if($ticket->invitation)
                <p class="text-sm text-gray-500 mt-2">Undangan: {{ $ticket->invitation->title }}</p>
                @endif
            </div>

            <!-- Status Update -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Update Status</h3>
                <form method="POST" action="{{ route('admin.support.status', $ticket) }}">
                    @csrf @method('PUT')
                    <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Baru</option>
                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="waiting_customer" {{ $ticket->status == 'waiting_customer' ? 'selected' : '' }}>Menunggu Customer</option>
                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Selesai</option>
                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                </form>
            </div>

            <!-- Priority Update -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Prioritas</h3>
                <form method="POST" action="{{ route('admin.support.priority', $ticket) }}">
                    @csrf @method('PUT')
                    <select name="priority" onchange="this.form.submit()" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                        <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Rendah</option>
                        <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>Tinggi</option>
                        <option value="urgent" {{ $ticket->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
