<?php

namespace App\Controller;

use App\Entity\Guerrier;
use App\Entity\Magicien;
use App\Entity\Personnage;
use App\Fram\BaseClasses\BaseController;
use App\Fram\Utils\DIC;
use App\Fram\Utils\Flash;
use App\Manager\PersonnageManager;

class PostController extends BaseController
{
    public function executeIndex()
    {
        $personnageManager = DIC::autowire('PersonnageManager');
        /** @var $personnageManager PersonnageManager */

        $this->render(
            'Accueil',
            [
                'personnages' => $personnageManager->getAllPersonnages(),
            ],
            'Frontend/home'
        );
    }

    public function executeAdd()
    {
        $classNames = ['magicien', 'guerrier'];
        if (!in_array($this->params['className'], $classNames)) {
            die('nope');
        }
        if ($this->params['className'] == 'magicien') {
            $perso = new Magicien();
        }
        if ($this->params['className'] == 'guerrier') {
            $perso = new Guerrier();
        }
        if ($this->params['nom'] !== "") {
            $perso->setNom($this->params['nom']);
        }


        $personnageManager = DIC::autowire('PersonnageManager');
        /** @var $personnageManager PersonnageManager */

        $newPerso = $personnageManager->addPersonnage($perso);

        $this->HTTPResponse->redirect('/play/' . $newPerso->getId());
    }

    public function executePlay()
    {
        $personnageManager = DIC::autowire('PersonnageManager');
        /** @var $personnageManager PersonnageManager */

        $myPerso = $personnageManager->getPersonnageById($this->params['id']);

        $this->render(
            'Jouer',
            [
                'perso' => $myPerso,
                'personnages' => $personnageManager->getAllPersonnages(),
            ],
            'Frontend/play'
        );
    }

    public function executeAttack()
    {
        $personnageManager = DIC::autowire('PersonnageManager');
        /** @var $personnageManager PersonnageManager */

        $myPerso = $personnageManager->getPersonnageById($this->params['id']);
        $cible = $personnageManager->getPersonnageById($this->params['cible']);

        $result = $myPerso->attack($cible);

        if ($result === Personnage::DEAD) {
            $personnageManager->deletePersonnageById($cible->getId());
            Flash::setFlash('Il est mort... paix à son âme');
            $this->HTTPResponse->redirect('/play/' . $myPerso->getId());
        }

        if ($result === Personnage::ITS_ME) {
            Flash::setFlash('Vous ne voulez pas vraiment vous tapper vous même non ?!');
            $this->HTTPResponse->redirect('/play/' . $myPerso->getId());
        }

        if ($result === Personnage::NO_DEGATS) {
            Flash::setFlash("T'es pas assez costaud pour lui faire du mal...");
            $this->HTTPResponse->redirect('/play/' . $myPerso->getId());
        }

        if ($result === Personnage::IS_SLEEPING) {
            Flash::setFlash("Tu es peut être somnambule mais là... tu dors désolé");
            $this->HTTPResponse->redirect('/play/' . $myPerso->getId());
        }

        $personnageManager->updatePersonnage($cible);
        Flash::setFlash('Personnage frappé !');

        $this->HTTPResponse->redirect('/play/' . $myPerso->getId());
    }

    public function executeSpell()
    {
        $personnageManager = DIC::autowire('PersonnageManager');
        /** @var $personnageManager PersonnageManager */

        $myPerso = $personnageManager->getPersonnageById($this->params['id']);
        $cible = $personnageManager->getPersonnageById($this->params['cible']);

        if ($myPerso->getPrettyClass() !== 'Magicien') {
            Flash::setFlash("Tu n'es pas magicien... tu peux pas faire des sorts");
            $this->HTTPResponse->redirect('/play/' . $myPerso->getId());
        }

        $result = $myPerso->spell($cible);

        if ($result === Personnage::ITS_ME) {
            Flash::setFlash('Vous ne voulez pas vraiment vous tapper vous même non ?!');
            $this->HTTPResponse->redirect('/play/' . $myPerso->getId());
        }

        if ($result === Personnage::IS_SLEEPING) {
            Flash::setFlash("Tu es peut être somnambule mais là... tu dors désolé");
            $this->HTTPResponse->redirect('/play/' . $myPerso->getId());
        }

        if ($result === Personnage::NO_MANA) {
            Flash::setFlash("Attends encore un peu, tu n'as plus de mana !");
            $this->HTTPResponse->redirect('/play/' . $myPerso->getId());
        }

        $personnageManager->updatePersonnage($cible);
        $personnageManager->updatePersonnage($myPerso);
        Flash::setFlash('Personnage endormi !');

        $this->HTTPResponse->redirect('/play/' . $myPerso->getId());
    }
}