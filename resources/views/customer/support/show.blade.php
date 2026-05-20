@extends('layouts.dashboard')
@section('page-title', 'Detail Tiket')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('customer.support.index') }}" class="text-sm text-gray-500 hover:text-blue-600 flex items-center gap-1 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Daftar Tiket
    </a>

    <!-- Ticket Header -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-sm font-mono text-gray-400">{{ $ticket->ticket_number }}</span>
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-{{ $ticket->status_color }}-100 text-{{ $ticket->status_color }}-700">{{ $ticket->status_label }}</span>
                </div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $ticket->subject }}</h1>
                <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                    <span>{{ $ticket->category_label }}</span>
                    <span>•</span>
                    <span>{{ $ticket->created_at->format('d M Y H:i') }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                @if($ticket->status === 'resolved' || $ticket->status === 'closed')
                <form method="POST" action="{{ route('customer.support.reopen', $ticket) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm font-medium border border-gray-200 rounded-xl hover:bg-gray-50 transition">Buka Kembali</button>
                </form>
                @else
                <form method="POST" action="{{ route('customer.support.close', $ticket) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm font-medium border border-gray-200 rounded-xl hover:bg-gray-50 transition">Tutup Tiket</button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Messages -->
    <div class="space-y-4 mb-6">
        @foreach($ticket->messages as $message)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5 {{ $message->is_admin_reply ? 'border-l-4 border-l-blue-500' : '' }}">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 {{ $message->is_admin_reply ? 'bg-blue-100' : 'bg-gray-100' }}">
                    @if($message->is_admin_reply)
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    @else
                    <span class="font-medium text-gray-600">{{ substr($message->user->name, 0, 1) }}</span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-medium text-gray-900 dark:text-white">{{ $message->is_admin_reply ? 'Tim Support' : $message->user->name }}</span>
                        <span class="text-xs text-gray-400">{{ $message->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $message->message }}</div>
                    @if($message->attachment)
                    <a href="{{ $message->attachment_url }}" target="_blank" class="inline-flex items-center gap-1 mt-2 text-sm text-blue-600 hover:text-blue-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        Lihat Lampiran
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Reply Form -->
    @if($ticket->status !== 'closed')
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Balas Tiket</h3>
        <form method="POST" action="{{ route('customer.support.reply', $ticket) }}" enctype="multipart/form-data">
            @csrf
            <textarea name="message" rows="4" required placeholder="Tulis balasan Anda..." class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 mb-4"></textarea>
            <div class="flex items-center justify-between">
                <input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition">Kirim Balasan</button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
