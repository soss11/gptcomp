<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = getConnection();

        $id = intval($_POST['id']);
        $statut = $_POST['statut'];

        // Validation
        if (empty($id) || !in_array($statut, ['en_attente', 'confirme', 'decline'])) {
            header('Location: index.php?error=Données invalides');
            exit;
        }

        // Mise à jour du statut
        $stmt = $pdo->prepare("UPDATE invites SET statut = :statut WHERE id = :id");
        $stmt->execute([
            ':statut' => $statut,
            ':id' => $id
        ]);

        header('Location: index.php?msg=Statut mis à jour avec succès !');
        exit;

    } catch (PDOException $e) {
        header('Location: index.php?error=Erreur lors de la mise à jour : ' . $e->getMessage());
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>
