<?php

namespace App\Manager;

use App\Entity\Image;
use App\Fram\BaseClasses\BaseManager;
use App\Fram\Factories\PDOFactory;
use App\Fram\Interfaces\ConnectionInterface;

class ImageManager extends BaseManager
{
    public function __construct(ConnectionInterface $pdo)
    {
        parent::__construct($pdo);

        // Si la table n'existe pas...
        $createTable = 'CREATE DATABASE IF NOT EXISTS `' . PDOFactory::DATABASE . '`;
         USE `' . PDOFactory::DATABASE . '`;
          CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `originalFileName` varchar(255) NOT NULL,
  `slugName` varchar(255) NOT NULL,
  `realMimeType` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;';
        $this->pdo->exec($createTable);
    }

    public function getAllImages(): array
    {
        $query = 'SELECT * FROM ' . PDOFactory::DATABASE . '.image';
        $select = $this->pdo->query($query);
        $select->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Entity\Image');
        return $select->fetchAll();
    }

    public function getImageById(int $id): Image
    {
        $query = 'SELECT * FROM ' . PDOFactory::DATABASE . '.image WHERE id = :id';
        $select = $this->pdo->prepare($query);
        $select->bindValue(':id', $id, \PDO::PARAM_INT);
        $select->execute();
        $select->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Entity\Image');
        return $select->fetch();
    }

    public function saveImage(Image $image): Image
    {
        $query = 'INSERT INTO ' . PDOFactory::DATABASE . '.image (originalFileName, slugName, realMimeType, size) VALUES (:originalFileName, :slugName, :realMimeType, :size)';
        $insert = $this->pdo->prepare($query);
        $insert->bindValue(':originalFileName', $image->getOriginalFileName(), \PDO::PARAM_STR);
        $insert->bindValue(':slugName', $image->getSlugName(), \PDO::PARAM_STR);
        $insert->bindValue(':realMimeType', $image->getRealMimeType(), \PDO::PARAM_STR);
        $insert->bindValue(':size', $image->getSize(), \PDO::PARAM_INT);
        $insert->execute();

        return $this->getImageById($this->pdo->lastInsertId());
    }
}