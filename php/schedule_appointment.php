<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $client_id = $_SESSION['user_id'];
    $medecin_id = $_POST['medecin_id'];
    $day_of_week = $_POST['date'];
    $heure = $_POST['heure'];

    // Trouver la prochaine date correspondant au jour de la semaine donné
    $days_of_week = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    $day_index = array_search($day_of_week, $days_of_week);
    $current_day_index = date('N') - 1; // 'N' donne le jour de la semaine (1 pour lundi, 7 pour dimanche)
    
    if ($day_index === false) {
        echo "Jour de la semaine invalide.";
        exit();
    }

    $days_ahead = ($day_index - $current_day_index + 7) % 7;
    $date = date('Y-m-d', strtotime("+$days_ahead days"));

    // Vérifier que le jour n'est pas dimanche
    if ($day_of_week == 'Dimanche') {
        echo "Le médecin n'est pas disponible le dimanche.";
        exit();
    }

    // Vérifier que l'heure du rendez-vous n'est pas déjà réservée
    $sql = "SELECT * FROM RendezVous WHERE medecin_id = ? AND date = ? AND heure = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $medecin_id, $date, $heure);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Le créneau est déjà réservé
        echo "Le médecin n'est pas disponible à cette heure.";
    } else {
        // Insérer le rendez-vous avec le statut "en attente"
        $statut = 'en attente';
        $sql = "INSERT INTO RendezVous (client_id, medecin_id, date, heure, statut) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $client_id, $medecin_id, $date, $heure, $statut);

        if ($stmt->execute()) {
            echo "Rendez-vous programmé avec succès.";
            header("Location: ../appointments.php");
        } else {
            echo "Erreur lors de la programmation du rendez-vous : " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Requête invalide.";
}
?>
