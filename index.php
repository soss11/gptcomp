<?php
require_once 'config.php';

// Récupérer les statistiques
$pdo = getConnection();
$stats = $pdo->query("SELECT
    COUNT(*) as total,
    SUM(CASE WHEN statut = 'confirme' THEN 1 ELSE 0 END) as confirmes,
    SUM(CASE WHEN statut = 'decline' THEN 1 ELSE 0 END) as declines,
    SUM(CASE WHEN statut = 'en_attente' THEN 1 ELSE 0 END) as en_attente,
    SUM(CASE WHEN statut = 'confirme' THEN nombre_accompagnants ELSE 0 END) as confirmes_total_personnes,
    SUM(nombre_accompagnants) as total_personnes
FROM invites")->fetch();

// Récupérer tous les invités
$invites = $pdo->query("SELECT * FROM invites ORDER BY date_creation DESC")->fetchAll();

// Messages de notification
$message = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Invitations - Mon Événement</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>📋 Gestion des Invitations</h1>
            <p class="subtitle">Organisez votre événement facilement</p>
        </header>

        <?php if ($message): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total']; ?></div>
                <div class="stat-label">Total Invités</div>
            </div>
            <div class="stat-card success">
                <div class="stat-number"><?php echo $stats['confirmes']; ?></div>
                <div class="stat-label">Confirmés</div>
            </div>
            <div class="stat-card warning">
                <div class="stat-number"><?php echo $stats['en_attente']; ?></div>
                <div class="stat-label">En Attente</div>
            </div>
            <div class="stat-card danger">
                <div class="stat-number"><?php echo $stats['declines']; ?></div>
                <div class="stat-label">Déclinés</div>
            </div>
            <div class="stat-card info">
                <div class="stat-number"><?php echo $stats['confirmes_total_personnes']; ?></div>
                <div class="stat-label">Personnes Confirmées</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="stat-number" style="color: white;"><?php echo $stats['total_personnes']; ?></div>
                <div class="stat-label" style="color: white;">Total Général</div>
            </div>
        </div>

        <!-- Formulaire d'ajout -->
        <div class="card">
            <h2>➕ Ajouter un Invité</h2>
            <form action="add.php" method="POST" class="form-invite">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone</label>
                        <input type="tel" id="telephone" name="telephone">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select id="statut" name="statut">
                            <option value="en_attente">En Attente</option>
                            <option value="confirme">Confirmé</option>
                            <option value="decline">Décliné</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombre_accompagnants">Accompagnants</label>
                        <input type="number" id="nombre_accompagnants" name="nombre_accompagnants" min="0" value="0">
                    </div>
                </div>

                <div class="form-group">
                    <label for="commentaire">Commentaire</label>
                    <textarea id="commentaire" name="commentaire" rows="2"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Ajouter l'Invité</button>
            </form>
        </div>

        <!-- Liste des invités -->
        <div class="card">
            <h2>👥 Liste des Invités (<?php echo count($invites); ?>)</h2>

            <?php if (empty($invites)): ?>
                <p class="no-data">Aucun invité pour le moment. Ajoutez votre premier invité ci-dessus!</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Statut</th>
                                <th>Accomp.</th>
                                <th>Commentaire</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invites as $invite): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($invite['nom']); ?></td>
                                    <td><?php echo htmlspecialchars($invite['prenom']); ?></td>
                                    <td><?php echo htmlspecialchars($invite['email']); ?></td>
                                    <td><?php echo htmlspecialchars($invite['telephone']); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $invite['statut']; ?>">
                                            <?php
                                            $labels = [
                                                'en_attente' => 'En Attente',
                                                'confirme' => 'Confirmé',
                                                'decline' => 'Décliné'
                                            ];
                                            echo $labels[$invite['statut']];
                                            ?>
                                        </span>
                                    </td>
                                    <td class="text-center"><?php echo $invite['nombre_accompagnants']; ?></td>
                                    <td><?php echo htmlspecialchars(substr($invite['commentaire'], 0, 30)) . (strlen($invite['commentaire']) > 30 ? '...' : ''); ?></td>
                                    <td class="actions">
                                        <form action="update.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?php echo $invite['id']; ?>">
                                            <select name="statut" onchange="this.form.submit()" class="select-status">
                                                <option value="">Changer statut</option>
                                                <option value="en_attente">En Attente</option>
                                                <option value="confirme">Confirmé</option>
                                                <option value="decline">Décliné</option>
                                            </select>
                                        </form>
                                        <form action="delete.php" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet invité ?');">
                                            <input type="hidden" name="id" value="<?php echo $invite['id']; ?>">
                                            <button type="submit" class="btn btn-delete" title="Supprimer">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <footer>
            <p>Mini App de Gestion d'Invitations - PHP/MySQL</p>
        </footer>
    </div>
</body>
</html>
