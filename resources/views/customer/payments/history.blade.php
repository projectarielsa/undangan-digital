@extends('layouts.dashboard')
@section('page-title', 'Riwayat Pembayaran')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-2xl border">
    <div class="p-6 border-b"><h3 class="font-semibold text-gray-900 dark:text-white">Riwayat Pembayaran</h3></div>
    @if($payments->isEmpty())
    <div class="p-12 text-center text-gray-500">Belum ada riwayat pembayaran.</div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($payments as $payment)
                <tr>
                    <td class="px-6 py-4 font-mono text-xs">{{ $payment->order_id }}</td>
                    <td class="px-6 py-4">{{ $payment->package->name }}</td>
                    <td class="px-6 py-4 font-medium">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $payment->status === 'paid' ? 'bg-green-100 text-green-700' : ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">{{ ucfirst($payment->status) }}</span></td>
                    <td class="px-6 py-4 text-gray-500">{{ $payment->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $payments->links() }}</div>
    @endif
</div>
@endsection
