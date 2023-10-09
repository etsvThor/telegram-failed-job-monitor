<?php

namespace EtsvThor\TelegramFailedJobMonitor;

use Illuminate\Support\ServiceProvider;

class TelegramFailedJobMonitorServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->bootConfig();
    }

    protected function bootConfig(): void
    {
        // Merge configs
        $this->mergeConfigFrom(__DIR__.'/../config/failed-job-monitor.php', 'failed-job-monitor');
    }

    /**
     * Console-specific booting.
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/failed-job-monitor.php' => config_path('failed-job-monitor.php'),
        ], 'telegram-failed-job-monitor');
    }
}
