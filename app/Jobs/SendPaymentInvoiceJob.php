<?php

namespace App\Jobs;

use App\Mail\PaymentInvoiceMail;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPaymentInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Payment $payment
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Load relationships yang diperlukan
            $this->payment->load(['user', 'package', 'invitation']);

            // Kirim email invoice
            Mail::to($this->payment->user->email)
                ->send(new PaymentInvoiceMail($this->payment));

            Log::info('Payment invoice email sent', [
                'order_id' => $this->payment->order_id,
                'user_email' => $this->payment->user->email,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send payment invoice email', [
                'order_id' => $this->payment->order_id,
                'user_email' => $this->payment->user->email ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Re-throw exception untuk retry
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::critical('Payment invoice email job failed after all retries', [
            'order_id' => $this->payment->order_id,
            'user_email' => $this->payment->user->email ?? 'unknown',
            'error' => $exception->getMessage(),
        ]);

        // TODO: Notify admin tentang gagalnya pengiriman invoice
        // Bisa menggunakan Slack notification atau email ke admin
    }
}
