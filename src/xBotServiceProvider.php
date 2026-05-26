<?php

namespace Al3x5\xBotLaravel;

use Al3x5\xBotLaravel\Commands\xBotCommand;
use Al3x5\xBotLaravel\Commands\xBotHookAboutCommand;
use Al3x5\xBotLaravel\Commands\xBotHookDeleteCommand;
use Al3x5\xBotLaravel\Commands\xBotHookInfoCommand;
use Al3x5\xBotLaravel\Commands\xBotHookSetCommand;
use Al3x5\xBotLaravel\Commands\xBotRegisterCommand;
use Al3x5\xBotLaravel\Commands\xBotTelegramCallbacksCommand;
use Al3x5\xBotLaravel\Commands\xBotTelegramCommandsCommand;
use Al3x5\xBotLaravel\Commands\xBotTelegramConversationsCommand;
use Al3x5\xBotLaravel\Commands\xBotTelegramHandlerCommand;
use Al3x5\xBotLaravel\Commands\xBotTelegramMiddlewareCommand;
use Al3x5\LaravelPsr16Cache;
use Al3x5\xBot\Bot;
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
            xBotTelegramMiddlewareCommand::class,
            xBotTelegramCommandsCommand::class
        ]);
    }

    public function register()
    {
        // Fusionar configuración
        $this->mergeConfigFrom(__DIR__ . '/../config/xbot.php', 'xbot');

        $this->app->singleton(Bot::class, function ($app) {
            $config = config('xbot');
            $config['cache'] = new LaravelPsr16Cache($app['cache']->store());
            return new Bot($config);
        });

        $this->app->alias(Bot::class, 'xbot');
    }
}
