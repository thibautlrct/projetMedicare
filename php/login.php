<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparer la requête SQL pour éviter les injections SQL
    $stmt = $conn->prepare("SELECT * FROM Utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['mot_de_passe'])) {
            echo "Login successful";
            
            // Start session and redirect to a logged-in page
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header("Location: ../index.php");
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found with this email";
    }

    $stmt->close();
    $conn->close();
}
?>
