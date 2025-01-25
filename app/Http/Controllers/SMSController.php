<?php

namespace App\Http\Controllers;

require_once app_path('Http/lib/send_sms_impl.php');

class SMSController extends Controller
{
    private $sendSmsImpl;
    private $tokenBody;

    public function __construct()
    {
        $this->sendSmsImpl = new \SendSMSImpl();
        $this->tokenBody = new \TokenBody();
    }

    private function getAccessToken()
    {
        $this->tokenBody->setUsername("deelz");
        $this->tokenBody->setPassword("Deelz@007");

        $tokenResponse = $this->sendSmsImpl->getToken($this->tokenBody);
        return $tokenResponse->getToken();
    }

    public function sendSms(array $phoneNumbers, string $message)
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return response()->json(['error' => 'Failed to obtain access token'], 500);
        }

        $sendTextBody = new \SendTextBody();
        $sendTextBody->setSourceAddress(env('TEST'));
        $sendTextBody->setMessage($message);

        // Generate a numeric-only transaction ID
        $transactionId = time() . rand(1000, 9999);
        $sendTextBody->setTransactionId($transactionId);

        $sendTextBody->setMsisdn($this->sendSmsImpl->setMsisdns($phoneNumbers));

        $response = $this->sendSmsImpl->sendText($sendTextBody, $token);

        return response()->json([
            'comment' => $response->getComment(),
            'status' => $response->getStatus(),
        ]);
    }

}
