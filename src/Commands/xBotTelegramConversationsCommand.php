<?php

namespace Al3x5\xBotLaravel\Commands;

use Illuminate\Console\Command;

class xBotTelegramConversationsCommand extends Command
{
    protected $signature = 'xbot:telegram:conversation {name?}';
    protected $description = 'Create a new conversational flow in your bot';

    public function handle()
    {
        $args = ['telegram:conversation'];
        $name = $this->argument('name');

        if ($name) {
            $args[] = $name;
        }

        return $this->call('xbot', $args);
    }
}
