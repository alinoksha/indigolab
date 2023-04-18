<?php

namespace Alinoksha\Indigolab\Repositories;

use Alinoksha\Indigolab\Database\DB;
use Alinoksha\Indigolab\Database\QueryFilterEq;

class AuthHashRepository
{
    private const TABLE_NAME = 'auth_hashes';

    public function __construct(
        private readonly DB $db
    ) {
    }

    public function store(int $userId, string $hash)
    {
        $this->db->insert(self::TABLE_NAME, [
            'user_id' => $userId,
            'hash' => $hash
        ]);
    }

    public function findUserIdByHash(string $hash): ?int
    {
        $rows = $this->db->select(self::TABLE_NAME, new QueryFilterEq('hash', $hash));

        if (count($rows) === 0) {
            return null;
        }

        $row = $rows[0];

        return $row['user_id'] ?? null;
    }

    public function removeForUser(int $userId): void
    {
        $this->db->delete(self::TABLE_NAME, new QueryFilterEq('user_id', $userId));
    }
}
