<?php

namespace Al3x5\xBotLaravel\Commands;

use Illuminate\Console\Command;

class xBotHookDeleteCommand extends Command
{
    protected $signature = 'xbot:delete';
    protected $description = 'Delete the webhook for the Telegram bot';

    public function handle()
    {
        return $this->call('xbot', ['delete']);
    }
}
