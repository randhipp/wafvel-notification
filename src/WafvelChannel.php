<?php

namespace Wafvel\Notification;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Wafvel\Notification\Exceptions\CouldNotSendNotification;

class WafvelChannel
{
    /** @var Client */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Wafvel\Notification\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $url = $notifiable->routeNotificationFor('wafvel')) {
            $url = env('WAFVEL_API_URL', 'https://wafvel.com:2096/api/whatsapp/send');
        }

        $webhookData = $notification->toWafvel($notifiable)->toArray();

        $token = Arr::get($webhookData, 'token' , env('WAFVEL_BOT_TOKEN'));
        $phone = Arr::get($webhookData, 'phone');
        $message = Arr::get($webhookData, 'message');
                
        $response = $this->client->post($url, [
            'json' => [
                'token' => $token,
                'phone' => $phone,
                'message' => $message
            ],
        ]);

        if ($response->getStatusCode() >= 300 || $response->getStatusCode() < 200) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }

        return $response;
    }
}
