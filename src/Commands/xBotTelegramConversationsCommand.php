<?php

namespace Al3x5\XBotLaravel\Commands;

use Illuminate\Console\Command;

class xBotTelegramConversationsCommand extends Command
{
    protected $signature = 'xbot:telegram:conversation';
    protected $description = 'Create a new conversational flow in your bot';

    public function handle()
    {
        return $this->call('xbot', ['telegram:conversation']);
    }
}
