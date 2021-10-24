<?php

namespace App\Fram\BaseClasses;

use App\Fram\Interfaces\ConnectionInterface;
use Psr\Container\ContainerInterface;

class BaseManager
{
    protected \PDO $pdo;

    /**
     * @param ConnectionInterface $pdo
     */
    public function __construct(ConnectionInterface $pdo)
    {
        $this->pdo = $pdo->getConnection();
    }
}