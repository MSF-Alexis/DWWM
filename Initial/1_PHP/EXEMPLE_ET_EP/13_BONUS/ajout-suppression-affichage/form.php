<?php require_once('./header.php') ?>
<main class="container">
    <a href="./index.php" class="btn btn-info">Liste des utilisateurs</a>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <form class="bg-black rounded-3 p-4 shadow-lg" action="./traitement.php" method="POST">
                <div class="mb-3">
                    <?php if (isset($_GET['erreur']) && !empty($_GET['erreur'])) : ?>
                        <p class="text-danger">
                            <?= $_GET['erreur'] ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="inputEmail" class="form-label text-light">Email</label>
                    <input type="email" name="email-input" class="form-control bg-dark border-dark text-light" id="inputEmail">
                </div>
                <div class="mb-3">
                    <label for="inputUsername" class="form-label text-light">Nom d'utilisateur</label>
                    <input type="text" name="username-input" class="form-control bg-dark border-dark text-light" id="inputUsername">
                </div>
                <div class="mb-4">
                    <label for="inputPassword" class="form-label text-light">Mot de passe</label>
                    <input type="password" name="password-input" name="password-input" class="form-control bg-dark border-dark text-light" id="inputPassword">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block rounded-pill">Inscription</button>
                </div>
            </form>
        </div>
    </div>
</main>

</body>

</html>