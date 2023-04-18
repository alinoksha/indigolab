<?php

use Alinoksha\Indigolab\Parameters;
use DI\Container;

return [
    PDO::class => static function (Container $c) {
        $parameters = $c->get(Parameters::class);
        $db = $parameters->get(Parameters::DB);
        return new PDO(sprintf(
            'pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s',
            $db['host'],
            $db['port'],
            $db['dbname'],
            $db['user'],
            $db['password']
        ));
    },
    Parameters::class => static function() {
        $rawParameters = file_get_contents(__DIR__ . '/../parameters.json');
        $parameters = json_decode($rawParameters, true);
        return new Parameters($parameters);
    },
];
