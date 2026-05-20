@extends('layouts.app')
@section('title', 'Syarat & Ketentuan - UndanganDigital')

@section('body')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <nav class="bg-white dark:bg-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">UndanganDigital</span>
                </a>
                <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-300 hover:text-amber-600 transition-colors">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>



    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 md:p-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">Syarat & Ketentuan</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8">Terakhir diperbarui: {{ date('d F Y') }}</p>

            <div class="prose prose-gray dark:prose-invert max-w-none">
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Selamat datang di UndanganDigital. Dengan mengakses atau menggunakan layanan kami, Anda menyetujui 
                    untuk terikat dengan Syarat & Ketentuan ini. Harap baca dengan seksama sebelum menggunakan layanan kami.
                </p>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">1. Definisi</h2>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li><strong>"Layanan"</strong> mengacu pada platform undangan digital UndanganDigital.</li>
                    <li><strong>"Pengguna"</strong> adalah individu yang mendaftar dan menggunakan layanan kami.</li>
                    <li><strong>"Konten"</strong> mencakup teks, gambar, musik, dan media lain yang diunggah pengguna.</li>
                    <li><strong>"Undangan"</strong> adalah produk digital yang dibuat menggunakan layanan kami.</li>
                </ul>



                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">2. Pendaftaran Akun</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">Untuk menggunakan layanan kami, Anda harus:</p>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li>Berusia minimal 18 tahun atau memiliki persetujuan orang tua/wali.</li>
                    <li>Memberikan informasi yang akurat dan lengkap saat pendaftaran.</li>
                    <li>Menjaga kerahasiaan kata sandi akun Anda.</li>
                    <li>Bertanggung jawab atas semua aktivitas yang terjadi di akun Anda.</li>
                    <li>Segera memberitahu kami jika terjadi penggunaan tidak sah pada akun Anda.</li>
                </ul>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">3. Layanan dan Paket</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">UndanganDigital menyediakan berbagai paket layanan:</p>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li><strong>Paket Gratis:</strong> Fitur dasar dengan batasan tertentu.</li>
                    <li><strong>Paket Berbayar:</strong> Fitur premium dengan berbagai tingkatan sesuai kebutuhan.</li>
                    <li>Masa berlaku paket sesuai dengan ketentuan masing-masing paket yang dipilih.</li>
                    <li>Fitur yang tersedia dapat berubah sewaktu-waktu dengan pemberitahuan sebelumnya.</li>
                </ul>



                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">4. Pembayaran dan Pengembalian Dana</h2>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li>Semua pembayaran diproses melalui payment gateway yang aman (Midtrans).</li>
                    <li>Harga yang tercantum sudah termasuk pajak yang berlaku.</li>
                    <li>Pembayaran bersifat non-refundable setelah transaksi berhasil, kecuali dalam kondisi tertentu yang disetujui.</li>
                    <li>Pengembalian dana dapat dipertimbangkan jika layanan tidak dapat diakses karena kesalahan sistem kami selama lebih dari 7 hari berturut-turut.</li>
                    <li>Permintaan pengembalian dana harus diajukan dalam waktu 7 hari setelah pembayaran.</li>
                </ul>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">5. Konten Pengguna</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">Anda bertanggung jawab penuh atas konten yang Anda unggah. Anda menjamin bahwa:</p>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li>Anda memiliki hak untuk menggunakan semua konten yang diunggah.</li>
                    <li>Konten tidak melanggar hak cipta, merek dagang, atau hak kekayaan intelektual pihak lain.</li>
                    <li>Konten tidak mengandung materi yang melanggar hukum, menyinggung, atau tidak pantas.</li>
                    <li>Foto dan gambar yang digunakan adalah milik Anda atau Anda memiliki izin untuk menggunakannya.</li>
                </ul>



                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">6. Penggunaan yang Dilarang</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">Anda dilarang menggunakan layanan kami untuk:</p>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li>Tujuan ilegal atau tidak sah.</li>
                    <li>Mengunggah konten yang mengandung virus, malware, atau kode berbahaya.</li>
                    <li>Melakukan spam atau mengirim pesan massal tanpa izin.</li>
                    <li>Mencoba mengakses akun pengguna lain tanpa izin.</li>
                    <li>Mengganggu atau merusak infrastruktur layanan kami.</li>
                    <li>Membuat undangan palsu atau penipuan.</li>
                    <li>Melanggar hak privasi orang lain.</li>
                </ul>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">7. Hak Kekayaan Intelektual</h2>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li>Semua hak atas platform, desain, dan template UndanganDigital adalah milik kami.</li>
                    <li>Anda diberikan lisensi terbatas untuk menggunakan template sesuai dengan paket yang dipilih.</li>
                    <li>Anda tidak boleh menyalin, memodifikasi, atau mendistribusikan template kami untuk tujuan komersial.</li>
                    <li>Konten yang Anda buat tetap menjadi milik Anda.</li>
                </ul>



                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">8. Ketersediaan Layanan</h2>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li>Kami berupaya menjaga ketersediaan layanan 24/7, namun tidak menjamin akses tanpa gangguan.</li>
                    <li>Pemeliharaan terjadwal akan diberitahukan sebelumnya bila memungkinkan.</li>
                    <li>Kami tidak bertanggung jawab atas kerugian akibat gangguan layanan yang di luar kendali kami.</li>
                </ul>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">9. Batasan Tanggung Jawab</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">Dalam batas yang diizinkan hukum:</p>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li>Layanan disediakan "sebagaimana adanya" tanpa jaminan tersurat atau tersirat.</li>
                    <li>Kami tidak bertanggung jawab atas kerugian tidak langsung, insidental, atau konsekuensial.</li>
                    <li>Total tanggung jawab kami terbatas pada jumlah yang Anda bayarkan untuk layanan dalam 12 bulan terakhir.</li>
                    <li>Kami tidak bertanggung jawab atas konten yang diunggah oleh pengguna.</li>
                </ul>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">10. Penghentian Layanan</h2>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li>Anda dapat menghentikan penggunaan layanan kapan saja dengan menghapus akun Anda.</li>
                    <li>Kami berhak menangguhkan atau menghentikan akun yang melanggar Syarat & Ketentuan ini.</li>
                    <li>Setelah penghentian, akses ke konten dan undangan Anda akan dihentikan.</li>
                    <li>Ketentuan yang secara wajar harus tetap berlaku akan terus berlaku setelah penghentian.</li>
                </ul>



                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">11. Perubahan Syarat & Ketentuan</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Kami berhak mengubah Syarat & Ketentuan ini kapan saja. Perubahan material akan diberitahukan 
                    melalui email atau pemberitahuan di platform. Penggunaan berkelanjutan setelah perubahan 
                    dianggap sebagai penerimaan terhadap syarat yang diperbarui.
                </p>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">12. Hukum yang Berlaku</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Syarat & Ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum Republik Indonesia. 
                    Setiap sengketa yang timbul akan diselesaikan melalui musyawarah terlebih dahulu, dan jika 
                    tidak tercapai kesepakatan, akan diselesaikan di pengadilan yang berwenang di Indonesia.
                </p>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">13. Hubungi Kami</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Jika Anda memiliki pertanyaan tentang Syarat & Ketentuan ini, silakan hubungi kami:
                </p>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 mt-4">
                    <p class="text-gray-700 dark:text-gray-300"><strong>Email:</strong> support@undangandigital.com</p>
                    <p class="text-gray-700 dark:text-gray-300 mt-2"><strong>Alamat:</strong> Indonesia</p>
                </div>
            </div>
        </div>
    </div>



    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    &copy; {{ date('Y') }} UndanganDigital. All rights reserved.
                </p>
                <div class="flex items-center gap-6 text-sm">
                    <a href="{{ route('privacy') }}" class="text-gray-500 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Kebijakan Privasi</a>
                    <a href="{{ route('terms') }}" class="text-amber-600 dark:text-amber-400 font-medium">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection
