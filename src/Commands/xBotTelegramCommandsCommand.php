<?php

namespace Al3x5\xBotLaravel\Commands;

use Al3x5\xBot\Commands\Traits\MakeClass;
use Illuminate\Console\Command;

class xBotTelegramCommandsCommand extends Command
{
    use MakeClass;

    protected $signature = 'xbot:telegram:command {name?}';
    protected $description = 'Create a new Telegram command';

    public function handle(): int
    {
        $name = $this->argument('name');
        if (empty($name)) {
            $name = $this->ask('What should the Telegram command be named? [Eg. Start] (supports subdirs: Admin/User/Ban)');
            if (empty($name)) {
                $this->error('Name cannot be empty.');
                return 1;
            }
        }

        $data = $this->makeDir($name, 'bot/Commands', $this->output);
        if (empty($data)) {
            return 1;
        }

        $this->makeTelegramCommand($data);
        $this->info("Telegram command [{$data['filename']}] created successfully.");

        return 0;
    }
}
