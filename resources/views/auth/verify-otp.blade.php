@extends('layouts.auth', ['title' => 'Verifikasi OTP'])

@section('content')
<div class="text-center" x-data="otpForm()">
    <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-full mb-6">
        <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
    </div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Verifikasi Email</h2>
    <p class="text-gray-500 dark:text-gray-400 mb-2">Masukkan kode 6 digit yang dikirim ke</p>
    <p class="text-amber-600 dark:text-amber-400 font-medium mb-8">{{ $email }}</p>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl"><p class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p></div>
    @endif
    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl"><p class="text-sm text-red-600 dark:text-red-400">{{ $errors->first() }}</p></div>
    @endif

    <form method="POST" action="{{ route('verification.otp.verify') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="code" :value="otp.join('')">
        <div class="flex justify-center gap-3">
            <template x-for="(digit, index) in otp" :key="index">
                <input type="text" maxlength="1" x-model="otp[index]" @input="handleInput($event, index)" @keydown.backspace="handleBackspace($event, index)" @paste="handlePaste($event)"
                    class="w-12 h-14 text-center text-xl font-bold bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-2xl text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200" inputmode="numeric" pattern="[0-9]">
            </template>
        </div>
        <button type="submit" :disabled="otp.join('').length < 6" class="w-full py-3 px-4 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-semibold rounded-2xl shadow-lg shadow-amber-500/25 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">Verifikasi</button>
    </form>

    <div class="mt-6" x-data="countdown({{ $cooldown }})">
        <form method="POST" action="{{ route('verification.otp.resend') }}">
            @csrf
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Belum menerima kode?</p>
            <button type="submit" :disabled="remaining > 0" class="text-sm text-amber-600 hover:text-amber-700 font-semibold disabled:text-gray-400 disabled:cursor-not-allowed">
                <span x-show="remaining > 0">Kirim ulang dalam <span x-text="remaining"></span> detik</span>
                <span x-show="remaining <= 0">Kirim Ulang Kode</span>
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
function otpForm() {
    return {
        otp: ['', '', '', '', '', ''],
        handleInput(event, index) {
            const value = event.target.value;
            if (!/^\d$/.test(value)) { this.otp[index] = ''; return; }
            if (index < 5) this.$nextTick(() => { const next = this.$el.querySelectorAll('input[type="text"]')[index + 1]; if (next) next.focus(); });
        },
        handleBackspace(event, index) { if (!this.otp[index] && index > 0) { const prev = this.$el.querySelectorAll('input[type="text"]')[index - 1]; if (prev) prev.focus(); } },
        handlePaste(event) { const paste = event.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6); for (let i = 0; i < paste.length; i++) this.otp[i] = paste[i]; event.preventDefault(); }
    };
}
function countdown(seconds) {
    return { remaining: seconds, init() { if (this.remaining > 0) { const iv = setInterval(() => { this.remaining--; if (this.remaining <= 0) clearInterval(iv); }, 1000); } } };
}
</script>
@endpush
@endsection
