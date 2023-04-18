<?php

namespace Alinoksha\Indigolab\Database;

use PDO;

class DB
{
    public function __construct(
        readonly private PDO $pdo
    ) {
    }

    public function insert(string $tableName, array $rowData): void
    {
        $maskedKeys = $this->prepareMaskedKeys($rowData);
        $keys = array_keys($rowData);
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $tableName,
            implode(',', $keys),
            implode(',', $maskedKeys)
        );
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_combine($maskedKeys, $rowData));
    }

    public function select(string $tableName, QueryFilter $filter = null): array
    {
        $sql = 'SELECT * FROM ' . $tableName;
        if ($filter !== null) {
            $sql .= ' WHERE ' . $filter->toString();
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($filter->getParams());

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(string $tableName, QueryFilter $filter): void
    {
        $sql = 'DELETE FROM ' . $tableName . ' WHERE ' . $filter->toString();

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($filter->getParams());
    }

    private function prepareMaskedKeys(array $rowData): array
    {
        return array_map(fn(string $key) => ':' . $key, array_keys($rowData));
    }
}
