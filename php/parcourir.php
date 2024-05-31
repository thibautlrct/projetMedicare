<?php
include 'config.php';

// Requête SQL pour obtenir tous les médecins
$sql = "SELECT m.id, m.specialite, u.nom, u.prenom
        FROM Medecins m
        JOIN Utilisateurs u ON m.utilisateur_id = u.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<hr>";
        echo "<div class='doctor' style='background:#9016D8'>";
        echo "<h3>" . htmlspecialchars($row['nom']) . " " . htmlspecialchars($row['prenom']) . "</h3>";
        echo "<p>Spécialité: " . htmlspecialchars($row['specialite']) . "</p>";
        echo "</div>";
        echo "<hr>";
    }
} else {
    echo "Aucun médecin trouvé.";
}

$conn->close();
?>