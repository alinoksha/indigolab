<?php

namespace Alinoksha\Indigolab\Database;

interface QueryFilter
{
    public function toString(): string;

    public function getParams(): array;
}
