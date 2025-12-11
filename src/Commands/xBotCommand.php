<?php

namespace Al3x5\xBotLaravel\Commands;

use Al3x5\xBot\Commands\InstallCommand;
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

    // Comandos que deben ejecutarse localmente en Laravel
    private const LOCAL_COMMANDS = [
        'hook:info',
        'hook:set', 
        'hook:delete',
        'hook:about',
    ];

    public function handle()
    {
        $args = $this->argument('args');

        $this->info("Running xBot: " . implode(' ', $args));

        // Lógica especial para instalación
        if (empty($args)) {
            if (!file_exists(config_path('xbot.php'))) {
                return $this->runInstallation();
            }

            // Si está instalado, mostrar la lista de comandos de xBot
            return $this->runCliProcess(['list']);
        }

        // Obtener el primer argumento (el comando)
        $command = $args[0];

        // Verificar si es un comando local
        if (in_array($command, self::LOCAL_COMMANDS)) {
            return $this->runLocalCommand($command, array_slice($args, 1));
        }

        // Ejecutar a través del CLI standalone
        return $this->runCliProcess($args);
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

        $xbotInstall = new InstallCommand();
        $xbotInstall->createDirectories();
        $xbotInstall->makeCommandClasses(); // Crear las clases Start y Help
        $xbotInstall->updateComposerAutoload(); // Actualizar composer.json y autoload

        $this->info('✅ xBot Laravel dependencies installed!');
        $this->line('');
        $this->line('Next steps:');
        $this->line('1. Configure your BOT_TOKEN in .env file');
        $this->line('2. Run: php artisan xbot:hook:set <your-webhook-url>');
        $this->line('3. Create your first command: php artisan xbot telegram:command');
        $this->line('4. Run: php artisan xbot register');

        return 0;
    }

    public function runCliProcess(array $args)
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

    private function runLocalCommand(string $command, array $args = []): int
    {
        // Convertir hook:info -> xbot:hook:info
        $artisanCommand = 'xbot:' . $command;
        
        // Ejecutar el comando Artisan directamente
        // Laravel se encargará de pasar los argumentos correctamente
        return $this->call($artisanCommand, $args);
    }
}
