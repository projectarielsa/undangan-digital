@extends('layouts.auth', ['title' => 'Verifikasi OTP'])

@section('content')
<div class="text-center">
    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full mb-6">
        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </div>

    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Verifikasi Email</h2>
    <p class="text-gray-500 dark:text-gray-400 mb-2">Masukkan kode 6 digit yang dikirim ke</p>
    <p class="text-blue-600 dark:text-blue-400 font-medium mb-8">{{ $email }}</p>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl">
            <p class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl">
            <p class="text-sm text-red-600 dark:text-red-400">{{ $errors->first() }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('verification.otp.verify') }}" class="space-y-6" id="otpForm">
        @csrf

        <input type="hidden" name="code" id="otpCode">

        <div class="flex justify-center gap-3">
            @for ($i = 0; $i < 6; $i++)
                <input
                    type="text"
                    maxlength="1"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    autocomplete="one-time-code"
                    class="otp-input w-12 h-14 text-center text-xl font-bold bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-2xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                >
            @endfor
        </div>

        <button
            type="submit"
            id="verifyBtn"
            disabled
            class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-2xl shadow-lg shadow-blue-500/25 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
        >
            Verifikasi
        </button>
    </form>

    <div class="mt-6">
        <form method="POST" action="{{ route('verification.otp.resend') }}">
            @csrf

            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Belum menerima kode?</p>

            <button
                type="submit"
                id="resendBtn"
                class="text-sm text-blue-600 hover:text-blue-700 font-semibold disabled:text-gray-400 disabled:cursor-not-allowed"
                data-cooldown="{{ $cooldown }}"
            >
                <span id="cooldownText"></span>
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.otp-input');
    const codeInput = document.getElementById('otpCode');
    const verifyBtn = document.getElementById('verifyBtn');
    const form = document.getElementById('otpForm');

    function syncCode() {
        const code = Array.from(inputs).map(input => input.value).join('');
        codeInput.value = code;
        verifyBtn.disabled = code.length !== 6;
        return code;
    }

    inputs[0]?.focus();

    inputs.forEach((input, index) => {
        input.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '');

            if (value.length > 1) {
                value = value.slice(0, 6);

                value.split('').forEach((digit, i) => {
                    if (inputs[i]) inputs[i].value = digit;
                });

                const code = syncCode();

                if (code.length === 6) {
                    form.submit();
                }

                return;
            }

            this.value = value;
            syncCode();

            if (value && index < inputs.length - 1) {
                inputs[index + 1].focus();
                inputs[index + 1].select();
            }

            if (syncCode().length === 6) {
                form.submit();
            }
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace') {
                if (this.value) {
                    this.value = '';
                    syncCode();
                    return;
                }

                if (index > 0) {
                    inputs[index - 1].focus();
                    inputs[index - 1].value = '';
                    syncCode();
                }
            }

            if (e.key === 'ArrowLeft' && index > 0) {
                inputs[index - 1].focus();
            }

            if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        input.addEventListener('paste', function (e) {
            e.preventDefault();

            const paste = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);

            paste.split('').forEach((digit, i) => {
                if (inputs[i]) inputs[i].value = digit;
            });

            const code = syncCode();

            if (code.length === 6) {
                form.submit();
            }
        });
    });

    const resendBtn = document.getElementById('resendBtn');
    const cooldownText = document.getElementById('cooldownText');

    if (resendBtn && cooldownText) {
        let remaining = parseInt(resendBtn.dataset.cooldown || '0');

        function renderCooldown() {
            if (remaining > 0) {
                resendBtn.disabled = true;
                cooldownText.innerText = 'Kirim ulang dalam ' + remaining + ' detik';
            } else {
                resendBtn.disabled = false;
                cooldownText.innerText = 'Kirim Ulang Kode';
            }
        }

        renderCooldown();

        if (remaining > 0) {
            const interval = setInterval(function () {
                remaining--;
                renderCooldown();

                if (remaining <= 0) {
                    clearInterval(interval);
                }
            }, 1000);
        }
    }
});
</script>
@endsection