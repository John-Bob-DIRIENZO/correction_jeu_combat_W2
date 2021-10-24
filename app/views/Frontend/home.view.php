<h1 class="text-center">Tous les personnages</h1>

<ul class="list-group mx-auto" style="max-width: 600px">
    <?php foreach ($personnages as $personnage) : ?>
        <li class="list-group-item d-flex justify-content-between">
            <?= $personnage->getNom() . ' - ' . $personnage->getPrettyClass(); ?>
            <a href="/play/<?= $personnage->getId(); ?>" class="btn btn-primary btn-sm">Jouer</a>
        </li>
    <?php endforeach; ?>
</ul>

<h2 class="text-center mt-5">Nouveau Personnage</h2>
<form action="/add" method="get" style="max-width: 600px" class="mx-auto">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="nom" placeholder="Francis" name="nom">
        <label for="nom">Nom du personnage</label>
    </div>
    <div class="form-floating mb-3">
        <select class="form-select" id="class" name="className" aria-label="Floating label select example">
            <option selected value="magicien">Magicien</option>
            <option value="guerrier">Guerrier</option>
        </select>
        <label for="floatingSelect">Selectionnez une classe</label>
    </div>
    <button type="submit" class="btn btn-primary w-100">Créer</button>
</form>