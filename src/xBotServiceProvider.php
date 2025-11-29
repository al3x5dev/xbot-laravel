<?php

namespace Al3x5\xBotLaravel;

use Al3x5\xBotLaravel\Commands\xBotCommand;
use Al3x5\xBotLaravel\Commands\xBotHookAboutCommand;
use Al3x5\xBotLaravel\Commands\xBotHookDeleteCommand;
use Al3x5\xBotLaravel\Commands\xBotHookInfoCommand;
use Al3x5\xBotLaravel\Commands\xBotHookSetCommand;
use Al3x5\xBotLaravel\Commands\xBotRegisterCommand;
use Al3x5\XBotLaravel\Commands\xBotTelegramCallbacksCommand;
use Al3x5\XBotLaravel\Commands\xBotTelegramCommandsCommand;
use Al3x5\XBotLaravel\Commands\xBotTelegramConversationsCommand;
use Al3x5\XBotLaravel\Commands\xBotTelegramHandlerCommand;
use Illuminate\Support\ServiceProvider;

class xBotServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publicar configuración
        $this->publishes([
            __DIR__ . '/../config/xbot.php' => config_path('xbot.php'),
        ], 'xbot-config');

        // Registrar comandos de Artisan
        $this->commands([
            xBotCommand::class,
            xBotHookAboutCommand::class,
            xBotHookDeleteCommand::class,
            xBotHookInfoCommand::class,
            xBotHookSetCommand::class,
            xBotRegisterCommand::class,
            xBotTelegramCallbacksCommand::class,
            xBotTelegramConversationsCommand::class,
            xBotTelegramHandlerCommand::class,
            xBotTelegramCommandsCommand::class
        ]);
    }

    public function register()
    {
        // Fusionar configuración
        $this->mergeConfigFrom(__DIR__ . '/../config/xbot.php', 'xbot');

        // Registrar tu cache PSR-16
        /*$this->app->bind('xbot.psr16.cache', function($app) {
            return new \Al3x5\LaravelPsr16Cache\LaravelCache($app['cache']);
        });*/
    }
}
