<?php

namespace Al3x5\xBotLaravel\Commands;

use Al3x5\xBot\Commands\Traits\MakeClass;
use Illuminate\Console\Command;

class xBotTelegramMiddlewareCommand extends Command
{
    use MakeClass;

    protected $signature = 'xbot:telegram:middleware {name?}';
    protected $description = 'Create a new middleware';

    public function handle(): int
    {
        $name = $this->argument('name');
        if (empty($name)) {
            $name = $this->ask('Middleware name (e.g. auth or auth/user)');
            if (empty($name)) {
                $this->error('Name cannot be empty.');
                return 1;
            }
        }

        if (!str_ends_with($name, 'Middleware')) {
            $name .= '-middleware';
        }

        $data = $this->makeDir($name, 'bot/Middlewares', $this->output);
        if (empty($data)) {
            return 1;
        }

        $this->makeTelegramMiddleware($data);
        $this->info("Middleware [{$data['filename']}] created successfully.");

        return 0;
    }
}
