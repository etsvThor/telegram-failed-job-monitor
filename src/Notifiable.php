<?php

namespace EtsvThor\TelegramFailedJobMonitor;

use Spatie\FailedJobMonitor\Notifiable as SpatieNotifiable;

class Notifiable extends SpatieNotifiable
{
    /**
     * Route notifications for the Telegram channel.
     */
    public function routeNotificationForTelegram(): ?int
    {
        return config('services.telegram-bot-api.chat_id');
    }
}
