<?php

namespace Alinoksha\Indigolab\Actions;

use Alinoksha\Indigolab\Exceptions\AuthException;
use Alinoksha\Indigolab\Services\AuthManager;

class AuthAction
{
    public function __construct(
        private readonly AuthManager $authManager
    ) {
    }

    public function handle(): void
    {
        $hash = $_GET['hash'] ?? null;

        if (!is_string($hash) || strlen($hash) !== 32) {
            exit('Forbidden');
        }

        try {
            $this->authManager->authorize($hash);
        } catch (AuthException) {
            exit('Forbidden');
        }

        exit('Authorized <a href="/index.php">Main Page</a>');
    }
}
