# 🏠 ColocApp — Gestionnaire de colocation partagée

Une application web **monolithique MVC Laravel** permettant de gérer des colocations, suivre les dépenses partagées, calculer automatiquement les soldes et simplifier les remboursements entre colocataires.

---

## ✨ Fonctionnalités

### 👤 Utilisateurs
- Inscription, connexion et gestion du profil
- Le premier utilisateur inscrit est automatiquement promu **Admin Global**
- Les utilisateurs bannis sont déconnectés automatiquement et bloqués

### 🏡 Colocations
- Création d'une colocation (le créateur devient **Owner**)
- Invitation des membres par **email + token unique**
- Acceptation ou refus d'une invitation
- Une seule colocation active par utilisateur à la fois
- Départ d'un membre (`left_at`)
- Annulation d'une colocation (`status = cancelled`)

### 💸 Dépenses
- Ajout d'une dépense (titre, montant, date, catégorie, payeur)
- Historique complet des dépenses
- Statistiques par catégorie

### ⚖️ Balances & Remboursements
- Calcul automatique : total payé, part individuelle, solde
- Vue synthétique **« Qui doit à qui »**
- Réduction des dettes via l'enregistrement de paiements (« Marquer payé »)

### ⭐ Système de réputation
- **+1** si départ ou annulation sans dette
- **-1** si départ ou annulation avec dette
- Si un owner retire un membre endetté, la dette est imputée à l'owner

### 🛡️ Administration globale
- Tableau de bord avec statistiques globales (utilisateurs, colocations, dépenses)
- Bannissement / débannissement des utilisateurs

---

## 🧱 Stack technique

| Composant | Technologie |
|-----------|-------------|
| Framework | Laravel (MVC monolithique) |
| Base de données | MySQL |
| ORM | Eloquent |
| Authentification | Laravel Breeze |
| Frontend | Blade + Tailwind CSS |
| Mails | Laravel Mail (invitations par token) |

---

## 👥 Rôles

| Rôle | Description |
|------|-------------|
| **Member** | Membre standard d'une colocation |
| **Owner** | Créateur et administrateur de sa colocation |
| **Global Admin** | Administrateur plateforme (stats + modération) |

> Un Admin Global peut également être Owner ou Member dans une ou plusieurs colocations.

---

## 🚀 Installation

### Prérequis

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL ou PostgreSQL

### Étapes

```bash
# 1. Cloner le dépôt
git clone https://github.com/votre-utilisateur/colocapp.git
cd colocapp

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JS
npm install && npm run build

# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 5. Configurer la base de données dans .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=colocapp
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Lancer les migrations
php artisan migrate

# 7. (Optionnel) Données de test
php artisan db:seed

# 8. Lancer le serveur
php artisan serve
```

L'application est accessible sur [http://localhost:8000](http://localhost:8000).

---

## 🔐 Premier utilisateur = Admin Global

Le premier compte créé sur la plateforme est automatiquement promu **Admin Global**. Aucune configuration manuelle n'est nécessaire.

---

## 📋 Scénarios principaux

### Invitation d'un membre
1. L'owner envoie une invitation (token unique + email)
2. L'invité reçoit un lien, accepte ou refuse
3. L'email est vérifié contre l'invitation
4. Si l'invité a déjà une colocation active → blocage
5. Sinon → ajout comme membre

### Ajout d'une dépense
1. Un membre ajoute une dépense (payeur, montant, catégorie, date)
2. Les soldes de tous les membres actifs sont recalculés
3. La vue « qui doit à qui » se met à jour automatiquement

### Départ avec dette
1. Le membre quitte avec une dette → pénalité de réputation (-1)
2. La dette est redistribuée via ajustements internes

---

## 📁 Structure du projet

```
app/
├── Http/Controllers/       # Contrôleurs MVC
├── Models/                 # Modèles Eloquent
│   ├── User.php
│   ├── Colocation.php
│   ├── Expense.php
│   ├── Payment.php
│   └── Invitation.php
├── Policies/               # Autorisations
resources/
├── views/                  # Templates Blade
database/
├── migrations/             # Migrations SQL
├── seeders/                # Données de test
routes/
└── web.php                 # Routes principales
```

---

## 🗺️ Routes principales

| Méthode | URI | Description |
|---------|-----|-------------|
| GET | `/dashboard` | Tableau de bord utilisateur |
| GET/POST | `/colocations/create` | Créer une colocation |
| GET | `/colocations/{id}` | Voir une colocation |
| POST | `/colocations/{id}/invite` | Inviter un membre |
| GET | `/invitations/{token}/accept` | Accepter une invitation |
| POST | `/expenses` | Ajouter une dépense |
| GET | `/colocations/{id}/balances` | Voir les soldes |
| POST | `/settlements/{id}/pay` | Marquer un paiement |
| GET | `/admin/dashboard` | Dashboard admin global |

---

## 🔭 Hors périmètre (pistes d'évolution)

- [ ] Paiement en ligne via **Stripe**
- [ ] Notifications en **temps réel** (WebSockets)
- [ ] **Calendrier** partagé des dépenses
- [ ] **Export** des données (CSV / PDF)

---

## 📄 Licence

Ce projet est sous licence [MIT](LICENSE).

---

> Développé avec ❤️ en Laravel.
