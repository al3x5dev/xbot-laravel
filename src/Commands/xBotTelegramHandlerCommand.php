<?php

namespace Al3x5\XBotLaravel\Commands;

use Illuminate\Console\Command;

class xBotTelegramHandlerCommand extends Command
{
    protected $signature = 'xbot:telegram:handler';
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
