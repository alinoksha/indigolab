<?php

namespace Alinoksha\Indigolab\Database;

class QueryFilterEq implements QueryFilter
{
    private string $column;
    private mixed $value;

    public function __construct(string $column, mixed $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    public function toString(): string
    {
        if ($this->value === null) {
            return sprintf("%s IS NULL", $this->column);
        }
        return sprintf("%s=:%s", $this->column, $this->column);
    }

    public function getParams(): array
    {
        if ($this->value === null) {
            return [];
        }

        return [
            ':' . $this->column => $this->value,
        ];
    }
}
