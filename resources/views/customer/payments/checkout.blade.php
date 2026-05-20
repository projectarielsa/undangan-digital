@extends('layouts.dashboard')
@section('page-title', 'Pembayaran')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-lg mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-8 text-center">
        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Checkout - Paket {{ $package->name }}</h2>
        <p class="text-3xl font-bold text-blue-600 mb-2">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</p>
        <p class="text-sm text-gray-500 mb-8">Order ID: {{ $payment->order_id }}</p>
        <button id="pay-button" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all transform hover:scale-[1.02]">Bayar Sekarang</button>
        <p class="text-xs text-gray-400 mt-4">Pembayaran aman melalui Midtrans</p>
    </div>
</div>

@push('scripts')
<script src="{{ config('services.midtrans.snap_url') }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
document.getElementById('pay-button').addEventListener('click', function() {
    snap.pay('{{ $payment->midtrans_snap_token }}', {
        onSuccess: function(result) { window.location.href = '{{ route("customer.payments.finish") }}?order_id={{ $payment->order_id }}'; },
        onPending: function(result) { window.location.href = '{{ route("customer.payments.finish") }}?order_id={{ $payment->order_id }}'; },
        onError: function(result) { alert('Pembayaran gagal. Silakan coba lagi.'); }
    });
});
</script>
@endpush
@endsection
