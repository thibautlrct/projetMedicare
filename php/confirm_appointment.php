<?php
include 'config.php';
session_start();

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $appointment_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Vérifier si l'utilisateur est médecin
    $sql = "SELECT type_utilisateur FROM Utilisateurs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user['type_utilisateur'] !== 'medecin') {
        echo "Accès refusé.";
        exit();
    }

    // Mettre à jour le statut du rendez-vous à "confirmé"
    $sql = "UPDATE RendezVous SET statut = 'confirmé' WHERE id = ? AND medecin_id = (SELECT id FROM Medecins WHERE utilisateur_id = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $appointment_id, $user_id);

    if ($stmt->execute()) {
        echo "Rendez-vous confirmé avec succès.";
        header("Location: ../appointments.php");
    } else {
        echo "Erreur lors de la confirmation du rendez-vous : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Requête invalide.";
}
?>