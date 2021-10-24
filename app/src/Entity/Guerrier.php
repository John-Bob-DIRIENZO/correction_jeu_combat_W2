<?php

namespace App\Entity;

class Guerrier extends Personnage
{
    public function __construct(array $data = [])
    {
        $this->setForce(random_int(20, 40))
            ->setDefense(random_int(10, 19));

        parent::__construct($data);
    }
}