<?php
include 'config.php';
session_start();

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Échapper les caractères spéciaux pour éviter les injections SQL
    $query = $conn->real_escape_string($query);

    // Rechercher des utilisateurs (médecins ou autres) par nom ou spécialité
    $sql = "SELECT U.nom, U.prenom, U.type_utilisateur, M.specialite 
            FROM Utilisateurs U
            LEFT JOIN Medecins M ON U.id = M.utilisateur_id
            WHERE U.nom LIKE '%$query%' 
               OR U.prenom LIKE '%$query%' 
               OR M.specialite LIKE '%$query%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Résultats de la recherche :</h2>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>";
            echo "<strong>Nom :</strong> " . htmlspecialchars($row['prenom']) . " " . htmlspecialchars($row['nom']) . "<br>";
            echo "<strong>Type :</strong> " . htmlspecialchars($row['type_utilisateur']) . "<br>";
            if ($row['type_utilisateur'] === 'medecin') {
                echo "<strong>Spécialité :</strong> " . htmlspecialchars($row['specialite']) . "<br>";
            }
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun résultat trouvé pour la recherche \"$query\".</p>";
    }

    $conn->close();
} else {
    echo "<p>Requête de recherche invalide.</p>";
}
?>
