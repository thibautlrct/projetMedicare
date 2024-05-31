<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Vérifier si l'utilisateur est administrateur
    $sql = "SELECT type_utilisateur FROM Utilisateurs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user['type_utilisateur'] !== 'administrateur') {
        echo "Accès refusé.";
        exit();
    }

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
    $type_utilisateur = $_POST['type_utilisateur'];
    $specialite = $_POST['specialite'];

    // Vérifier si l'email existe déjà
    $sql = "SELECT id FROM Utilisateurs WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Erreur: Un utilisateur avec cet email existe déjà.";
        $stmt->close();
        $conn->close();
        exit();
    }

    $stmt->close();

    // Ajouter l'utilisateur
    $sql = "INSERT INTO Utilisateurs (nom, prenom, email, mot_de_passe, type_utilisateur) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nom, $prenom, $email, $mot_de_passe, $type_utilisateur);

    if ($stmt->execute()) {
        $utilisateur_id = $stmt->insert_id;

        if ($type_utilisateur === 'medecin') {
            // Ajouter les détails du médecin
            $sql = "INSERT INTO Medecins (utilisateur_id, specialite) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $utilisateur_id, $specialite);

            if ($stmt->execute()) {
                echo "Nouveau médecin ajouté avec succès.";
                sleep(2);
                header("Location: ../admin_dashboard.php");
            } else {
                echo "Erreur lors de l'ajout du médecin: " . $stmt->error;
            }
        } else {
            echo "Nouvel utilisateur ajouté avec succès.";

        }
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Requête invalide.";
}
?>