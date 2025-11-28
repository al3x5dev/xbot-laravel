<?php

namespace Al3x5\xBotLaravel\Commands;

use Illuminate\Console\Command;

class xBotInstallCommand extends Command
{
    protected $signature = 'xbot:install';
    protected $description = 'Install and configure xBot for Laravel';

    public function handle()
    {
        // Simplemente llama al comando principal con el argumento 'install'
        return $this->call('xbot', ['install']);
    }
}
