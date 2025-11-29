<?php

namespace Al3x5\xBotLaravel\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

/**
 * Proxy de comandos 
 */
class xBotCommand extends Command
{
    // DEFINICIÓN DEL COMANDO ARTISAN
    protected $signature = 'xbot {args?*}';
    protected $description = 'Run xBot commands through Laravel';

    public function handle()
    {
        // Obtener los argumentos o usar 'install' por defecto
        $args = $this->argument('args');

        $this->info("Running xBot: " . implode(' ', $args));

        // Lógica especial para instalación
        if (empty($args)) {
            if (!file_exists(config_path('xbot.php'))) {
                return $this->runInstallation();
            }

            // Si está instalado, mostrar la lista de comandos de xBot
            return $this->runxBotProcess(['list']);
        }

        // EJECUTAR TU CLI DE xBot INTERNAMENTE
        return $this->runxBotProcess($args);
    }

    protected function runInstallation()
    {
        $this->info('🚀 Installing xBot for Laravel...');

        // PASO 1: Configurar Laravel API (Sanctum)
        $this->call('install:api');

        // PASO 2: Publicar configuración de xBot
        $this->call('vendor:publish', [
            '--provider' => 'Al3x5\xBotLaravel\xBotServiceProvider',
            '--tag' => 'xbot-config'
        ]);

        $this->info('✅ xBot Laravel dependencies installed!');
        $this->line('');
        $this->line('Next steps:');
        $this->line('1. Configure your BOT_TOKEN in .env file');
        $this->line('2. Run: php artisan xbot hook:set <your-webhook-url>');
        $this->line('3. Create your first command: php artisan xbot telegram:command');

        return 0;
    }

    public function runxBotProcess(array $args)
    {
        $process = new Process([
            PHP_BINARY,              // Ejecuta PHP
            base_path('vendor/bin/xbot'),  // Tu CLI real
            ...$args                 // Los mismos argumentos que recibió Artisan
        ]);

        $process->setWorkingDirectory(base_path());
        $process->setTty(Process::isTtySupported());
        $process->setTimeout(0);

        // Mostrar output en tiempo real
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        return $process->isSuccessful() ? 0 : 1;
    }
}
