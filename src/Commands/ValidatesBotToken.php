<?php
namespace Al3x5\xBotLaravel\Commands;
// src/Commands/Traits/ValidatesBotToken.php
trait ValidatesBotToken
{
    protected function ensureBotToken(): ?int
    {
        if (empty(config('xbot.token'))) {
            $this->error('❌ Bot token is not configured');
            $this->line('Please add BOT_TOKEN=your-token to your .env file');
            return 1;
        }
        return null;
    }
}