<?php

namespace Al3x5\xBotLaravel\Commands;

use Illuminate\Console\Command;

class xBotHookSetCommand extends Command
{
    protected $signature = 'xbot:hook:set';
    protected $description = 'Set up the webhook for the Telegram bot from Laravel';

    public function handle()
    {
        return $this->call('xbot', ['hook:set', $this->argument('url')]);
    }
}
