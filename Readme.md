
---

# RXIN306 - PHP procédural et POO (X-BAC-IN-2 - 2425S3)

## Présentation de l’Application

Cette application est un livre d’or en ligne permettant aux utilisateurs de s’inscrire, de se connecter, de poster des messages, de les éditer et de les supprimer. Elle offre également une fonctionnalité de réinitialisation de mot de passe. L’ensemble du projet suit une architecture MVC simplifiée et exploite des namespaces conformes à PSR-4. L’interface graphique s’appuie sur Twig pour le templating.

## Fonctionnalités Principales

- **Inscription d’un nouvel utilisateur :**
  - L'utilisateur peut créer un compte en fournissant un nom d'utilisateur, un email et un mot de passe.
  - Après une inscription réussie, l'utilisateur est automatiquement connecté et redirigé vers son profil.

- **Connexion / Déconnexion :**
  - Un utilisateur enregistré peut se connecter avec son email et son mot de passe.
  - Une fois connecté, l’utilisateur peut accéder à des fonctionnalités supplémentaires comme la publication de messages.
  - L’utilisateur peut se déconnecter à tout moment, ce qui supprime sa session et son cookie d’authentification.

- **Gestion des messages :**
  - Les utilisateurs connectés peuvent ajouter un message au livre d’or.
  - Ils peuvent également modifier leurs propres messages ou les supprimer.
  - Tous les messages sont affichés sur une page dédiée.

- **Réinitialisation de mot de passe :**
  - En cas d’oubli du mot de passe, l’utilisateur peut demander une réinitialisation.
  - Un jeton de réinitialisation est créé et, une fois vérifié, l’utilisateur peut définir un nouveau mot de passe.

- **Page de profil & autres pages statiques :**
  - L’utilisateur peut consulter une page de profil qui, selon la logique business, affichera des informations personnelles ou des actions disponibles.
  - Il existe également des pages statiques (ex. “About”) disponibles pour tous les visiteurs.

## Prérequis

Avant de lancer l’application, assurez-vous d’avoir :

