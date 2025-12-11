<?php

namespace Al3x5\xBotLaravel\Commands;

use Illuminate\Console\Command;

class xBotRegisterCommand extends Command
{
    protected $signature = 'xbot:register';
    protected $description = 'Register commands and callbacks for your bot';

    public function handle()
    {
        return $this->call('xbot', ['register']);
    }
}
