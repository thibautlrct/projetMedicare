<?php
include 'config.php';
session_start();

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $appointment_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Vérifier si l'utilisateur est le client ou le médecin du rendez-vous
    $sql = "SELECT client_id, medecin_id FROM RendezVous WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();
    $stmt->close();

    if ($appointment) {
        // Vérifier les permissions
        $sql = "SELECT type_utilisateur FROM Utilisateurs WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user['type_utilisateur'] === 'administrateur' || $appointment['client_id'] == $user_id || $user['type_utilisateur'] === 'medecin') {
            // Supprimer le rendez-vous
            $sql = "DELETE FROM RendezVous WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $appointment_id);

            if ($stmt->execute()) {
                echo "Rendez-vous annulé avec succès.";
                if ($user['type_utilisateur'] === 'administrateur') {
                    header("Location: ../admin_dashboard.php");
                } else {
                    header("Location: ../appointments.php");
                }
            } else {
                echo "Erreur lors de l'annulation du rendez-vous : " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Accès refusé.";
        }
    } else {
        echo "Rendez-vous non trouvé.";
    }

    $conn->close();
} else {
    echo "Requête invalide.";
}
?>