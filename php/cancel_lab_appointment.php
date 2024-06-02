<?php
// php/cancel_lab_appointment.php

include 'config.php';

$id = $_GET['id'];

$sql = "DELETE FROM laboratoires_rdv WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Le rendez-vous a été annulé avec succès.";
} else {
    echo "Erreur lors de l'annulation du rendez-vous : " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: ../admin_dashboard.php");
?>
