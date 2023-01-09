<?php

namespace EtsvThor\TelegramFailedJobMonitor;

use Illuminate\Support\Facades\RateLimiter;
use NotificationChannels\Telegram\TelegramMessage;
use Spatie\FailedJobMonitor\Notification as SpatieNotification;

class Notification extends SpatieNotification
{
    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return TelegramMessage
     */
    public function toTelegram(mixed $notifiable): TelegramMessage
    {
        return TelegramMessage::create()
            ->line('A job failed at '.config('app.name').' at '.config('app.url'))
            ->line("Job class: {$this->event->job->resolveName()}")
            ->line((config('horizon.domain') ?: config('app.url')).'/'.config('horizon.path').'/failed/'.
                $this->event->job->getJobId());
    }

    /**
     * Rate limits notifications for certain jobs
     * @param Notification $notification
     * @return bool
     */
    public static function notificationFilter(Notification $notification): bool
    {
        $jobClass = $notification->event->job->resolveName();

        foreach (config('failed-job-monitor.rate-limit') as $class => $time) {
            if ($jobClass == $class) {
                return RateLimiter::attempt($jobClass.'_rate-limit_notification', 1, function () {},
                    $time);
            }
        }

        if (! is_null($time = config('failed-job-monitor.default-rate-limit'))) {
            return RateLimiter::attempt($jobClass.'_rate-limit_notification', 1, function () {},
                $time);
        }

        return true;
    }
}
