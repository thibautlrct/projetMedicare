<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo "Login successful";
            // Start session and redirect to a logged-in page
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header("Location: ../index.html");
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found with this email";
    }

    $conn->close();
}
?>
