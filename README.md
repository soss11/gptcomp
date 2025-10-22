# Gestion des Invitations - Application PHP/MySQL

Une application web simple et élégante pour gérer les invitations à vos événements.

## Fonctionnalités

- **Tableau de bord statistique** : Vue d'ensemble du nombre total d'invités, confirmés, en attente et déclinés
- **Gestion complète des invités** :
  - Ajouter de nouveaux invités avec leurs informations
  - Voir la liste complète des invités
  - Modifier le statut des invitations (en attente, confirmé, décliné)
  - Supprimer des invités
- **Gestion des accompagnants** : Comptabiliser le nombre de personnes accompagnantes
- **Commentaires** : Ajouter des notes spécifiques pour chaque invité (allergies, préférences, etc.)
- **Interface responsive** : Fonctionne sur desktop, tablette et mobile

## Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur (ou MariaDB 10.2+)
- Serveur web (Apache, Nginx, ou PHP built-in server pour le développement)

## Installation

### 1. Cloner ou télécharger le projet

```bash
git clone <repository-url>
cd gptcomp
```

### 2. Créer la base de données

Connectez-vous à MySQL et importez le fichier de base de données :

```bash
mysql -u root -p < database.sql
```

Ou via phpMyAdmin :
1. Créez une nouvelle base de données nommée `event_invitations`
2. Importez le fichier `database.sql`

### 3. Configurer la connexion à la base de données

Ouvrez le fichier `config.php` et modifiez les paramètres selon votre environnement :

```php
define('DB_HOST', 'localhost');     // Hôte de la base de données
define('DB_NAME', 'event_invitations'); // Nom de la base de données
define('DB_USER', 'root');          // Utilisateur MySQL
define('DB_PASS', '');              // Mot de passe MySQL
```

### 4. Démarrer l'application

#### Avec un serveur web (Apache/Nginx)

Copiez les fichiers dans le répertoire web de votre serveur (par exemple `/var/www/html/` ou `htdocs/`)

#### Avec le serveur PHP intégré (développement)

```bash
php -S localhost:8000
```

Puis ouvrez votre navigateur à l'adresse : `http://localhost:8000`

## Structure des fichiers

```
gptcomp/
│
├── config.php          # Configuration de la base de données
├── database.sql        # Schéma de la base de données
├── index.php           # Page principale avec la liste des invités
├── add.php             # Traitement de l'ajout d'invités
├── update.php          # Traitement de la mise à jour du statut
├── delete.php          # Traitement de la suppression d'invités
├── style.css           # Feuille de style CSS
└── README.md           # Ce fichier
```

## Utilisation

### Ajouter un invité

1. Remplissez le formulaire "Ajouter un Invité" sur la page principale
2. Les champs Nom et Prénom sont obligatoires
3. Sélectionnez le statut initial (en attente par défaut)
4. Indiquez le nombre d'accompagnants si nécessaire
5. Ajoutez un commentaire si besoin (ex: allergies alimentaires)
6. Cliquez sur "Ajouter l'Invité"

### Modifier le statut d'un invité

Dans la liste des invités, utilisez le menu déroulant "Changer statut" pour mettre à jour rapidement le statut d'un invité.

### Supprimer un invité

Cliquez sur le bouton de suppression (🗑️) dans la colonne Actions. Une confirmation vous sera demandée.

### Statistiques

Le tableau de bord en haut de la page affiche :
- Le nombre total d'invités
- Le nombre de confirmations
- Le nombre d'invitations en attente
- Le nombre de déclinaisons
- Le nombre total de participants (invités confirmés + accompagnants)

## Sécurité

L'application utilise :
- PDO avec des requêtes préparées pour prévenir les injections SQL
- Validation des données côté serveur
- Échappement des données affichées avec `htmlspecialchars()`

**Important** : Pour un environnement de production, ajoutez :
- HTTPS
- Protection CSRF
- Authentification utilisateur
- Limitation du taux de requêtes

## Personnalisation

### Modifier les couleurs

Éditez le fichier `style.css` et modifiez les valeurs du gradient principal :

```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

### Ajouter des champs

1. Ajoutez les colonnes dans `database.sql`
2. Mettez à jour le formulaire dans `index.php`
3. Modifiez les requêtes dans `add.php`

## Dépannage

### Erreur de connexion à la base de données

Vérifiez que :
- MySQL est en cours d'exécution
- Les identifiants dans `config.php` sont corrects
- La base de données `event_invitations` existe
- L'utilisateur a les permissions nécessaires

### Page blanche

Activez l'affichage des erreurs PHP :
```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

## Licence

Ce projet est libre d'utilisation pour vos projets personnels et commerciaux.

## Support

Pour toute question ou suggestion, n'hésitez pas à ouvrir une issue sur le dépôt GitHub.
