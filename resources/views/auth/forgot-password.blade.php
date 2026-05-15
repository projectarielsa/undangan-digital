@extends('layouts.auth', ['title' => 'Lupa Password'])

@section('content')
<div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Lupa Password?</h2>
    <p class="text-gray-500 dark:text-gray-400 mb-8">Masukkan email Anda untuk menerima link reset password.</p>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl"><p class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p></div>
    @endif
    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl"><p class="text-sm text-red-600 dark:text-red-400">{{ $errors->first() }}</p></div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-2xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all" placeholder="email@contoh.com">
        </div>
        <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-semibold rounded-2xl shadow-lg shadow-amber-500/25 transition-all duration-200 transform hover:scale-[1.02]">Kirim Link Reset</button>
    </form>
    <p class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400"><a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-700 font-semibold">&larr; Kembali ke login</a></p>
</div>
@endsection
