<?php

namespace Tests\Feature;

use App\Jobs\SendPaymentInvoiceJob;
use App\Mail\PaymentInvoiceMail;
use App\Models\Package;
use App\Models\Payment;
use App\Models\User;
use App\Models\Invitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PaymentInvoiceEmailTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Package $package;
    protected Payment $payment;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->package = Package::factory()->create([
            'name' => 'Premium Package',
            'price' => 149000,
            'duration_days' => 30,
            'features' => json_encode([
                'Unlimited guests',
                'RSVP tracking',
                'Custom music',
                'Digital envelope',
            ]),
        ]);

        $this->payment = Payment::factory()->create([
            'user_id' => $this->user->id,
            'package_id' => $this->package->id,
            'order_id' => 'TEST-ORDER-' . time(),
            'transaction_id' => 'TEST-TRX-' . time(),
            'amount' => 149000,
            'discount_amount' => 0,
            'total_amount' => 149000,
            'status' => 'paid',
            'payment_type' => 'bank_transfer',
            'paid_at' => now(),
        ]);
    }

    /** @test */
    public function it_can_send_payment_invoice_email()
    {
        Mail::fake();

        Mail::to($this->user->email)
            ->send(new PaymentInvoiceMail($this->payment));

        Mail::assertSent(PaymentInvoiceMail::class, function ($mail) {
            return $mail->payment->id === $this->payment->id;
        });
    }

    /** @test */
    public function it_dispatches_job_when_payment_is_successful()
    {
        Queue::fake();

        SendPaymentInvoiceJob::dispatch($this->payment);

        Queue::assertPushed(SendPaymentInvoiceJob::class, function ($job) {
            return $job->payment->id === $this->payment->id;
        });
    }

    /** @test */
    public function invoice_email_contains_correct_data()
    {
        Mail::fake();

        Mail::to($this->user->email)
            ->send(new PaymentInvoiceMail($this->payment));

        Mail::assertSent(PaymentInvoiceMail::class, function ($mail) {
            $mail->build();
            
            return $mail->hasTo($this->user->email)
                && $mail->subject === 'Invoice Pembayaran #' . $this->payment->order_id . ' - ' . config('app.name');
        });
    }

    /** @test */
    public function job_can_be_executed_successfully()
    {
        Mail::fake();

        $job = new SendPaymentInvoiceJob($this->payment);
        $job->handle();

        Mail::assertSent(PaymentInvoiceMail::class);
    }

    /** @test */
    public function invoice_email_includes_package_features()
    {
        $mailable = new PaymentInvoiceMail($this->payment);
        $rendered = $mailable->render();

        $features = json_decode($this->package->features, true);
        
        foreach ($features as $feature) {
            $this->assertStringContainsString($feature, $rendered);
        }
    }

    /** @test */
    public function invoice_email_shows_correct_price_breakdown()
    {
        $mailable = new PaymentInvoiceMail($this->payment);
        $rendered = $mailable->render();

        $this->assertStringContainsString(
            'Rp ' . number_format($this->payment->amount, 0, ',', '.'),
            $rendered
        );

        $this->assertStringContainsString(
            'Rp ' . number_format($this->payment->total_amount, 0, ',', '.'),
            $rendered
        );
    }

    /** @test */
    public function invoice_email_with_discount_shows_discount_amount()
    {
        $this->payment->update([
            'amount' => 149000,
            'discount_amount' => 50000,
            'total_amount' => 99000,
        ]);

        $mailable = new PaymentInvoiceMail($this->payment);
        $rendered = $mailable->render();

        $this->assertStringContainsString(
            'Rp ' . number_format($this->payment->discount_amount, 0, ',', '.'),
            $rendered
        );

        $this->assertStringContainsString('Diskon', $rendered);
    }

    /** @test */
    public function invoice_email_shows_payment_details()
    {
        $mailable = new PaymentInvoiceMail($this->payment);
        $rendered = $mailable->render();

        $this->assertStringContainsString($this->payment->order_id, $rendered);
        $this->assertStringContainsString($this->payment->transaction_id, $rendered);
        $this->assertStringContainsString(
            ucwords(str_replace('_', ' ', $this->payment->payment_type)),
            $rendered
        );
    }

    /** @test */
    public function invoice_email_shows_customer_info()
    {
        $mailable = new PaymentInvoiceMail($this->payment);
        $rendered = $mailable->render();

        $this->assertStringContainsString($this->user->name, $rendered);
        $this->assertStringContainsString($this->user->email, $rendered);
    }

    /** @test */
    public function invoice_email_with_invitation_shows_invitation_title()
    {
        $invitation = Invitation::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Pernikahan John & Jane',
        ]);

        $this->payment->update(['invitation_id' => $invitation->id]);

        $mailable = new PaymentInvoiceMail($this->payment);
        $rendered = $mailable->render();

        $this->assertStringContainsString($invitation->title, $rendered);
    }
}
