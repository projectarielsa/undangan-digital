<?php
namespace App\Http\Controllers;
use App\Services\MidtransService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function __construct(protected MidtransService $midtrans, protected SubscriptionService $subs) {}
    public function handle(Request $request)
    {
        try {
            $n = $request->all();

            // Verify Midtrans signature
            $serverKey = config('services.midtrans.server_key');
            $orderId = $n['order_id'] ?? '';
            $statusCode = $n['status_code'] ?? '';
            $grossAmount = $n['gross_amount'] ?? '';
            $signatureKey = $n['signature_key'] ?? '';

            $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

            if ($signatureKey !== $expectedSignature) {
                Log::warning("Midtrans webhook: Invalid signature for order {$orderId}");
                return response()->json(["status" => "error", "message" => "Invalid signature"], 403);
            }

            $payment = $this->midtrans->handleNotification($n);
            if ($payment->isPaid()) $this->subs->activateFromPayment($payment);
            return response()->json(["status"=>"success"]);
        } catch (\Exception $e) { Log::error("Midtrans webhook: " . $e->getMessage()); return response()->json(["status"=>"error"], 500); }
    }
}