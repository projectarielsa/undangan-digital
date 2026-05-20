@extends('layouts.dashboard')
@section('page-title', 'Pembayaran')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="grid grid-cols-2 gap-4 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl p-6 text-white"><p class="text-blue-100 text-sm">Total Revenue</p><p class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p></div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border"><p class="text-gray-500 text-sm">Bulan Ini</p><p class="text-3xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p></div>
</div>
<div class="bg-white dark:bg-gray-800 rounded-2xl border">
    <div class="p-6 border-b flex items-center justify-between">
        <h3 class="font-semibold text-gray-900 dark:text-white">Semua Transaksi</h3>
        <form method="GET"><select name="status" onchange="this.form.submit()" class="px-3 py-2 text-sm bg-gray-50 border rounded-xl"><option value="">Semua</option><option value="paid" {{ request('status')==='paid'?'selected':'' }}>Paid</option><option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option><option value="failed" {{ request('status')==='failed'?'selected':'' }}>Failed</option></select></form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th></tr></thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($payments as $payment)
                <tr>
                    <td class="px-6 py-4 font-mono text-xs">{{ $payment->order_id }}</td>
                    <td class="px-6 py-4">{{ $payment->user->name }}</td>
                    <td class="px-6 py-4">{{ $payment->package->name }}</td>
                    <td class="px-6 py-4 font-medium">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 text-xs rounded-full {{ $payment->status==='paid'?'bg-green-100 text-green-700':($payment->status==='pending'?'bg-yellow-100 text-yellow-700':'bg-red-100 text-red-700') }}">{{ ucfirst($payment->status) }}</span></td>
                    <td class="px-6 py-4 text-gray-500">{{ $payment->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $payments->links() }}</div>
</div>
@endsection
