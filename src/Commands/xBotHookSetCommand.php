<?php

namespace Al3x5\xBotLaravel\Commands;

use Al3x5\xBot\Bot;
use Illuminate\Console\Command;

class xBotHookSetCommand extends Command
{
    protected $signature = 'xbot:hook:set {url?}';
    protected $description = 'Set up the webhook for the Telegram bot from Laravel';

    public function handle()
    {
        $url = $this->argument('url');
        $config = config('xbot');

        if (empty($url)) {
            $url = $this->ask('What is the URL for sending updates?');
        }

        // Validar URL
        if (!filter_var($url, FILTER_VALIDATE_URL) || parse_url($url, PHP_URL_SCHEME) !== 'https') {
            $this->error('The URL must be a valid HTTPS URL.');
            return 1;
        }

        if (empty($config['token'])) {
            $this->error('❌ Bot token is not configured');
            $this->line('Please add XBOT_TOKEN=your-token to your .env file');
            return 1;
        }

        try {
            $bot = new Bot($config);
            $data = $bot->setWebhook([
                'url' => $url,
                'drop_pending_updates' => true
            ]);

            $this->info('✅ ' . $data);
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }
}
