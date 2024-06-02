<?php
session_start();
?>

<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="services.php">Tout Parcourir</a></li>
        <li><a href="search.php">Recherche</a></li>
        <?php
        if (isset($_SESSION['user_id'])) {
            include 'php/config.php';
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT prenom, type_utilisateur FROM Utilisateurs WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    $prenom = htmlspecialchars($user['prenom']);
                    $type_utilisateur = $user['type_utilisateur'];
                    if ($type_utilisateur === 'administrateur') {
                        echo "<li><a href='admin_dashboard.php'>Panneau Admin</a></li>";
                    } else {
                        echo '<li><a href="appointments.php">Mes rendez-vous</a></li>';
                    }
                    echo "<li><a href='profile.php'>Bienvenue, <b>$prenom</b></a></li>";
                    echo "<li><a href='php/logout.php'>Déconnexion</a></li>";
                } else {
                    echo "<li><a href='login.html'>Votre Compte</a></li>";
                }
                $stmt->close();
            } else {
                echo "Erreur de préparation de la requête.";
            }
            $conn->close();
        } else {
            echo "<li><a href='login.php'>Votre Compte</a></li>";
        }
        ?>
    </ul>
</nav>