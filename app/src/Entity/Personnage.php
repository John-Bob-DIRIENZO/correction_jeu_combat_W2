<?php

namespace App\Entity;

use App\Fram\BaseClasses\BaseEntity;

abstract class Personnage extends BaseEntity
{
    private $id;
    private $nom = 'John Doe';
    private $pv = 100;
    private $force;
    private $defense;
    protected \DateTime $sleep;

    const IS_SLEEPING = 1;
    const NO_MANA = 2;
    const ITS_ME = 3;
    const NO_DEGATS = 4;
    const DEAD = 5;

    public function __construct(array $data = [])
    {
        $this->sleep = new \DateTime('-2 years');
        parent::__construct($data);
    }

    public function attack(Personnage $personnage)
    {
        if ($this->canAttack($personnage) !== true) {
            return $this->canAttack($personnage);
        }

        return $personnage->defendFrom($this);
    }

    protected function defendFrom(Personnage $personnage)
    {
        $newPv = $this->getPv() - ($personnage->getForce() - $this->getDefense());
        if ($newPv > $this->getPv()) {
            return self::NO_DEGATS;
        }

        if ($newPv <= 0) {
            return self::DEAD;
        }

        $this->setPv($newPv);
    }

    public function canAttack(Personnage $personnage)
    {
        if ($this->isSleeping()) {
            return self::IS_SLEEPING;
        }

        if ($personnage == $this) {
            return self::ITS_ME;
        }

        return true;
    }

    public function getPrettyClass()
    {
        $reflection = new \ReflectionClass($this);
        return $reflection->getShortName();
    }

    public function isSleeping():bool
    {
        return $this->sleep > new \DateTime('-1 minute');
    }

    // Getters & Setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($id): Personnage
    {
        $this->id = $id;
        return $this;
    }

    public function getPv(): int
    {
        return $this->pv;
    }

    public function setPv(int $pv): Personnage
    {
        $this->pv = $pv;
        return $this;
    }

    public function getForce()
    {
        return $this->force;
    }

    public function setForce($force): Personnage
    {
        $this->force = $force;
        return $this;
    }

    public function getDefense()
    {
        return $this->defense;
    }

    public function setDefense($defense): Personnage
    {
        $this->defense = $defense;
        return $this;
    }

    public function setSleep($sleep): Personnage
    {
        $this->sleep = new \DateTime($sleep);
        return $this;
    }

    public function getSleep()
    {
        return $this->sleep->format('Y-m-d H:i:s');
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom): Personnage
    {
        $this->nom = $nom;
        return $this;
    }
}