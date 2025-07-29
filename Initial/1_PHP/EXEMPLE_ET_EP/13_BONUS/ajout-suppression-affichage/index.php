<?php
require_once('./fonction_bdd.php');
$connexionBDD = connexionBDD();
$utilisateurs = recupererUtilisateurs($connexionBDD);
require_once('./header.php');
?>
<main class="container">
    <a href="./form.php" class="btn btn-success">Ajouter un utilisateur</a>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="rounded-3 p-4 shadow-lg">
                <table class="table table-dark table-hover table-borderless">
                    <thead class="border-bottom border-secondary">
                        <tr>
                            <th scope="col" class="text-light">ID</th>
                            <th scope="col" class="text-light">Nom d'utilisateur</th>
                            <th scope="col" class="text-light">Email</th>
                            <th scope="col" class="text-light">Mot de passe hashé</th>
                            <th scope="col" class="text-light"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($utilisateurs as $utilisateur): ?>
                            <tr class="align-middle">
                                <td class="text-secondary"><?= $utilisateur['id'] ?></td>
                                <td class="text-light"><?= $utilisateur['username'] ?></td>
                                <td class="text-light"><?= $utilisateur['email'] ?></td>
                                <td class="text-truncate text-secondary" style="max-width: 150px;">
                                    <?= $utilisateur['hash_password'] ?>
                                </td>
                                <td>
                                    <a href="./supprimer.php?id=<?= $utilisateur['id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

</body>

</html>