<?php

namespace Alinoksha\Indigolab;

use RuntimeException;

class Parameters
{
    public const DB = 'db';
    public const TELEGRAM_BOT_TOKEN = 'telegramBotToken';
    public const HOOK_SECRET = 'hookSecret';
    public const HASH_SALT = 'hashSalt';

    public function __construct(
        private readonly array $parameters
    ) {
    }

    public function get(string $key)
    {
        if (!key_exists($key, $this->parameters)) {
            throw new RuntimeException('Undefined parameter ' . $key);
        }
        return $this->parameters[$key];
    }
}
