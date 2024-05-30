<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicare - Panneau Administrateur</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <div class="header-content">
            <h1>Medicare: Panneau Administrateur</h1>
            <img src="MedicareLogo.jpg" alt="Medicare Logo">
        </div>
        <?php include 'php/nav.php'; ?>
    </header>
    <main>
        <h2>Gestion des utilisateurs</h2>
        
        <?php
        if (isset($_SESSION['user_id'])) {
            include 'php/config.php';
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
                echo "<p>Accès refusé. Vous n'êtes pas administrateur.</p>";
                exit();
            }

            // Liste des admins
        
            echo "<h3>Liste des administrateurs</h3>";
            $sql = "SELECT * FROM Utilisateurs WHERE type_utilisateur = 'administrateur'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['nom']) . "</td>
                            <td>" . htmlspecialchars($row['prenom']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td><a href='php/delete_user.php?id=" . htmlspecialchars($row['id']) . "'>Supprimer</a></td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Aucun administrateur trouvé.</p>";
            }

            // Liste des médecins
        
            echo "<h3>Liste des médecins</h3>";
            $sql = "SELECT Utilisateurs.id, Utilisateurs.nom, Utilisateurs.prenom, Utilisateurs.email, Medecins.specialite
                    FROM Utilisateurs
                    JOIN Medecins ON Utilisateurs.id = Medecins.utilisateur_id";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Spécialité</th>
                            <th>Action</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['nom']) . "</td>
                            <td>" . htmlspecialchars($row['prenom']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>" . htmlspecialchars($row['specialite']) . "</td>
                            <td><a href='php/delete_user.php?id=" . htmlspecialchars($row['id']) . "'>Supprimer</a></td>
                            </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Aucun médecin trouvé.</p>";
            }

            // Gestion des clients
            echo "<h3>Liste des clients</h3>";
            $sql = "SELECT * FROM Utilisateurs WHERE type_utilisateur = 'client'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['nom']) . "</td>
                            <td>" . htmlspecialchars($row['prenom']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td><a href='php/delete_user.php?id=" . htmlspecialchars($row['id']) . "'>Supprimer</a></td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Aucun utilisateur trouvé.</p>";
            }


            // Ajouter un utilisateur
            echo "<h3>Ajouter un nouvel utilisateur</h3>";
            echo "<form action='php/add_user.php' method='post'>
        <label for='nom'>Nom:</label>
        <input type='text' id='nom' name='nom' required>
        <label for='prenom'>Prénom:</label>
        <input type='text' id='prenom' name='prenom' required>
        <label for='email'>Email:</label>
        <input type='email' id='email' name='email' required>
        <label for='mot_de_passe'>Mot de passe:</label>
        <input type='password' id='mot_de_passe' name='mot_de_passe' required>
        <label for='type_utilisateur'>Type d'utilisateur:</label>
        <select name='type_utilisateur' id='type_utilisateur' required>
            <option value='client'>Client</option>
            <option value='medecin'>Médecin</option>
            <option value='administrateur'>Administrateur</option>
        </select>
        <div id='specialite_div'>
            <label for='specialite'>Spécialité (SI MEDECIN):</label>
            <select name='specialite' id='specialite'>
                <option value=''>Aucune</option>
                <option value='Cardiologue'>Cardiologue</option>
                <option value='Dentiste'>Dentiste</option>
                <option value='Dermatologue'>Dermatologue</option>
                <option value='Généraliste'>Généraliste</option>
                <option value='Gynécologue'>Gynécologue</option>
                <option value='Ophtalmologue'>Ophtalmologue</option>
                <option value='ORL'>ORL</option>
                <option value='Pédiatre'>Pédiatre</option>
                <option value='Psychiatre'>Psychiatre</option>
                <option value='Radiologue'>Radiologue</option>
                <option value='Urologue'>Urologue</option>
            </select>
        </div>
        <button type='submit'>Ajouter</button>
      </form>
      <script>
        document.getElementById('type_utilisateur').addEventListener('change', function () {
            var specialiteDiv = document.getElementById('specialite_div');
            if (this.value === 'medecin') {
                specialiteDiv.style.display = 'block';
            } else {
                specialiteDiv.style.display = 'none';
            }
        });

        // Initial call to set the visibility of the specialite field based on the default selected value
        document.getElementById('type_utilisateur').dispatchEvent(new Event('change'));
      </script>";


            // Gestion des rendez-vous
            echo "<h3>Liste des rendez-vous</h3>";
            $sql = "SELECT RendezVous.id, RendezVous.date, RendezVous.heure, U1.nom AS patient_nom, U1.prenom AS patient_prenom, U2.nom AS medecin_nom, U2.prenom AS medecin_prenom
                    FROM RendezVous
                    JOIN Utilisateurs U1 ON RendezVous.client_id = U1.id
                    JOIN Medecins ON RendezVous.medecin_id = Medecins.id
                    JOIN Utilisateurs U2 ON Medecins.utilisateur_id = U2.id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Patient</th>
                            <th>Médecin</th>
                            <th>Action</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['date']) . "</td>
                            <td>" . htmlspecialchars($row['heure']) . "</td>
                            <td>" . htmlspecialchars($row['patient_prenom']) . " " . htmlspecialchars($row['patient_nom']) . "</td>
                            <td>" . htmlspecialchars($row['medecin_prenom']) . " " . htmlspecialchars($row['medecin_nom']) . "</td>
                            <td><a href='php/cancel_appointment.php?id=" . htmlspecialchars($row['id']) . "'>Annuler</a></td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Aucun rendez-vous trouvé.</p>";
            }

            $conn->close();
        } else {
            echo "<p>Veuillez vous <a href='login.html'>connecter</a> pour accéder au panneau d'administration.</p>";
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
</body>

</html>