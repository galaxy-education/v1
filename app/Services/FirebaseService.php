<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FirebaseService
{
    protected $serverKey;

    public function __construct()
    {
        $this->serverKey = config('fcm.server_key');
    }

    public function sendNotification($deviceToken, $title, $body, $data = [])
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $payload = [
            'to' => $deviceToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
            ],
            'data' => $data,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $this->serverKey,
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        return $response->json();
    }
}
