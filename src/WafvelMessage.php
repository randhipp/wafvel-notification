<?php

namespace Wafvel\Notification;

class WebhookMessage
{
    protected $token;
    protected $message;
    protected $phone;

    public function __construct($token, $message, $phone)
    {
        $this->token = $token;
        $this->message = $message;
        $this->phone = $phone;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'token' => $this->token,
            'phone' => $this->phone,
            'message' => $this->message,
        ];
    }
}
