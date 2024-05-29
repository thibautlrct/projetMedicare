<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicare - Rendez-vous</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        .unavailable {
            background-color: #ccc;
        }
        .available {
            background-color: #b3e6b3;
            cursor: pointer;
        }
        .selected {
            background-color: #66cc66;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Medicare: Services Médicaux</h1>
            <img src="MedicareLogo.jpg" alt="Medicare Logo">
        </div>
        <?php include 'php/nav.php'; ?>
    </header>
    <main>
        <h2>Mes Rendez-vous</h2>
        <?php
        if (isset($_SESSION['user_id'])) {
            include 'php/config.php';
            $user_id = $_SESSION['user_id'];

            // Vérifier le type d'utilisateur
            $sql = "SELECT type_utilisateur FROM Utilisateurs WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            $type_utilisateur = $user['type_utilisateur'];

            if ($type_utilisateur === 'client') {
                // Récupérer les rendez-vous du client
                $sql = "SELECT RendezVous.id, RendezVous.date, RendezVous.heure, RendezVous.statut, Utilisateurs.nom AS medecin_nom, Utilisateurs.prenom AS medecin_prenom
                        FROM RendezVous
                        JOIN Medecins ON RendezVous.medecin_id = Medecins.id
                        JOIN Utilisateurs ON Medecins.utilisateur_id = Utilisateurs.id
                        WHERE RendezVous.client_id = ?";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<table>
                            <tr>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Médecin</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['date']) . "</td>
                                <td>" . htmlspecialchars($row['heure']) . "</td>
                                <td>" . htmlspecialchars($row['medecin_prenom']) . " " . htmlspecialchars($row['medecin_nom']) . "</td>
                                <td>" . htmlspecialchars($row['statut']) . "</td>
                                <td><a href='php/cancel_appointment.php?id=" . htmlspecialchars($row['id']) . "'>Annuler</a></td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Vous n'avez aucun rendez-vous.</p>";
                }

                $stmt->close();

                // Formulaire pour programmer un rendez-vous (affiché uniquement pour les utilisateurs normaux)
                echo "<h2>Programmer un nouveau rendez-vous</h2>";
                echo "<form id='appointmentForm' action='php/schedule_appointment.php' method='post'>
                        <label for='medecin'>Sélectionner un médecin:</label>
                        <select name='medecin_id' id='medecin' required>";

                // Récupérer la liste des médecins
                $sql = "SELECT Medecins.id, Utilisateurs.nom, Utilisateurs.prenom FROM Medecins
                        JOIN Utilisateurs ON Medecins.utilisateur_id = Utilisateurs.id";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['prenom']) . " " . htmlspecialchars($row['nom']) . "</option>";
                }

                echo "</select>
                <br>
                        <input type='hidden' id='date' name='date' required>
                        <input type='hidden' id='heure' name='heure' required>
                        <table id='availabilityTable' style='margin-top: 10px;'>
                            <thead>
                                <tr>
                                    <th>H</th>
                                    <th>L</th>
                                    <th>M</th>
                                    <th>M</th>
                                    <th>J</th>
                                    <th>V</th>
                                    <th>S</th>
                                    <th>D</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Les disponibilités seront insérées ici via JavaScript -->
                            </tbody>
                        </table>
                        <button type='submit'>Prendre Rendez-vous</button>
                      </form>";

            } elseif ($type_utilisateur === 'medecin') {
                // Récupérer les rendez-vous du médecin
                $sql = "SELECT RendezVous.id, RendezVous.date, RendezVous.heure, RendezVous.statut, U1.nom AS patient_nom, U1.prenom AS patient_prenom
                        FROM RendezVous
                        JOIN Utilisateurs U1 ON RendezVous.client_id = U1.id
                        JOIN Medecins ON RendezVous.medecin_id = Medecins.id
                        WHERE Medecins.utilisateur_id = ?";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<table>
                            <tr>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Patient</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['date']) . "</td>
                                <td>" . htmlspecialchars($row['heure']) . "</td>
                                <td>" . htmlspecialchars($row['patient_prenom']) . " " . htmlspecialchars($row['patient_nom']) . "</td>
                                <td>" . htmlspecialchars($row['statut']) . "</td>
                                <td><a href='php/confirm_appointment.php?id=" . htmlspecialchars($row['id']) . "'>Confirmer</a><br><a href='php/cancel_appointment.php?id=" . htmlspecialchars($row['id']) . "'>Annuler</a></td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Vous n'avez aucun rendez-vous.</p>";
                }

                $stmt->close();
            }

            $conn->close();
        } else {
            echo "<p>Veuillez vous <a href='login.html'>connecter</a> pour voir vos rendez-vous.</p>";
        }
        ?>
    </main>
    <footer>
        <div class="footer-content">
            <p>Contactez-nous: <a href="mailto:contact@medicare.com">contact@medicare.com</a></p>
            <a href="https://www.google.com/maps?q=40+rue+Worth,+92150+Suresnes" target="_blank">
                <img src="localisation.png" alt="Icone Google Maps">
            </a>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const medecinSelect = document.getElementById('medecin');
            const availabilityTableBody = document.querySelector('#availabilityTable tbody');

            medecinSelect.addEventListener('change', function() {
                const medecinId = this.value;

                fetch(`php/get_availability.php?medecin_id=${medecinId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Vider le tableau des disponibilités
                        while (availabilityTableBody.firstChild) {
                            availabilityTableBody.removeChild(availabilityTableBody.firstChild);
                        }

                        // Créer un tableau des heures
                        const hours = ["09:00", "09:20", "09:40", "10:00", "10:20", "10:40", "11:00", "11:20", "11:40", "12:00",
                                       "14:00", "14:20", "14:40", "15:00", "15:20", "15:40", "16:00", "16:20", "16:40", "17:00", "17:20", "17:40", "18:00"];

                        hours.forEach(hour => {
                            const row = document.createElement('tr');
                            const hourCell = document.createElement('td');
                            hourCell.textContent = hour;
                            row.appendChild(hourCell);

                            ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"].forEach(day => {
                                const cell = document.createElement('td');

                                if (data[day] && data[day].includes(hour)) {
                                    cell.classList.add('available');
                                    cell.addEventListener('click', function() {
                                        document.getElementById('date').value = day;
                                        document.getElementById('heure').value = hour;
                                        document.querySelectorAll('.available').forEach(cell => cell.classList.remove('selected'));
                                        this.classList.add('selected');
                                    });
                                } else {
                                    cell.classList.add('unavailable');
                                }

                                row.appendChild(cell);
                            });

                            availabilityTableBody.appendChild(row);
                        });
                    });
            });

            // Charger les disponibilités du premier médecin par défaut
            medecinSelect.dispatchEvent(new Event('change'));
        });
    </script>
</body>
</html>
