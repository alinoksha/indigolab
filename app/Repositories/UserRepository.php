<?php

namespace Alinoksha\Indigolab\Repositories;

use Alinoksha\Indigolab\Database\DB;
use Alinoksha\Indigolab\Database\QueryFilterEq;
use Alinoksha\Indigolab\Models\User;

class UserRepository
{
    private const TABLE_NAME = 'users';
    public function __construct(
        private readonly DB $db
    ) {
    }

    public function createFromTelegramData(array $data): User
    {
        $this->db->insert(self::TABLE_NAME, [
            'telegram_id' => $data['id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
        ]);

        return $this->findByTelegramId($data['id']);
    }

    public function findByTelegramId(int $telegramId): ?User
    {
        $rows = $this->db->select(self::TABLE_NAME, new QueryFilterEq('telegram_id', $telegramId));
        if (count($rows) === 0) {
            return null;
        }

        $row = $rows[0];

        return new User($row['id'], $row['telegram_id'], $row['first_name'], $row['last_name'], $row['username']);
    }
}
