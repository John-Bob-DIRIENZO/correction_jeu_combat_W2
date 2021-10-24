<?php

namespace App\Manager;

use App\Fram\BaseClasses\BaseManager;

class PostManager extends BaseManager
{
    public function showDatabases()
    {
        $query = $this->pdo->query('SHOW DATABASES');
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}