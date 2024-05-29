<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Medicare</title>
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
        <h2>Connexion</h2>
        <form action="php/login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Se connecter</button>
        </form>
        <p>Pas encore de compte? <a href="register.php">Inscrivez-vous</a></p>
    </main>
    <footer>
        <p>Contactez-nous: <a href="mailto:contact@medicare.com">contact@medicare.com</a></p>
    </footer>
    <script src="js/scripts.js"></script>
</body>

</html>