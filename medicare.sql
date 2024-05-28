CREATE TABLE medicare (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type_entite ENUM('utilisateur', 'medecin', 'rdv', 'disponibilite', 'laboratoire', 'service_laboratoire', 'rdv_labo', 'message'),

    -- Champs pour les utilisateurs
    utilisateur_id INT,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    email VARCHAR(255),
    mot_de_passe VARCHAR(255),
    adresse VARCHAR(255),
    ville VARCHAR(100),
    code_postal VARCHAR(20),
    pays VARCHAR(100),
    telephone VARCHAR(20),
    type_utilisateur ENUM('client', 'medecin', 'administrateur'),
    carte_vitale VARCHAR(50),
    informations_paiement JSON,

    -- Champs pour les médecins
    medecin_id INT,
    specialite VARCHAR(255),
    cv TEXT,
    photo VARCHAR(255),
    video VARCHAR(255),

    -- Champs pour les rendez-vous
    rdv_id INT,
    client_id INT,
    date_heure DATETIME,
    confirme BOOLEAN,

    -- Champs pour les disponibilités
    disponibilite_id INT,
    jour_semaine ENUM('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'),
    heure_debut TIME,
    heure_fin TIME,

    -- Champs pour les laboratoires
    laboratoire_id INT,
    nom_laboratoire VARCHAR(255),
    adresse_laboratoire VARCHAR(255),
    telephone_laboratoire VARCHAR(20),
    email_laboratoire VARCHAR(255),

    -- Champs pour les services de laboratoire
    service_id INT,
    nom_service VARCHAR(255),
    description_service TEXT,

    -- Champs pour les rendez-vous de laboratoire
    rdv_labo_id INT,
    service_labo_id INT,

    -- Champs pour les messages
    message_id INT,
    envoyeur_id INT,
    receveur_id INT,
    contenu TEXT,
    type_message ENUM('texte', 'audio', 'video', 'email')
);
