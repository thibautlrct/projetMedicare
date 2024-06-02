<?php
// php/schedule_lab_appointment.php

include 'config.php';
session_start();

$service_id = $_POST['service'];
$date_time = $_POST['datetime'];
$utilisateur_id = $_SESSION['user_id'];

$sql = "INSERT INTO laboratoires_rdv (service_id, date_time, utilisateur_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isi", $service_id, $date_time, $utilisateur_id);

if ($stmt->execute()) {
    echo "Votre rendez-vous a été pris avec succès.";
} else {
    echo "Erreur lors de la prise de rendez-vous : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
