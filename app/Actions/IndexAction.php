<?php

namespace Alinoksha\Indigolab\Actions;

use Alinoksha\Indigolab\Exceptions\AuthException;
use Alinoksha\Indigolab\Services\AuthManager;

class IndexAction
{
    public function __construct(
        private readonly AuthManager $authManager
    ) {
    }

    public function handle(): void
    {
        try {
            $userId = $this->authManager->getCurrentUserId();
        } catch (AuthException) {
            exit('Unauthorized <a href="https://t.me/indigolab_auth_bot">Authorize</a>');
        }

        exit("Authorized, userId=$userId");
    }
}
