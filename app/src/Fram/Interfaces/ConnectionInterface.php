<?php

namespace App\Fram\Interfaces;

interface ConnectionInterface
{
    /**
     * @return \PDO
     */
    public function getConnection(): \PDO;
}