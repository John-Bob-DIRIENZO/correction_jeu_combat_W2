<?php

namespace App\Fram\BaseClasses;

use App\Fram\Utils\Hydrator;

abstract class BaseEntity
{
    use Hydrator;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }
}