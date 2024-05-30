-- Table pour les utilisateurs
DROP DATABASE IF EXISTS medicare;

CREATE DATABASE IF NOT EXISTS medicare;
USE medicare;

-- Table pour les utilisateurs
CREATE TABLE Utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    mot_de_passe VARCHAR(255),
    adresse VARCHAR(255),
    ville VARCHAR(100),
    code_postal VARCHAR(10),
    pays VARCHAR(100),
    telephone VARCHAR(20),
    carte_vitale VARCHAR(20) UNIQUE,
    type_utilisateur ENUM(
        'client',
        'medecin',
        'administrateur'
    ) NOT NULL
);

-- Table pour les médecins
CREATE TABLE Medecins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    specialite VARCHAR(100),
    cv TEXT,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs (id) ON DELETE CASCADE
);

-- Table pour les rendez-vous
CREATE TABLE RendezVous (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT,
    medecin_id INT,
    date DATE,
    heure TIME,
    statut ENUM(
        'confirmé',
        'annulé',
        'en attente'
    ) DEFAULT 'en attente',
    FOREIGN KEY (client_id) REFERENCES Utilisateurs (id) ON DELETE CASCADE,
    FOREIGN KEY (medecin_id) REFERENCES Medecins (id) ON DELETE CASCADE
);

-- Ajout d'un utilisateur administrateur initial
INSERT INTO
    Utilisateurs (
        nom,
        prenom,
        email,
        mot_de_passe,
        type_utilisateur
    )
VALUES (
        'Admin',
        'Admin',
        'admin@medicare.com',
        '$2y$10$9U32kuOeZ7QSRfgfYL4Uvu4sxkyFIyNDtDewpfKnRp1zPprlL9ln6',
        'administrateur'
    );