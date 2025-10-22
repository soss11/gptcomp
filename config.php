<?php
/**
 * Configuration de la base de données
 * Modifier ces valeurs selon votre environnement
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'event_invitations');
define('DB_USER', 'root');
define('DB_PASS', '');

/**
 * Fonction de connexion à la base de données
 * @return PDO
 */
function getConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
?>
