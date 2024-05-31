<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tout parcourir - Medicare</title>
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
        <h2>Liste des Médecins</h2>
        <div id="doctors-list">
            <!-- Les résultats des médecins seront affichés ici -->
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
        // Fonction pour charger tous les médecins lors du chargement de la page
        function loadDoctors() {
            fetch('php/parcourir.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('doctors-list').innerHTML = data;
                });
        }

        // Charger les médecins après le chargement du DOM
        document.addEventListener('DOMContentLoaded', loadDoctors);
    </script>
</body>
</html>
