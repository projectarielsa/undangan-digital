@extends('layouts.dashboard')
@section('page-title', 'Kelola Users')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">
    <p class="text-sm text-green-700">{{ session('success') }}</p>
</div>
@endif

<div class="bg-white dark:bg-gray-800 rounded-2xl border">
    <div class="p-6 border-b flex items-center justify-between">
        <h3 class="font-semibold text-gray-900 dark:text-white">Users ({{ $users->total() }})</h3>
        <form method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari user..." class="px-4 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500">
            <button type="submit" class="px-4 py-2 bg-amber-600 text-white text-sm rounded-xl hover:bg-amber-700">Cari</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Undangan</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Langganan</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th></tr></thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($users as $user)
                @php $activeSub = $user->subscriptions->where('status', 'active')->where('expires_at', '>', now())->first(); @endphp
                <tr>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4">{{ $user->invitations_count }}</td>
                    <td class="px-6 py-4">
                        @if($activeSub)
                        <span class="px-2 py-0.5 text-xs rounded-full bg-amber-100 text-amber-700">{{ $activeSub->package?->name ?? 'Premium' }}</span>
                        @else
                        <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-500">Free</span>
                        @endif
                    </td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 text-xs rounded-full {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td class="px-6 py-4 flex items-center gap-2">
                        <a href="{{ route('admin.users.show', $user) }}" class="text-sm text-amber-600 hover:underline">Detail</a>
                        <form method="POST" action="{{ route('admin.users.toggle', $user) }}">@csrf<button class="text-sm text-gray-500 hover:underline">{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $users->links() }}</div>
</div>
@endsection
