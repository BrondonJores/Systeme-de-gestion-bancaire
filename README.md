# Systeme de gestion bancaire

Application web de gestion bancaire construite avec Laravel 12 et Filament 4.

## Apercu
Le projet permet de gerer des utilisateurs, des comptes bancaires, des cartes bancaires et des virements, avec une interface d'administration multi-role (admin, conseiller, client).

Le flux principal est organise autour de :
- creation/gestion des comptes
- emission et validation des virements
- suivi des cartes bancaires
- dashboard metier (stats globales, top clients, repartition des virements)

## Fonctionnalites principales
- Authentification par role (`admin`, `conseiller`, `client`)
- 3 panels Filament separes :
  - `/admin`
  - `/conseiller`
  - `/client`
- CRUD via Filament pour :
  - utilisateurs
  - comptes bancaires
  - cartes bancaires
  - virements
- Gestion des statuts :
  - compte: `actif`, `inactif`, `ferme`
  - virement: `en cours`, `effectue`, `echoue`
  - carte: actif/inactif
- Widgets dashboard (panel admin/conseiller) :
  - statistiques globales
  - top clients
  - graphique des virements par type
- Seeders et factories pour generer des donnees de demo

## Stack technique
- Backend: PHP 8.2+, Laravel 12.36.1
- Admin UI: Filament 4.2.4
- Frontend tooling: Vite
- UI libs: Bootstrap 5, Tailwind CSS 4
- Charts: Chart.js
- Base de donnees cible: MySQL (configurable via `.env`)

## Architecture (resume)
- `app/Models`: modeles metier (`User`, `CompteBancaire`, `CarteBancaire`, `Virement`)
- `app/Filament/Admin/Resources`: ecrans et formulaires Filament
- `app/Filament/Admin/Widgets`: widgets dashboard
- `app/Policies`: regles d'autorisation par role
- `app/Http/Middleware/CheckUserRole.php`: controle d'acces au panel selon le role
- `app/Services/CompteBancaire`: logique metier de depot/retrait avec decorateurs
  - `FraisDecorateur`
  - `InteretDecorateur`
  - `PlafondDecorateur`
- `database/migrations`: schema SQL + vues pour analytics dashboard
- `database/seeders`: jeu de donnees de demo

## Modele de donnees
Tables principales :
- `users` (utilisateurs + role)
- `compte_bancaires` (RIB, type, solde, statut, options frais/interets/plafond)
- `carte_bancaires` (carte liee a un compte)
- `virements` (compte emetteur/destinataire, montant, statut)

Vues SQL analytics (`create_dashboard_views`) :
- `vue_total_solde`
- `vue_comptes_par_statut`
- `vue_virements_par_mois`
- `vue_statut_virements`
- `vue_top_clients`

## Installation locale
### 1) Prerequis
- PHP 8.2+
- Composer
- Node.js + npm
- MySQL

### 2) Installation
```bash
composer install
cp .env.example .env
php artisan key:generate
```

### 3) Configuration base de donnees
Mettre a jour `.env` :
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestioncomptebancaire
DB_USERNAME=root
DB_PASSWORD=
```

### 4) Migration + seed
```bash
php artisan migrate
php artisan db:seed
```

### 5) Assets frontend
```bash
npm install
npm run dev
```

### 6) Demarrage
```bash
php artisan serve
```

Application: [http://localhost:8000](http://localhost:8000)

## Comptes de demo (seeders)
Le seeder cree notamment :
- Admin
  - role: `admin`
  - mot de passe: `Admin123`
- Conseiller
  - role: `conseiller`
  - mot de passe: `Brad123`
- Clients
  - comptes generes via factory (mot de passe par defaut de factory: `password`)

## Commandes utiles
```bash
# setup complet
composer run setup

# mode dev (serveur, queue, logs, vite)
composer run dev

# tests
php artisan test

# build frontend
npm run build
```

## Etat actuel du projet (analyse rapide)
- Le projet est fonctionnellement structure autour de Filament + RBAC.
- Le test `Tests\Feature\ExampleTest` echoue actuellement car `/` redirige vers la page de login client (302), alors que le test attend 200.
- La migration `database/migrations/2025_11_24_193600_create_compte_bancaire_table.php` contient une ligne isolee `!` (a corriger si vous relancez les migrations sur un environnement neuf).

## Arborescence utile
```text
app/
  Filament/
  Http/
  Models/
  Policies/
  Services/
database/
  factories/
  migrations/
  seeders/
routes/
  web.php
```

## Auteur / Repository
- GitHub: https://github.com/BrondonJores/Systeme-de-gestion-bancaire
