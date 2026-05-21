@extends('layouts.dashboard')
@section('page-title', 'Support Tickets')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="max-w-6xl">
    <!-- Stats -->
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl border p-4">
            <p class="text-2xl font-bold text-blue-600">{{ $stats['open'] }}</p>
            <p class="text-sm text-gray-500">Baru</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border p-4">
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['in_progress'] }}</p>
            <p class="text-sm text-gray-500">Dalam Proses</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border p-4">
            <p class="text-2xl font-bold text-orange-600">{{ $stats['waiting'] }}</p>
            <p class="text-sm text-gray-500">Menunggu Customer</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border p-4">
            <p class="text-2xl font-bold text-green-600">{{ $stats['resolved'] }}</p>
            <p class="text-sm text-gray-500">Selesai</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <select name="status" onchange="this.form.submit()" class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white">
                <option value="all">Semua Status</option>
                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Baru</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                <option value="waiting_customer" {{ request('status') == 'waiting_customer' ? 'selected' : '' }}>Menunggu Customer</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
            </select>
            <select name="priority" onchange="this.form.submit()" class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white">
                <option value="all">Semua Prioritas</option>
                <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
            </select>
        </form>
    </div>

    <!-- Tickets Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Tiket</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Customer</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Kategori</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Prioritas</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Status</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Tanggal</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($tickets as $ticket)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <td class="px-4 py-3">
                        <p class="font-medium text-gray-900 dark:text-white">{{ $ticket->subject }}</p>
                        <p class="text-xs text-gray-400">{{ $ticket->ticket_number }}</p>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $ticket->user->name }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $ticket->category_label }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $ticket->priority == 'urgent' ? 'bg-red-100 text-red-700' : ($ticket->priority == 'high' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-700') }}">{{ $ticket->priority_label }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-{{ $ticket->status_color }}-100 text-{{ $ticket->status_color }}-700">{{ $ticket->status_label }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $ticket->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.support.show', $ticket) }}" class="text-blue-600 hover:text-blue-700 font-medium">Lihat</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Tidak ada tiket</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->hasPages())
    <div class="mt-6">{{ $tickets->links() }}</div>
    @endif
</div>
@endsection
