@extends('layouts.dashboard')
@section('page-title', 'Kelola Undangan')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-2xl border">
    <div class="p-6 border-b flex items-center justify-between flex-wrap gap-4">
        <h3 class="font-semibold text-gray-900 dark:text-white">Semua Undangan ({{ $invitations->total() }})</h3>
        <form method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="px-4 py-2 text-sm bg-gray-50 dark:bg-gray-700 border rounded-xl">
            <select name="status" onchange="this.form.submit()" class="px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl"><option value="">Semua</option><option value="draft" {{ request('status')==='draft'?'selected':'' }}>Draft</option><option value="published" {{ request('status')==='published'?'selected':'' }}>Published</option><option value="paused" {{ request('status')==='paused'?'selected':'' }}>Paused</option></select>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Undangan</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Template</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Views</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th></tr></thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($invitations as $inv)
                <tr>
                    <td class="px-6 py-4"><p class="font-medium text-gray-900 dark:text-white">{{ $inv->title }}</p><p class="text-xs text-gray-500">{{ $inv->event_date->format('d M Y') }}</p></td>
                    <td class="px-6 py-4 text-gray-500">{{ $inv->user->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $inv->template?->name ?? '-' }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 text-xs rounded-full {{ $inv->status==='published'?'bg-green-100 text-green-700':'bg-gray-100 text-gray-700' }}">{{ ucfirst($inv->status) }}</span></td>
                    <td class="px-6 py-4">{{ number_format($inv->view_count) }}</td>
                    <td class="px-6 py-4"><form method="POST" action="{{ route('admin.invitations.destroy', $inv) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline text-sm">Hapus</button></form></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $invitations->links() }}</div>
</div>
@endsection
