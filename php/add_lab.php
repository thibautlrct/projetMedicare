<?php
// php/add_lab.php

include 'config.php';

$nom = $_POST['nom'];
$salle = $_POST['salle'];
$telephone = $_POST['telephone'];
$courriel = $_POST['courriel'];

$sql = "INSERT INTO Laboratoires (nom, salle, telephone, courriel) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nom, $salle, $telephone, $courriel);

if ($stmt->execute()) {
    echo "Le laboratoire a été ajouté avec succès.";
} else {
    echo "Erreur lors de l'ajout du laboratoire : " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: ../admin_dashboard.php");
?>
