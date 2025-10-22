-- Base de données pour la gestion des invitations
CREATE DATABASE IF NOT EXISTS event_invitations;
USE event_invitations;

-- Table des invités
CREATE TABLE IF NOT EXISTS invites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150),
    telephone VARCHAR(20),
    statut ENUM('en_attente', 'confirme', 'decline') DEFAULT 'en_attente',
    nombre_accompagnants INT DEFAULT 0,
    commentaire TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Données de démonstration
INSERT INTO invites (nom, prenom, email, telephone, statut, nombre_accompagnants, commentaire) VALUES
('Dupont', 'Jean', 'jean.dupont@email.com', '0612345678', 'confirme', 2, 'Allergique aux fruits de mer'),
('Martin', 'Sophie', 'sophie.martin@email.com', '0623456789', 'en_attente', 1, ''),
('Bernard', 'Pierre', 'pierre.bernard@email.com', '0634567890', 'decline', 0, 'Indisponible ce jour-là');
