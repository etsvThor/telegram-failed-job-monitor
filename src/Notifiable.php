<?php

namespace EtsvThor\TelegramFailedJobMonitor;

use Spatie\FailedJobMonitor\Notifiable as SpatieNotifiable;

class Notifiable extends SpatieNotifiable
{
    /**
     * Route notifications for the Telegram channel.
     *
     * @return int|array
     */
    public function routeNotificationForTelegram(): int|array
    {
        return config('services.telegram-bot-api.chat_id') ?: [];
    }
}
