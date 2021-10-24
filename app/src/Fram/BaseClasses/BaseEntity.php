<?php

namespace App\Fram\BaseClasses;

use App\Fram\Utils\Hydrator;

class BaseEntity
{
    use Hydrator;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }
}