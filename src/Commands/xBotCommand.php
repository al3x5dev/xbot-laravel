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
        $args = $this->argument('args') ?: ['install'];

        $this->info("Running xBot: " . implode(' ', $args));

        // Lógica especial para instalación
        if ($args[0] === 'install' && !file_exists(config_path('xbot.php'))) {
            return $this->runInstallation();
        }

        // EJECUTAR TU CLI DE xBot INTERNAMENTE
        $process = new Process([
            PHP_BINARY,              // Ejecuta PHP
            base_path('vendor/bin/xbot'),  // Tu CLI real
            ...$args                 // Los mismos argumentos que recibió Artisan
        ]);

        $process->setWorkingDirectory(base_path());
        $process->setTimeout(300);

        // Mostrar output en tiempo real
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        return $process->isSuccessful() ? 0 : 1;
    }

    protected function runInstallation()
    {
        $this->info('Starting xBot installation for Laravel...');

        // PASO 1: Configurar Laravel API
        $this->call('install:api');
        // Esto ejecuta: php artisan install:api internamente

        // PASO 2: Publicar configuración de xBot
        $this->call('vendor:publish', [
            '--provider' => 'Al3x5\xBotLaravel\xBotServiceProvider',
            '--tag' => 'xbot-config'
        ]);
        // Esto copia tu config/xbot.php al proyecto Laravel

        // PASO 3: Ejecutar instalación interactiva de xBot
        $process = new Process([PHP_BINARY, base_path('vendor/bin/xbot'), 'install']);
        $process->setWorkingDirectory(base_path());
        $process->setTty(Process::isTtySupported());
        $process->setTimeout(0);

        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        // PASO 4: Adaptar configuración para Laravel
        /*if (file_exists(base_path('config.php'))) {
            $this->moveConfigToLaravel();
        }*/

        $this->info('✅ xBot installed successfully for Laravel!');
        return 0;
    }

    protected function moveConfigToLaravel()
    {
        // Leer la configuración que generó tu CLI standalone
        $standaloneConfig = include base_path('config.php');

        // Crear contenido adaptado para Laravel
        $laravelConfig = "<?php\n\nreturn [\n";

        foreach ($standaloneConfig as $key => $value) {
            if ($key === 'cache' && is_object($value)) {
                // CONVERTIR: cache standalone → cache Laravel
                $laravelConfig .= "    'cache' => new \\Al3x5\\LaravelPsr16Cache\\LaravelCache(app('cache')),\n";
            } else {
                // Mantener otros valores igual
                $laravelConfig .= "    '{$key}' => " . var_export($value, true) . ",\n";
            }
        }

        $laravelConfig .= "];\n";

        // Guardar en la ubicación de Laravel
        file_put_contents(config_path('xbot.php'), $laravelConfig);
        // Eliminar el archivo standalone
        unlink(base_path('config.php'));

        $this->info('✅ Configuration adapted for Laravel and moved to config/xbot.php');
    }
}
