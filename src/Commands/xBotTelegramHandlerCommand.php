<?php

namespace Al3x5\xBotLaravel\Commands;

use Illuminate\Console\Command;

class xBotTelegramHandlerCommand extends Command
{
    protected $signature = 'xbot:telegram:handler {name?}';
    protected $description = 'Create a new Telegram handler';

    public function handle()
    {
        $args = ['telegram:handler'];
        $name = $this->argument('name');

        if ($name) {
            $args[] = $name;
        }

        return $this->call('xbot', $args);
    }
}
