<?php

namespace Alinoksha\Indigolab\Services;

class SessionManager
{
    public function __construct()
    {
        session_start();
    }

    public function get(string $key): ?string
    {
        return $_SESSION[$key] ?? null;
    }

    public function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }
}
