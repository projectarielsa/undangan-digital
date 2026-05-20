@extends('layouts.dashboard')
@section('page-title', 'Detail Tiket')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="max-w-4xl" x-data="adminSupportChat()" x-init="startPolling()">
    <a href="{{ route('admin.support.index') }}" class="text-sm text-gray-500 hover:text-blue-600 flex items-center gap-1 mb-6">
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
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full" :class="statusClass" x-text="statusLabel">{{ $ticket->status_label }}</span>
                </div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $ticket->subject }}</h1>
                <p class="text-sm text-gray-500 mt-2">Dibuat {{ $ticket->created_at->format('d M Y H:i') }}</p>
            </div>

            <!-- Messages (Live) -->
            <div class="space-y-4" id="messages-container">
                <template x-for="msg in messages" :key="msg.id">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5" :class="msg.is_admin_reply ? 'border-l-4 border-l-blue-500' : ''">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" :class="msg.is_admin_reply ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-gray-100 dark:bg-gray-700'">
                                <span class="font-medium" :class="msg.is_admin_reply ? 'text-blue-600' : 'text-gray-600 dark:text-gray-300'" x-text="msg.user_initial"></span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-medium text-gray-900 dark:text-white" x-text="msg.user_name"></span>
                                    <template x-if="msg.is_admin_reply">
                                        <span class="px-1.5 py-0.5 text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded">Admin</span>
                                    </template>
                                    <span class="text-xs text-gray-400" x-text="msg.created_at"></span>
                                </div>
                                <div class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap" x-text="msg.message"></div>
                                <template x-if="msg.attachment_url">
                                    <a :href="msg.attachment_url" target="_blank" class="inline-flex items-center gap-1 mt-2 text-sm text-blue-600 hover:underline">Lampiran</a>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- New message indicator -->
            <div x-show="newMessageAlert" x-transition class="p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl text-center">
                <span class="text-sm text-blue-700 dark:text-blue-300 font-medium">Pesan baru dari customer!</span>
            </div>

            <!-- Reply Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Balas Tiket</h3>
                <form method="POST" action="{{ route('admin.support.reply', $ticket) }}" enctype="multipart/form-data">
                    @csrf
                    <textarea name="message" rows="4" required placeholder="Tulis balasan..." class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white mb-4"></textarea>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <input type="file" name="attachment" class="text-sm text-gray-500">
                            <select name="new_status" class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white">
                                <option value="">Status tetap</option>
                                <option value="in_progress">Dalam Proses</option>
                                <option value="waiting_customer">Menunggu Customer</option>
                                <option value="resolved">Selesai</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700">Kirim</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Customer</h3>
                <p class="font-medium text-gray-900 dark:text-white">{{ $ticket->user->name }}</p>
                <p class="text-sm text-gray-500">{{ $ticket->user->email }}</p>
                @if($ticket->invitation)
                <p class="text-sm text-gray-500 mt-2">Undangan: {{ $ticket->invitation->title }}</p>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Update Status</h3>
                <form method="POST" action="{{ route('admin.support.status', $ticket) }}">
                    @csrf @method('PUT')
                    <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white">
                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Baru</option>
                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="waiting_customer" {{ $ticket->status == 'waiting_customer' ? 'selected' : '' }}>Menunggu Customer</option>
                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Selesai</option>
                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Prioritas</h3>
                <form method="POST" action="{{ route('admin.support.priority', $ticket) }}">
                    @csrf @method('PUT')
                    <select name="priority" onchange="this.form.submit()" class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white">
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

<script>
function adminSupportChat() {
    return {
        messages: @json($ticket->messages->map(function($m) {
            return [
                'id' => $m->id,
                'is_admin_reply' => $m->is_admin_reply,
                'user_name' => $m->user->name,
                'user_initial' => substr($m->user->name, 0, 1),
                'message' => $m->message,
                'attachment_url' => $m->attachment ? $m->attachment_url : null,
                'created_at' => $m->created_at->format('d M Y H:i'),
            ];
        })),
        ticketStatus: '{{ $ticket->status }}',
        newMessageAlert: false,
        pollInterval: null,

        get statusLabel() {
            const labels = {open:'Baru',in_progress:'Dalam Proses',waiting_customer:'Menunggu Customer',resolved:'Selesai',closed:'Ditutup'};
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
                const res = await fetch('{{ route("admin.support.messages", $ticket) }}');
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
