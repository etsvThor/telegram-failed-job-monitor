# Failed job monitor with Telegram notifications and rate-limiter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/etsvthor/telegram-failed-job-monitor.svg?style=flat-square)](https://packagist.org/packages/etsvthor/telegram-failed-job-monitor)

Extension to [spatie/laravel-failed-job-monitor](/https://github.com/spatie/laravel-failed-job-monitor) to add support for Telegram notifications and add a rate-limiter to not
get spammed in case certain jobs run regularly.

See [spatie/laravel-failed-job-monitor](/https://github.com/spatie/laravel-failed-job-monitor) and [laravel-notification-channels/telegram](\https://github.com/laravel-notification-channels/telegram/tree/master/src) for more information.

## Installation

You can install the package via composer:

```bash
composer require etsvthor/telegram-failed-job-monitor
```

You must publish the config file:

```bash
php artisan vendor:publish --tag=telegram-failed-job-monitor-config
```

This is the contents of the published config file. By default, the `notificationFilter` is used to create to rate-limit:

```php
return [

    /*
     * The notification that will be sent when a job fails.
     */
    'notification' => EtsvThor\TelegramFailedJobMonitor\Notification::class,

    /*
     * The notifiable to which the notification will be sent. The default
     * notifiable will use the mail and slack configuration specified
     * in this config file.
     */
    'notifiable' => EtsvThor\TelegramFailedJobMonitor\Notifiable::class,

    /*
     * By default notifications are sent for all failures. You can pass a callable to filter
     * out certain notifications. The given callable will receive the notification. If the callable
     * return false, the notification will not be sent.
     */
    'notificationFilter' => [EtsvThor\TelegramFailedJobMonitor\Notification::class, 'notificationFilter'],

    /*
     * The channels to which the notification will be sent.
     */
    'channels' => ['telegram'],

    /**
     * How many seconds each failed job will trigger a notification. By default, it does not rate-limit.
     */
    'default-rate-limit' => env('FAILED_JOB_DEFAULT_RATELIMIT'),

    /**
     * How many seconds at minimum between notifications for this job. If nothing is specified, the default-rate-limit
     * will be used.
     */
    'rate-limit' => [
        // App\Jobs\MyJob:class => '3600',
    ],

    'mail' => [
        'to' => ['email@example.com'],
    ],

    'slack' => [
        'webhook_url' => env('FAILED_JOB_SLACK_WEBHOOK_URL'),
    ],
];
```

### Telegram bot
Talk to @BotFather and generate a Bot API Token.

Then add your newly created bot to the Telegram chat where you want notifications to be send.

Get your `chat_id` by running `curl https://api.telegram.org/bot<your_token>/getUpdates` and retrieving the `chat_id`
from the output.

Then, configure your Telegram Bot API Token:

```php
# config/services.php

'telegram-bot-api' => [
    'token' => env('TELEGRAM_BOT_TOKEN'),
    'chat_id' => env('TELEGRAM_CHAT_ID'),
],
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
