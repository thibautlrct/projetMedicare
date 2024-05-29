<?php
include 'config.php';

if (isset($_GET['medecin_id'])) {
    $medecin_id = $_GET['medecin_id'];

    // Générer les créneaux horaires disponibles sauf le dimanche
    $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $hours = [
        "09:00", "09:20", "09:40", "10:00", "10:20", "10:40", "11:00", "11:20", "11:40", "12:00",
        "14:00", "14:20", "14:40", "15:00", "15:20", "15:40", "16:00", "16:20", "16:40", "17:00", "17:20", "17:40", "18:00"
    ];
    
    $disponibilites = [];
    foreach ($days as $day) {
        $disponibilites[$day] = $hours;
    }

    // Exclure les créneaux horaires déjà pris par des rendez-vous
    $sql = "SELECT date, heure FROM RendezVous WHERE medecin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $medecin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $date = $row['date'];
        $heure = $row['heure'];
        $jour_semaine = date('l', strtotime($date));
        $jours_semaine_fr = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche'
        ];
        $jour_semaine_fr = $jours_semaine_fr[$jour_semaine];

        if (isset($disponibilites[$jour_semaine_fr])) {
            $key = array_search($heure, $disponibilites[$jour_semaine_fr]);
            if ($key !== false) {
                unset($disponibilites[$jour_semaine_fr][$key]);
            }
        }
    }

    echo json_encode($disponibilites);

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([]);
}
?>
