@extends('layouts.dashboard')
@section('page-title', 'Detail Tiket')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-3xl" x-data="supportChat()" x-init="startPolling()">
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
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full" :class="statusClass" x-text="statusLabel">{{ $ticket->status_label }}</span>
                </div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $ticket->subject }}</h1>
                <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                    <span>{{ $ticket->category_label }}</span>
                    <span>&bull;</span>
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

    <!-- Messages (Live) -->
    <div class="space-y-4 mb-6" id="messages-container">
        <template x-for="msg in messages" :key="msg.id">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5" :class="msg.is_admin_reply ? 'border-l-4 border-l-blue-500' : ''">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" :class="msg.is_admin_reply ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-gray-100 dark:bg-gray-700'">
                        <template x-if="msg.is_admin_reply">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </template>
                        <template x-if="!msg.is_admin_reply">
                            <span class="font-medium text-gray-600 dark:text-gray-300" x-text="msg.user_initial"></span>
                        </template>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-medium text-gray-900 dark:text-white" x-text="msg.user_name"></span>
                            <span class="text-xs text-gray-400" x-text="msg.created_at"></span>
                        </div>
                        <div class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap" x-text="msg.message"></div>
                        <template x-if="msg.attachment_url">
                            <a :href="msg.attachment_url" target="_blank" class="inline-flex items-center gap-1 mt-2 text-sm text-blue-600 hover:text-blue-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                Lihat Lampiran
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- New message indicator -->
    <div x-show="newMessageAlert" x-transition class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl text-center">
        <span class="text-sm text-blue-700 dark:text-blue-300 font-medium">Pesan baru diterima!</span>
    </div>

    <!-- Reply Form -->
    <div x-show="ticketStatus !== 'closed'" class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Balas Tiket</h3>
        <form method="POST" action="{{ route('customer.support.reply', $ticket) }}" enctype="multipart/form-data">
            @csrf
            <textarea name="message" rows="4" required placeholder="Tulis balasan Anda..." class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 mb-4"></textarea>
            <div class="flex items-center justify-between">
                <input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition">Kirim Balasan</button>
            </div>
        </form>
    </div>
</div>

<script>
function supportChat() {
    return {
        messages: @json($ticket->messages->map(fn($m) => [
            'id' => $m->id,
            'is_admin_reply' => $m->is_admin_reply,
            'user_name' => $m->is_admin_reply ? 'Tim Support' : $m->user->name,
            'user_initial' => substr($m->user->name, 0, 1),
            'message' => $m->message,
            'attachment_url' => $m->attachment ? $m->attachment_url : null,
            'created_at' => $m->created_at->format('d M Y H:i'),
        ])),
        ticketStatus: '{{ $ticket->status }}',
        newMessageAlert: false,
        pollInterval: null,

        get statusLabel() {
            const labels = {open:'Baru',in_progress:'Dalam Proses',waiting_customer:'Menunggu Anda',resolved:'Selesai',closed:'Ditutup'};
            return labels[this.ticketStatus] || this.ticketStatus;
        },
        get statusClass() {
            const classes = {
                open:'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                in_progress:'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                waiting_customer:'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300',
                resolved:'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                closed:'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-300'
            };
            return classes[this.ticketStatus] || '';
        },

        startPolling() {
            this.pollInterval = setInterval(() => this.fetchMessages(), 5000);
        },

        async fetchMessages() {
            try {
                const res = await fetch('{{ route("customer.support.messages", $ticket) }}');
                const data = await res.json();
                if (data.messages.length > this.messages.length) {
                    this.newMessageAlert = true;
                    setTimeout(() => this.newMessageAlert = false, 3000);
                }
                this.messages = data.messages;
                this.ticketStatus = data.status;
            } catch (e) {}
        },

        destroy() {
            if (this.pollInterval) clearInterval(this.pollInterval);
        }
    }
}
</script>
@endsection
