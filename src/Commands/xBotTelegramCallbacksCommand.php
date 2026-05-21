<?php

namespace Al3x5\xBotLaravel\Commands;

use Illuminate\Console\Command;

class xBotTelegramCallbacksCommand extends Command
{
    protected $signature = 'xbot:telegram:callback {name?}';
    protected $description = 'Create a new Telegram callback';

    public function handle()
    {
        $args = ['telegram:callback'];
        $name = $this->argument('name');

        if ($name) {
            $args[] = $name;
        }

        return $this->call('xbot', $args);
    }
}
