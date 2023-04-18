<?php

namespace Alinoksha\Indigolab\Models;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly int $telegramId,
        public readonly string $firstName,
        public readonly ?string $lastName,
        public readonly ?string $username,
    ) {
    }
}
