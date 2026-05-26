<?php

namespace Al3x5\xBotLaravel\Commands;

use Al3x5\xBot\Bot;
use Illuminate\Console\Command;

class xBotHookInfoCommand extends Command
{
    protected $signature = 'xbot:hook:info';
    protected $description = "Gets information about the Telegram bot's webhook";

    public function handle()
    {
        $config = config('xbot');

        if (empty($config['token'])) {
            $this->error('❌ Bot token is not configured');
            return 1;
        }

        try {
            $bot = new Bot($config);
            $data = $bot->getWebhookInfo();

            foreach ($data->getProperties() as $key => $value) {
                $this->line("<fg=green>$key:</> <fg=white>$value</>");
            }

            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }
}
