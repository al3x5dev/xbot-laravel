<?php

namespace Al3x5\xBotLaravel\Commands;

use Al3x5\xBot\Bot;
use Illuminate\Console\Command;

class xBotHookDeleteCommand extends Command
{
    protected $signature = 'xbot:hook:delete';
    protected $description = 'Delete the webhook for the Telegram bot';

    public function handle()
    {
        $config = config('xbot');

        if (!$this->confirm('Are you sure you want to delete the webhook?')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        try {
            if (empty($config['token'])) {
                $this->error('❌ Bot token is not configured');
                return 1;
            }

            $bot = new Bot($config);
            $data = $bot->deleteWebhook(drop_pending_updates: true);

                $this->info('✅ Webhook was deleted');
                return 0;
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }
}
