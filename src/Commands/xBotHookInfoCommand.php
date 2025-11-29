<?php

namespace Al3x5\xBotLaravel\Commands;

use Illuminate\Console\Command;

class xBotHookInfoCommand extends Command
{
    protected $signature = 'xbot:hook:info';
    protected $description = "Gets information about the Telegram bot's webhook";

    public function handle()
    {
        return $this->call('xbot', ['hook:info']);
    }
}