1. **Docker** installé sur votre machine.
   - [Instructions d’installation pour Docker](https://docs.docker.com/get-docker/)
   - Docker est disponible sur Windows, macOS et la plupart des distributions Linux.
   
2. **Docker Compose** installé.
   - Généralement fourni avec Docker Desktop sur Windows et macOS.
   - Sur Linux, vous pouvez l’installer en suivant la documentation officielle : [https://docs.docker.com/compose/install/](https://docs.docker.com/compose/install/)

3. **Accès à Internet** pour récupérer les images Docker de base et les dépendances de l’application via Composer.

## Architecture du Projet

L’arborescence du projet est similaire à ceci :

```
.
├── Dockerfile
├── docker-compose.yml
├── public
│   ├── index.php
│   ├── css/
│   ├── js/
│   └── images/
├── controllers/
│   ├── Auth/
│   ├── messages/
│   ├── AuthController.php
│   └── MessageController.php
├── models/
│   ├── users/
│   └── messages/
├── core/
│   ├── init.php
│   ├── router.php
│   └── routing/
├── views/
│   ├── auth/
│   ├── messages/
│   ├── layout.html.twig
│   └── ...
└── composer.json
```

- `public/` : Point d’entrée de l’application (index.php), ressources statiques (CSS, JS, images).
- `controllers/` : Contrôleurs qui gèrent la logique métier et interagissent avec les modèles.  
- `models/` : Couche accès données & logique spécifique aux données (utilisateurs, messages).
- `core/` : Composants partagés, configuration, routing.
- `views/` : Templates Twig pour le rendu des pages.
- `composer.json` : Définition des dépendances, autoloading et autres configurations PHP.

## Lancement de l'Application via Docker

### Étape 1 : Cloner le Dépôt (si nécessaire)

Si vous n’avez pas déjà le code source, clonez le dépôt Git :

```bash
git clone git@github.com:MatthieuBarraque/XIN306-PHP-proc-dural-et-POO-X-BAC-IN-2-2425S3.git
cd XIN306-PHP-proc-dural-et-POO-X-BAC-IN-2-2425S3
```

*(Remplacez l’URL par celle de votre dépôt.)*

### Étape 2 : Configuration des Variables d’Environnement

Avant de construire les conteneurs, vous pouvez définir certaines variables d'environnement dans un fichier `.env` à la racine du projet, par exemple :

```env
MYSQL_DATABASE=guestbook
MYSQL_USER=guestbook_user
MYSQL_PASSWORD=MotDePasseSécurisé!
MYSQL_ROOT_PASSWORD=RootMotDePasseSécurisé!

SECRET_KEY=4f3c2e1d5a6b7c8d9e0f1a2b3c4d5e6f7g8h9i0j1k2l3m4n5o6p7q8r9s0t1u2

```

- `SECRET_KEY` sera utilisé pour le hachage de tokens d'authentification.
- Les variables liées à la base de données (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`) sont configurées pour le conteneur `db` défini dans `docker-compose.yml`.

### Étape 3 : Construction et Lancement des Conteneurs

Lancer la stack Docker :

```bash
docker-compose up --build
```

Cette commande va :

- Construire l’image de l’application PHP/Apache.
- Lancer le conteneur de la base de données (MySQL ou MariaDB selon votre configuration).
- Lancer l’application web PHP/Apache avec vos fichiers.

La première exécution peut prendre quelques minutes, le temps de télécharger les images de base et d’installer les dépendances via Composer.

### Étape 4 : Initialisation de la Base de Données

Si vous avez un script SQL d’initialisation (par exemple `docker-init/init.sql`), il sera exécuté au lancement du conteneur db, créant les tables `users`, `messages`, etc.

Si ce n’est pas automatique, connectez-vous au conteneur db et exécutez manuellement le script :

```bash
docker exec -it guestbook bash
mysql -u root -p$DB_PASSWORD $DB_NAME < /docker-init/init.sql
```

*(Adaptez le nom du conteneur et le chemin vers `init.sql`.)*

### Étape 5 : Accéder à l'Application

Une fois tous les conteneurs démarrés, l’application devrait être accessible à l’adresse :

```
http://localhost:8080
```

*(Assurez-vous que le port configuré dans le `docker-compose.yml` correspond bien à `8080` ou le port que vous avez choisi.)*

### Étape 6 : Utilisation de l’Application

- **Page d’accueil** : `http://localhost:8080/`
- **Inscription** : `http://localhost:8080/register`
  - Créez un compte utilisateur.
  - Après une inscription réussie, vous êtes automatiquement connecté.
- **Connexion** : `http://localhost:8080/login`
  - Si vous avez déjà un compte, connectez-vous.
- **Profil** : `http://localhost:8080/profile`
  - Page affichant des informations sur l’utilisateur connecté.
- **Messages** : `http://localhost:8080/messages`
  - Vous pouvez ajouter, éditer, supprimer des messages si vous êtes connecté.
  - Si vous n’êtes pas connecté, vous serez redirigé vers la page de connexion.
- **Mot de passe oublié** : `http://localhost:8080/forgot_password`
  - Envoyez une demande de réinitialisation.
- **Réinitialisation du mot de passe** : Après la génération d’un token, suivez le lien envoyé (selon la logique du projet) pour définir un nouveau mot de passe.

### Étape 7 : Arrêter et Nettoyer les Conteneurs

Pour arrêter les conteneurs, utilisez :

```bash
docker-compose down
```

Ce qui arrêtera et supprimera les conteneurs, mais gardera les volumes et réseaux. Pour une suppression plus complète (base de données comprise), ajoutez l’option `-v` :

```bash
docker-compose down -v
```

Cela supprimera également les volumes associés, y compris les données de la base. Attention, c’est irréversible.

## Déploiement en Production

- **Sécurité du Cookie** : En production, activez `secure => true` pour le cookie `auth_token` et servez le site en HTTPS.
- **Clé secrète** : Assurez-vous d’avoir une clé secrète suffisamment robuste et stockée en variable d’environnement.
- **Évolutivité** : Vous pouvez configurer un reverse-proxy (NGINX ou Traefik) devant votre conteneur Apache/PHP pour gérer le TLS, l’équilibrage de charge et les headers de sécurité.

## Débogage et Logs

- **Logs de l’application** : Vérifiez les logs Apache/PHP dans le conteneur de l’application pour résoudre les problèmes.
  ```bash
  docker-compose logs app
  ```
  *(Adaptez `app` au nom du service défini dans votre `docker-compose.yml`.)*

- **Logs de la base de données** :  
  ```bash
  docker-compose logs db
  ```

- **phpinfo()** : Vous pouvez créer un fichier temporaire `phpinfo.php` dans `public` pour inspecter la configuration PHP. N’oubliez pas de le supprimer en production.

