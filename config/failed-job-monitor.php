<?php

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
    'default-rate-limit' => env('FAILED_JOB_DEFAULT_RATE-LIMIT'),

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
