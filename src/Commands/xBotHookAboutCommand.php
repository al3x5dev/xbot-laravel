<?php

namespace Al3x5\xBotLaravel\Commands;

use Illuminate\Console\Command;

class xBotHookAboutCommand extends Command
{
    protected $signature = 'xbot:hook:about';
    protected $description = 'Gets information about the Telegram bot';

    public function handle()
    {
        return $this->call('xbot', ['hook:about']);
    }
}
