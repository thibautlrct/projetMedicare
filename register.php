<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Medicare</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <h1>Medicare</h1>
        <?php include 'php/nav.php'; ?>
        <?php
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }
        ?>
    </header>
    <main>
        <h2>Inscription</h2>
        <form action="php/register.php" method="post">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="mot_de_passe">Mot de passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" required>
            <label for="ville">Ville:</label>
            <input type="text" id="ville" name="ville" required>
            <label for="code_postal">Code Postal:</label>
            <input type="text" id="code_postal" name="code_postal" required>
            <label for="pays">Pays:</label>
            <input type="text" id="pays" name="pays" required>
            <label for="telephone">Téléphone:</label>
            <input type="text" id="telephone" name="telephone" required>
            <label for="carte_vitale">Carte Vitale:</label>
            <input type="text" id="carte_vitale" name="carte_vitale" required>
            <button type="submit">S'inscrire</button>
        </form>
        <p>Déjà un compte? <a href="login.html">Connectez-vous</a></p>
    </main>
    <footer>
        <p>Contactez-nous: <a href="mailto:contact@medicare.com">contact@medicare.com</a></p>
    </footer>
    <script src="js/scripts.js"></script>
</body>

</html>