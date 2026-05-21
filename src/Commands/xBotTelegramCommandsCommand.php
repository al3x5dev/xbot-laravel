<?php

namespace Al3x5\xBotLaravel\Commands;

use Illuminate\Console\Command;

class xBotTelegramCommandsCommand extends Command
{
    protected $signature = 'xbot:telegram:command {name?}';
    protected $description = 'Create a new Telegram command';

    public function handle()
    {
        $args = ['telegram:command'];
        $name = $this->argument('name');

        if ($name) {
            $args[] = $name;
        }

        return $this->call('xbot', $args);
    }
}
