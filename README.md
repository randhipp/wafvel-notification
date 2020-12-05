# Whatsapp notifications channel for Laravel

This package makes it easy to send whatsapp using the Laravel notification system.

## Installation

You can install the package via composer:

``` bash
composer require randhipp/wafvel-notification
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use Wafvel\Notification\WafvelChannel;
use Wafvel\Notification\WafvelMessage;
use Illuminate\Notifications\Notification;

class ProjectCreated extends Notification
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return [WafvelChannel::class];
    }

    public function toWafvel($notifiable)
    {
        $message = $this->data ?? "Your Chat Message\nNew Line";

        return WafvelMessage::create()
            ->token('') // bot token, if not specified will using env value WAFVEL_BOT_TOKEN
            ->phone('628123456789') // format : 628123456789 => {countrycode:id}{phonenumber_without_leading_zero:08123456789}
            ->message($message);
    }
}
```

### Available methods

- `token('')`: Accepts a JSON-encodable value for the Webhook body.
- `phone('')`: Accepts an associative array of query string values to add to the request.
- `message('')`: Accepts a string value for the Webhook user agent.

## Security

If you discover any security related issues, please email randhi.pp@gmail.com instead of using the issue tracker.

## Credits

This Project based on Webhook Notification Channel by [Marcel Pociot](https://github.com/mpociot)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
