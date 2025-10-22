<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = getConnection();

        $id = intval($_POST['id']);

        // Validation
        if (empty($id)) {
            header('Location: index.php?error=ID invalide');
            exit;
        }

        // Suppression de l'invité
        $stmt = $pdo->prepare("DELETE FROM invites WHERE id = :id");
        $stmt->execute([':id' => $id]);

        header('Location: index.php?msg=Invité supprimé avec succès !');
        exit;

    } catch (PDOException $e) {
        header('Location: index.php?error=Erreur lors de la suppression : ' . $e->getMessage());
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>
