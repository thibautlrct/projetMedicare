<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $pays = $_POST['pays'];
    $telephone = $_POST['telephone'];
    $carte_vitale = $_POST['carte_vitale'];
    $type_utilisateur = 'client'; // Par défaut, l'utilisateur est un client

    // Préparer la requête SQL pour éviter les injections SQL
    $stmt = $conn->prepare("INSERT INTO Utilisateurs (nom, prenom, email, mot_de_passe, adresse, ville, code_postal, pays, telephone, carte_vitale, type_utilisateur) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $nom, $prenom, $email, $mot_de_passe, $adresse, $ville, $code_postal, $pays, $telephone, $carte_vitale, $type_utilisateur);

    if ($stmt->execute()) {
        echo "New record created successfully";
        header("Location: ../login.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
