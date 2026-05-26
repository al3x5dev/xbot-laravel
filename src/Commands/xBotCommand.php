<?php

namespace Al3x5\xBotLaravel\Commands;

use Al3x5\xBot\Commands\InstallCommand;
use Illuminate\Console\Command;

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

        
        // Lógica especial para instalación
        if (empty($args)) {
            if (!file_exists(config_path('xbot.php'))) {
                return $this->runInstallation();
            }

            $this->info('xBot is installed. Available commands:');
            $this->line('  php artisan xbot:register');
            $this->line('  php artisan xbot:hook:set <url>');
            $this->line('  php artisan xbot:hook:delete');
            $this->line('  php artisan xbot:hook:info');
            $this->line('  php artisan xbot:hook:about');
            $this->line('  php artisan xbot:telegram:command <name>');
            $this->line('  php artisan xbot:telegram:callback <name> <action>');
            $this->line('  php artisan xbot:telegram:conversation <name>');
            $this->line('  php artisan xbot:telegram:handler <name>');
            $this->line('  php artisan xbot:telegram:middleware <name>');

            return 0;
        }

        // Obtener el primer argumento (el comando)
        $command = $args[0];

        // Verificar si es un comando local
        if (in_array($command, self::LOCAL_COMMANDS)) {
            return $this->runLocalCommand($command, array_slice($args, 1));
        }

        $this->error("Unknown xBot command: $command");
        $this->line('Run php artisan xbot to see available commands.');
        return 1;
    }

    protected function runInstallation()
    {
        $this->info('Installing xBot for Laravel...');

        // Configurar Laravel API (Sanctum)
        $this->call('install:api');

        // Publicar configuración de xBot
        $this->call('vendor:publish', [
            '--provider' => 'Al3x5\xBotLaravel\xBotServiceProvider',
            '--tag' => 'xbot-config'
        ]);

        $xbotInstall = new InstallCommand();
        $xbotInstall->createDirectories();
        $xbotInstall->mwConfig();
        $xbotInstall->loggerMiddleware();
        $xbotInstall->makeCommandClasses();
        $xbotInstall->updateComposerAutoload();

        $this->info('xBot Laravel dependencies installed!');
        $this->line('');
        $this->line('Next steps:');
        $this->line('1. Configure your BOT_TOKEN in .env file');
        $this->line('2. Run: php artisan xbot:hook:set <your-webhook-url>');
        $this->line('3. Create your first command: php artisan xbot telegram:command');
        $this->line('4. Run: php artisan xbot register');

        return 0;
    }

    private function runLocalCommand(string $command, array $args = []): int
    {
        // Convertir hook:info -> xbot:hook:info
        $artisanCommand = 'xbot:' . $command;

        $mapped = [];
        foreach ($args as $i => $arg) {
            $mapped[$i === 0 ? 'url' : 'arg' . $i] = $arg;
        }

        // Ejecutar el comando Artisan directamente
        // Laravel se encargará de pasar los argumentos correctamente
        return $this->call($artisanCommand, $mapped);
    }
}
