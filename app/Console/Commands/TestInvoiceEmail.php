<?php

namespace App\Console\Commands;

use App\Jobs\SendPaymentInvoiceJob;
use App\Mail\PaymentInvoiceMail;
use App\Models\Payment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestInvoiceEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:test 
                            {--order-id= : Order ID dari payment yang akan ditest}
                            {--email= : Email tujuan untuk testing (default: email dari payment)}
                            {--queue : Kirim via queue job}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test kirim invoice email untuk payment tertentu';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $orderId = $this->option('order-id');

        // Jika tidak ada order-id, ambil payment terakhir yang paid
        if (!$orderId) {
            $this->info('Order ID tidak diberikan. Mencari payment terakhir yang berhasil...');
            
            $payment = Payment::where('status', 'paid')
                ->with(['user', 'package', 'invitation'])
                ->latest()
                ->first();

            if (!$payment) {
                $this->error('❌ Tidak ada payment dengan status "paid" di database.');
                return self::FAILURE;
            }

            $this->info('✓ Ditemukan payment: ' . $payment->order_id);
        } else {
            $payment = Payment::where('order_id', $orderId)
                ->with(['user', 'package', 'invitation'])
                ->first();

            if (!$payment) {
                $this->error('❌ Payment dengan Order ID "' . $orderId . '" tidak ditemukan.');
                return self::FAILURE;
            }

            if (!$payment->isPaid()) {
                $this->warn('⚠️  Payment ini belum berstatus "paid" (status: ' . $payment->status . ')');
                
                if (!$this->confirm('Tetap lanjutkan kirim invoice?')) {
                    return self::SUCCESS;
                }
            }
        }

        // Tampilkan info payment
        $this->displayPaymentInfo($payment);

        // Konfirmasi
        if (!$this->confirm('Kirim invoice email untuk payment ini?', true)) {
            $this->info('Dibatalkan.');
            return self::SUCCESS;
        }

        // Tentukan email tujuan
        $email = $this->option('email') ?? $payment->user->email;

        // Kirim email
        try {
            if ($this->option('queue')) {
                $this->info('🚀 Mengirim invoice via queue...');
                SendPaymentInvoiceJob::dispatch($payment);
                $this->info('✓ Job berhasil di-dispatch ke queue.');
                $this->comment('Jalankan "php artisan queue:work" untuk memproses job.');
            } else {
                $this->info('📧 Mengirim invoice langsung ke: ' . $email);
                Mail::to($email)->send(new PaymentInvoiceMail($payment));
                $this->info('✓ Invoice berhasil dikirim!');
            }

            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Gagal mengirim invoice: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return self::FAILURE;
        }
    }

    /**
     * Display payment information
     */
    protected function displayPaymentInfo(Payment $payment): void
    {
        $this->line('');
        $this->line('<fg=cyan>═══════════════════════════════════════════════════════════</>');
        $this->line('<fg=cyan>                   PAYMENT INFORMATION</>');
        $this->line('<fg=cyan>═══════════════════════════════════════════════════════════</>');
        $this->line('');

        $this->table(
            ['Field', 'Value'],
            [
                ['Order ID', $payment->order_id],
                ['Transaction ID', $payment->transaction_id ?? '-'],
                ['Status', $payment->status],
                ['Customer', $payment->user->name . ' (' . $payment->user->email . ')'],
                ['Package', $payment->package->name],
                ['Amount', 'Rp ' . number_format($payment->amount, 0, ',', '.')],
                ['Discount', 'Rp ' . number_format($payment->discount_amount, 0, ',', '.')],
                ['Total', 'Rp ' . number_format($payment->total_amount, 0, ',', '.')],
                ['Payment Method', ucwords(str_replace('_', ' ', $payment->payment_type ?? 'N/A'))],
                ['Paid At', $payment->paid_at ? $payment->paid_at->format('d M Y, H:i') . ' WIB' : '-'],
                ['Invitation', $payment->invitation ? $payment->invitation->title : '-'],
            ]
        );

        $this->line('');
    }
}
