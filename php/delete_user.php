<?php
include 'config.php';
session_start();

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $admin_id = $_SESSION['user_id'];
    $user_id = $_GET['id'];

    // Vérifier si l'utilisateur est administrateur
    $sql = "SELECT type_utilisateur FROM Utilisateurs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user['type_utilisateur'] !== 'administrateur') {
        echo "Accès refusé.";
        exit();
    }

    // Supprimer l'utilisateur
    $sql = "DELETE FROM Utilisateurs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "Utilisateur supprimé avec succès.";
        header("Location: ../admin_dashboard.php");
    } else {
        echo "Erreur lors de la suppression de l'utilisateur: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Requête invalide.";
}
?>
