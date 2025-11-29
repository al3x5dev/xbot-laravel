<?php

namespace Al3x5\XBotLaravel\Commands;

use Illuminate\Console\Command;

class xBotTelegramCallbacksCommand extends Command
{
    protected $signature = 'xbot:telegram:callback';
    protected $description = 'Create a new Telegram callback';

    public function handle()
    {
        return $this->call('xbot', ['telegram:callback']);
    }
}
