<?php

namespace Al3x5\xBotLaravel\Commands;

use Al3x5\xBot\Bot;
use Illuminate\Console\Command;

class xBotHookAboutCommand extends Command
{
    protected $signature = 'xbot:hook:about';
    protected $description = 'Gets information about the Telegram bot';

    public function handle()
    {
        $config = config('xbot');

        if (empty($config['token'])) {
            $this->error('❌ Bot token is not configured');
            return 1;
        }

        try {
            $bot = new Bot($config);
            $data = $bot->getMe();

            if ($data['ok']) {
                foreach ($data['result'] as $key => $value) {
                    $this->line(`<fg=green>$key:</> <fg=white>$value</>`);
                }

                return 0;
            } else {
                $this->error('❌ Failed to get bot info: ' . $data['description']);
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }
}
