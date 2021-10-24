<?php

namespace App\Entity;

class Magicien extends Personnage
{
    private \DateTime $lastSpell;

    public function __construct(array $data = [])
    {
        $this->setForce(random_int(5, 10))
            ->setDefense(0);

        $this->lastSpell = new \DateTime('-2 years');

        parent::__construct($data);
    }

    public function spell(Personnage $personnage)
    {
        if ($this->canAttack($personnage) !== true) {
            return $this->canAttack($personnage);
        }

        if ($this->lastSpell > new \DateTime('-2 minutes') ) {
            return self::NO_MANA;
        }

        $personnage->sleep = new \DateTime();
        $this->lastSpell = new \DateTime();
    }

    public function setLastSpell($lastSpell): Magicien
    {
        $this->lastSpell = new \DateTime($lastSpell);
        return $this;
    }

    public function getLastSpell()
    {
        return $this->lastSpell->format('Y-m-d H:i:s');
    }
}