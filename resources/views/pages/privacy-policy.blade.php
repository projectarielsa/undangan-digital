@extends('layouts.app')
@section('title', 'Kebijakan Privasi - UndanganDigital')

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
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">Kebijakan Privasi</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8">Terakhir diperbarui: {{ date('d F Y') }}</p>

            <div class="prose prose-gray dark:prose-invert max-w-none">
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Selamat datang di UndanganDigital. Kami berkomitmen untuk melindungi privasi dan keamanan data pribadi Anda. 
                    Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi Anda 
                    ketika menggunakan layanan kami.
                </p>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">1. Informasi yang Kami Kumpulkan</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">Kami mengumpulkan beberapa jenis informasi untuk menyediakan dan meningkatkan layanan kami:</p>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li><strong>Informasi Akun:</strong> Nama, alamat email, nomor telepon, dan kata sandi saat Anda mendaftar.</li>
                    <li><strong>Informasi Undangan:</strong> Data yang Anda masukkan dalam undangan seperti nama pasangan, tanggal acara, lokasi, foto, dan informasi tamu.</li>
                    <li><strong>Informasi Pembayaran:</strong> Data transaksi yang diproses melalui penyedia layanan pembayaran pihak ketiga (Midtrans).</li>
                    <li><strong>Data Penggunaan:</strong> Informasi tentang bagaimana Anda mengakses dan menggunakan layanan kami, termasuk alamat IP, jenis browser, dan halaman yang dikunjungi.</li>
                    <li><strong>Cookie:</strong> Data yang disimpan di perangkat Anda untuk meningkatkan pengalaman pengguna.</li>
                </ul>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">2. Penggunaan Informasi</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">Informasi yang kami kumpulkan digunakan untuk:</p>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li>Menyediakan, mengoperasikan, dan memelihara layanan undangan digital</li>
                    <li>Memproses transaksi dan mengirimkan konfirmasi pembayaran</li>
                    <li>Mengirimkan pemberitahuan terkait akun dan layanan</li>
                    <li>Menanggapi pertanyaan dan permintaan dukungan pelanggan</li>
                    <li>Menganalisis penggunaan layanan untuk peningkatan kualitas</li>
                    <li>Mendeteksi dan mencegah aktivitas penipuan atau penyalahgunaan</li>
                    <li>Mematuhi kewajiban hukum yang berlaku</li>
                </ul>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">3. Pembagian Informasi</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">Kami tidak menjual data pribadi Anda. Kami hanya membagikan informasi dalam situasi berikut:</p>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li><strong>Penyedia Layanan:</strong> Dengan mitra yang membantu mengoperasikan layanan kami (seperti penyedia hosting dan payment gateway).</li>
                    <li><strong>Tamu Undangan:</strong> Informasi undangan Anda akan ditampilkan kepada tamu yang mengakses link undangan.</li>
                    <li><strong>Kewajiban Hukum:</strong> Jika diwajibkan oleh hukum atau untuk melindungi hak dan keamanan.</li>
                    <li><strong>Dengan Persetujuan:</strong> Dengan persetujuan eksplisit dari Anda untuk tujuan tertentu.</li>
                </ul>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">4. Keamanan Data</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai untuk melindungi data pribadi Anda, termasuk:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300 mt-4">
                    <li>Enkripsi SSL/TLS untuk transmisi data</li>
                    <li>Penyimpanan kata sandi dengan enkripsi hash</li>
                    <li>Akses terbatas ke data pribadi hanya untuk karyawan yang membutuhkan</li>
                    <li>Monitoring dan audit keamanan berkala</li>
                </ul>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">5. Penyimpanan Data</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Kami menyimpan data pribadi Anda selama diperlukan untuk menyediakan layanan dan memenuhi kewajiban hukum. 
                    Data undangan akan disimpan selama akun Anda aktif atau sesuai dengan paket langganan yang dipilih. 
                    Setelah akun dihapus, data akan dihapus dalam waktu 30 hari, kecuali ada kewajiban hukum untuk menyimpannya lebih lama.
                </p>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">6. Hak Pengguna</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">Anda memiliki hak untuk:</p>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                    <li><strong>Mengakses:</strong> Meminta salinan data pribadi yang kami miliki tentang Anda.</li>
                    <li><strong>Memperbaiki:</strong> Memperbarui atau memperbaiki informasi yang tidak akurat.</li>
                    <li><strong>Menghapus:</strong> Meminta penghapusan data pribadi Anda.</li>
                    <li><strong>Membatasi:</strong> Meminta pembatasan pemrosesan data Anda.</li>
                    <li><strong>Portabilitas:</strong> Menerima data Anda dalam format yang dapat dibaca mesin.</li>
                    <li><strong>Keberatan:</strong> Menolak pemrosesan data untuk tujuan tertentu.</li>
                </ul>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">7. Cookie dan Teknologi Pelacakan</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Kami menggunakan cookie dan teknologi serupa untuk meningkatkan pengalaman pengguna, menganalisis lalu lintas, 
                    dan mempersonalisasi konten. Anda dapat mengatur browser untuk menolak cookie, namun beberapa fitur mungkin tidak berfungsi dengan baik.
                </p>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">8. Layanan Pihak Ketiga</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Layanan kami terintegrasi dengan pihak ketiga seperti:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300 mt-4">
                    <li><strong>Google OAuth:</strong> Untuk opsi login dengan akun Google.</li>
                    <li><strong>Midtrans:</strong> Untuk pemrosesan pembayaran yang aman.</li>
                </ul>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mt-4">
                    Layanan pihak ketiga ini memiliki kebijakan privasi mereka sendiri yang mengatur penggunaan data Anda.
                </p>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">9. Perlindungan Anak</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Layanan kami tidak ditujukan untuk anak di bawah 18 tahun. Kami tidak secara sengaja mengumpulkan 
                    data pribadi dari anak-anak. Jika Anda mengetahui bahwa anak Anda telah memberikan data kepada kami, 
                    silakan hubungi kami untuk penghapusan.
                </p>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">10. Perubahan Kebijakan</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan signifikan akan 
                    diberitahukan melalui email atau pemberitahuan di layanan kami. Penggunaan berkelanjutan setelah 
                    perubahan dianggap sebagai penerimaan terhadap kebijakan yang diperbarui.
                </p>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">11. Hubungi Kami</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini atau ingin menggunakan hak-hak Anda, 
                    silakan hubungi kami melalui:
                </p>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 mt-4">
                    <p class="text-gray-700 dark:text-gray-300"><strong>Email:</strong> privacy@undangandigital.com</p>
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
                    <a href="{{ route('privacy') }}" class="text-amber-600 dark:text-amber-400 font-medium">Kebijakan Privasi</a>
                    <a href="{{ route('terms') }}" class="text-gray-500 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection
