
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche - Medicare</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Medicare: Services Médicaux</h1>
            <img src="MedicareLogo.jpg" alt="Medicare Logo">
        </div>
        <?php include 'php/nav.php'; ?>
    </header>
    <main>
        <h2>Recherche</h2>
        <form id="search-form">
            <label for="query">Recherche :</label>
            <input type="text" id="query" name="query" required>
            <button type="submit">Rechercher</button>
        </form>
        <div id="search-results">
            <!-- Les résultats de la recherche seront affichés ici -->
        </div>
    </main>
    <footer>
        <div class="footer-content">
            <p>Contactez-nous: <a href="mailto:contact@medicare.com">contact@medicare.com</a></p>
            <a href="https://www.google.com/maps?q=40+rue+Worth,+92150+Suresnes" target="_blank">
                <img src="localisation.png" alt="Icone Google Maps">
            </a>
        </div>
    </footer>
    <script>
        document.getElementById('search-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const query = document.getElementById('query').value;

            fetch(`php/search.php?query=${query}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('search-results').innerHTML = data;
                });
        });
    </script>
</body>
</html>
