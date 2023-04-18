<?php

namespace Alinoksha\Indigolab\Services;

use Alinoksha\Indigolab\Exceptions\AuthException;
use Alinoksha\Indigolab\Parameters;
use Alinoksha\Indigolab\Repositories\AuthHashRepository;

class AuthManager
{
    public function __construct(
        readonly private AuthHashRepository $authHashRepo,
        readonly private SessionManager $sessionManager,
        readonly private Parameters $parameters
    ) {
    }

    public function generate(int $userId): string
    {
        $this->authHashRepo->removeForUser($userId);
        $hash = md5($userId . time() . $this->parameters->get(Parameters::HASH_SALT));
        $this->authHashRepo->store($userId, $hash);
        return $hash;
    }

    public function authorize(string $hash): void
    {
        $userId = $this->authHashRepo->findUserIdByHash($hash);
        if ($userId === null) {
            throw new AuthException();
        }

        $this->authHashRepo->removeForUser($userId);
        $this->sessionManager->set('userId', (string)$userId);
    }

    public function getCurrentUserId(): int
    {
        $rawUserId = $this->sessionManager->get('userId');
        if ($rawUserId === null) {
            throw new AuthException();
        }

        return (int)$rawUserId;
    }
}
