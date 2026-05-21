@extends('layouts.dashboard')
@section('page-title', 'Detail Pembayaran')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="max-w-2xl bg-white dark:bg-gray-800 rounded-2xl border p-6">
    <h3 class="text-lg font-semibold mb-4">{{ $payment->order_id }}</h3>
    <dl class="grid grid-cols-2 gap-4 text-sm">
        <div><dt class="text-gray-500">User</dt><dd class="font-medium">{{ $payment->user->name }}</dd></div>
        <div><dt class="text-gray-500">Paket</dt><dd class="font-medium">{{ $payment->package->name }}</dd></div>
        <div><dt class="text-gray-500">Total</dt><dd class="font-medium">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</dd></div>
        <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ ucfirst($payment->status) }}</dd></div>
        <div><dt class="text-gray-500">Payment Type</dt><dd class="font-medium">{{ $payment->payment_type ?? '-' }}</dd></div>
        <div><dt class="text-gray-500">Paid At</dt><dd class="font-medium">{{ $payment->paid_at?->format('d M Y H:i') ?? '-' }}</dd></div>
    </dl>
</div>
@endsection
