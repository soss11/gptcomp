<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = getConnection();

        // Validation et nettoyage des données
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $email = trim($_POST['email']);
        $telephone = trim($_POST['telephone']);
        $statut = $_POST['statut'];
        $nombre_accompagnants = intval($_POST['nombre_accompagnants']);
        $commentaire = trim($_POST['commentaire']);

        // Validation
        if (empty($nom) || empty($prenom)) {
            header('Location: index.php?error=Le nom et le prénom sont obligatoires');
            exit;
        }

        if (!in_array($statut, ['en_attente', 'confirme', 'decline'])) {
            $statut = 'en_attente';
        }

        // Validation email si fourni
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location: index.php?error=Email invalide');
            exit;
        }

        // Insertion dans la base de données
        $stmt = $pdo->prepare("
            INSERT INTO invites (nom, prenom, email, telephone, statut, nombre_accompagnants, commentaire)
            VALUES (:nom, :prenom, :email, :telephone, :statut, :nombre_accompagnants, :commentaire)
        ");

        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':telephone' => $telephone,
            ':statut' => $statut,
            ':nombre_accompagnants' => $nombre_accompagnants,
            ':commentaire' => $commentaire
        ]);

        header('Location: index.php?msg=Invité ajouté avec succès !');
        exit;

    } catch (PDOException $e) {
        header('Location: index.php?error=Erreur lors de l\'ajout : ' . $e->getMessage());
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>
