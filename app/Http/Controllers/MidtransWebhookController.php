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
            $payment = $this->midtrans->handleNotification($n);
            if ($payment->isPaid()) $this->subs->activateFromPayment($payment);
            return response()->json(["status"=>"success"]);
        } catch (\Exception $e) { Log::error("Midtrans webhook: " . $e->getMessage()); return response()->json(["status"=>"error"], 500); }
    }
}