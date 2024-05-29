<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicare - Gestion des Disponibilités</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Medicare: Gestion des Disponibilités</h1>
            <img src="MedicareLogo.jpg" alt="Medicare Logo">
        </div>
        <?php include 'php/nav.php'; ?>
    </header>
    <main>
        <h2>Gérer mes disponibilités</h2>
        <?php
        if (isset($_SESSION['user_id'])) {
            include 'php/config.php';
            $user_id = $_SESSION['user_id'];

            // Vérifier si l'utilisateur est médecin
            $sql = "SELECT type_utilisateur FROM Utilisateurs WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            if ($user['type_utilisateur'] !== 'medecin') {
                echo "<p>Accès refusé. Vous n'êtes pas médecin.</p>";
                exit();
            }

            // Ajouter des disponibilités
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $jour_semaine = $_POST['jour_semaine'];
                $heure_debut = $_POST['heure_debut'];
                $heure_fin = $_POST['heure_fin'];

                $sql = "INSERT INTO Disponibilites (medecin_id, jour_semaine, heure_debut, heure_fin) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isss", $user_id, $jour_semaine, $heure_debut, $heure_fin);

                if ($stmt->execute()) {
                    echo "<p>Disponibilité ajoutée avec succès.</p>";
                } else {
                    echo "<p>Erreur lors de l'ajout de la disponibilité : " . $stmt->error . "</p>";
                }

                $stmt->close();
            }

            // Afficher les disponibilités existantes
            $sql = "SELECT * FROM Disponibilites WHERE medecin_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h3>Mes disponibilités</h3>";
            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>Jour</th>
                            <th>Heure de début</th>
                            <th>Heure de fin</th>
                            <th>Action</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['jour_semaine']) . "</td>
                            <td>" . htmlspecialchars($row['heure_debut']) . "</td>
                            <td>" . htmlspecialchars($row['heure_fin']) . "</td>
                            <td><a href='delete_availability.php?id=" . htmlspecialchars($row['id']) . "'>Supprimer</a></td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Vous n'avez aucune disponibilité.</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Veuillez vous <a href='login.html'>connecter</a> pour gérer vos disponibilités.</p>";
        }
        ?>
        <h3>Ajouter une disponibilité</h3>
        <form action="" method="post">
            <label for="jour_semaine">Jour de la semaine:</label>
            <select name="jour_semaine" id="jour_semaine" required>
                <option value="Lundi">Lundi</option>
                <option value="Mardi">Mardi</option>
                <option value="Mercredi">Mercredi</option>
                <option value="Jeudi">Jeudi</option>
                <option value="Vendredi">Vendredi</option>
                <option value="Samedi">Samedi</option>
                <option value="Dimanche">Dimanche</option>
            </select>
            <label for="heure_debut">Heure de début:</label>
            <input type="time" id="heure_debut" name="heure_debut" required>
            <label for="heure_fin">Heure de fin:</label>
            <input type="time" id="heure_fin" name="heure_fin" required>
            <button type="submit">Ajouter Disponibilité</button>
        </form>
    </main>
    <footer>
        <div class="footer-content">
            <p>Contactez-nous: <a href="mailto:contact@medicare.com">contact@medicare.com</a></p>
            <a href="https://www.google.com/maps?q=40+rue+Worth,+92150+Suresnes" target="_blank">
                <img src="localisation.png" alt="Icone Google Maps">
            </a>
        </div>
    </footer>
</body>
</html>
