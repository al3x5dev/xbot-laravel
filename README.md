# xBot Laravel

Seamless integration of xBot [the powerful PHP library for creating Telegram bots](https://github.com/al3x5dev/xbot/) with the [Laravel framework](https://github.com/laravel/laravel).


## 🚀 Features

- **Artisan Commands**: Use xBot through familiar Laravel commands
- **Laravel Cache Integration**: Automatic PSR-16 adapter
- **Laravel Configuration**: Native Laravel configuration system
- **API Ready**: Automatic Laravel Sanctum configuration
- **Webhook Management**: Easy webhook configuration for Telegram bots

## 📦 Installation

```bash
composer require al3x5/xbot-laravel
```

## ⚡ Quick Start

### 1. Install and Configure

```bash
php artisan xbot
```

This command will:
- Configure the Laravel API (Sanctum)
- Publish the xBot configuration
- Guide you through setting up your bot
- Adapt the configuration for your environment Laravel

### 2. Configure Webhook

```bash
php artisan xbot:hook:set https://yourdomain.com/xbot/webhook
```

### 3. Create Your First Command

```bash
php artisan xbot telegram:command HelloWorld
```

### 4. Register all commands and callbacks

```bash
php artisan xbot register
```

## 🛠 Available Commands

All commands available in [xBot](https://github.com/al3x5dev/xbot/blob/main/docs/cli.md), except `php vendor/bin/xbot install`. This command is replaced by `php artisan xbot`.


## ⚙️ Settings

After installation, add to your `.env`:
```send
BOT_TOKEN=1234567890:ABCDEFGHIJKLMNOQRSTZ
ADMIN_TELEGRAM_ID=123456789,985632147
```

## 🌐 Webhook Route

Add to your `routes/api.php`:

```php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/bot', function (Request $request) {
    $bot = new Al3x5\xBot\Bot(config('xbot'));
    $bot->run();
});
```

## 🔧 Advanced Use

### Custom Integration

Inject xBot services into your controllers:

```php
use H3x5\xBot\Bot;

public function sayHelloWorld(Request $request, Bot $bot)
{
    return $bot->sendMessage([
        'chat_id' => 'CHAT_ID',
        'text' => 'Hello World' 
        ]);
}
```

## 📚 Requirements

- PHP 8.2+
- Laravel 12.x
- xBot Library (automatically installed)

## 🆘 Support

- [Documentation](https://github.com/al3x5dev/xbot/tree/main/docs)
- [Issues](https://github.com/al3x5/xbot-laravel/issues)

## 📄 License

MIT License - see the [LICENSE](LICENSE) file for details.

---

**Need help?** Open an issue on GitHub or consult the xBot documentation.