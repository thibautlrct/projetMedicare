<?php
include 'config.php';

$query = $_GET['query'];

// Requête SQL pour rechercher les médecins et les services
$sql = "SELECT * FROM doctors WHERE name LIKE '%$query%' OR specialty LIKE '%$query%'
        UNION
        SELECT * FROM services WHERE name LIKE '%$query%' OR type LIKE '%$query%'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de Recherche - Medicare</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Medicare</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Accueil</a></li>
                <li><a href="services.php">Tout Parcourir</a></li>
                <li><a href="search.php">Recherche</a></li>
                <li><a href="appointments.php">Rendez-vous</a></li>
                <li><a href="login.php">Votre Compte</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Résultats de Recherche</h2>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='result'>";
                echo "<h3>" . $row['name'] . "</h3>";
                echo "<p>" . $row['specialty'] . " - " . $row['location'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucun résultat trouvé pour votre recherche.</p>";
        }
        $conn->close();
        ?>
    </main>
    <footer>
        <p>Contactez-nous: <a href="mailto:contact@medicare.com">contact@medicare.com</a></p>
    </footer>
</body>
</html>
