<?php

namespace App\Manager;

use App\Entity\Personnage;
use App\Fram\BaseClasses\BaseManager;
use App\Fram\Factories\PDOFactory;
use App\Fram\Interfaces\ConnectionInterface;

class PersonnageManager extends BaseManager
{
    public function __construct(ConnectionInterface $pdo)
    {
        parent::__construct($pdo);

        // Si la table n'existe pas...
        $createTable = 'CREATE DATABASE IF NOT EXISTS `' . PDOFactory::DATABASE . '`;
         USE `' . PDOFactory::DATABASE . '`;
          CREATE TABLE IF NOT EXISTS `personnage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `className` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `pv` int(11) NOT NULL,
  `force` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `sleep` datetime,
  `lastSpell` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;';
        $this->pdo->exec($createTable);
    }

    /**
     * @return Personnage[]
     */
    public function getAllPersonnages(): array
    {
        $query = 'SELECT * FROM ' . PDOFactory::DATABASE . '.personnage';
        $select = $this->pdo->query($query);
        $results = $select->fetchAll(\PDO::FETCH_ASSOC);
        $return = [];
        foreach ($results as $result) {
            $className = $result['className'];
            $return[] = new $className($result);
        }
        return $return;
    }

    public function addPersonnage(Personnage $personnage): Personnage
    {
        if (get_class($personnage) == 'App\Entity\Magicien') {
            $query = 'INSERT INTO ' . PDOFactory::DATABASE . '.personnage (className, nom, pv, `force`, defense, sleep, lastSpell) VALUES (:className, :nom, :pv, :force, :defense, :sleep, :lastSpell)';
        } else {
            $query = 'INSERT INTO ' . PDOFactory::DATABASE . '.personnage (className, nom, pv, `force`, defense, sleep) VALUES (:className, :nom, :pv, :force, :defense, :sleep)';
        }

        $insert = $this->pdo->prepare($query);
        $insert->bindValue(':className', get_class($personnage), \PDO::PARAM_STR);
        $insert->bindValue(':nom', $personnage->getNom(), \PDO::PARAM_STR);
        $insert->bindValue(':pv', $personnage->getPv(), \PDO::PARAM_INT);
        $insert->bindValue(':force', $personnage->getForce(), \PDO::PARAM_INT);
        $insert->bindValue(':defense', $personnage->getDefense(), \PDO::PARAM_INT);
        $insert->bindValue(':sleep', $personnage->getSleep(), \PDO::PARAM_STR);

        if (get_class($personnage) == 'App\Entity\Magicien') {
            $insert->bindValue(':lastSpell', $personnage->getLastSpell(), \PDO::PARAM_STR);
        }

        $insert->execute();

        return $this->getPersonnageById($this->pdo->lastInsertId());
    }

    public function getPersonnageById($id): Personnage
    {
        $query = 'SELECT * FROM ' . PDOFactory::DATABASE . '.personnage WHERE id = :id';
        $select = $this->pdo->prepare($query);
        $select->bindValue(':id', $id, \PDO::PARAM_INT);
        $select->execute();

        $result = $select->fetch(\PDO::FETCH_ASSOC);
        $className = $result['className'];
        return new $className($result);
    }

    public function updatePersonnage(Personnage $personnage): bool
    {
        if (get_class($personnage) == 'App\Entity\Magicien') {
            $query = 'UPDATE ' . PDOFactory::DATABASE . '.personnage SET pv = :pv, sleep = :sleep, lastSpell = :lastSpell WHERE id = :id';
        } else {
            $query = 'UPDATE ' . PDOFactory::DATABASE . '.personnage SET pv = :pv, sleep = :sleep WHERE id = :id';
        }
        $update = $this->pdo->prepare($query);
        $update->bindValue(':id', $personnage->getId(), \PDO::PARAM_INT);
        $update->bindValue(':pv', $personnage->getPv(), \PDO::PARAM_INT);
        $update->bindValue(':sleep', $personnage->getSleep(), \PDO::PARAM_STR);

        if (get_class($personnage) == 'App\Entity\Magicien') {
            $update->bindValue(':lastSpell', $personnage->getLastSpell(), \PDO::PARAM_STR);
        }

        return $update->execute();
    }

    public function deletePersonnageById($id): bool
    {
        $query = 'DELETE FROM ' . PDOFactory::DATABASE . '.personnage WHERE id = :id';
        $select = $this->pdo->prepare($query);
        $select->bindValue(':id', $id, \PDO::PARAM_INT);
        return $select->execute();
    }
}