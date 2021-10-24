<?php /** @var $perso \App\Entity\Personnage */ ?>
<?php /** @var $personnage \App\Entity\Personnage */ ?>
<h1 class="text-center">Vous jouez : <?= $perso->getNom(); ?> : <?= $perso->getPrettyClass(); ?></h1>

<?php if ($perso->isSleeping()) : ?>
    <h2 class="text-center">Vous dormez...</h2>
<?php endif; ?>

<div class="text-center">
    <p>
        Pv : <?= $perso->getPv(); ?><br/>
        Force : <?= $perso->getForce(); ?><br/>
        Defense : <?= $perso->getDefense(); ?>
    </p>
</div>

<h1 class="text-center">Tous les personnages à attaquer</h1>

<ul class="list-group mx-auto" style="max-width: 600px">
    <?php foreach ($personnages as $personnage) : ?>
        <li class="list-group-item d-flex justify-content-between">
            <?= $personnage->getNom(); ?> - <?= $personnage->getPv(); ?> points de vie
            <?php if ($personnage->isSleeping()) : ?>
                - ZzzZzzZZ, il fait dodo !
            <?php endif; ?>

            <div>
                <?php if ($perso->getPrettyClass() === 'Magicien') : ?>
                    <a href="/spell/<?= $perso->getId(); ?>?cible=<?= $personnage->getId(); ?>"
                       class="btn btn-warning btn-sm">Endormir</a>
                <?php endif; ?>

                <a href="/attack/<?= $perso->getId(); ?>?cible=<?= $personnage->getId(); ?>"
                   class="btn btn-primary btn-sm">Attaquer</a>
            </div>
        </li>
    <?php endforeach; ?>
</ul>