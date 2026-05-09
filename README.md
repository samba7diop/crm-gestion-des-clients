<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## À propos du projet

Ce projet est une application **CRM** (Customer Relationship Management) construite avec **Laravel**.
Elle permet de gérer le cycle commercial de bout en bout :


- **Prospection**: gestion des contacts (prospects/clients), scoring et segmentation.
- **Vente**: opportunités (pipeline), devis, activités commerciales.
- **Marketing**: campagnes et suivi des leads.
- **Facturation / Comptabilité**: factures, statuts de paiement, recouvrement et export comptable (FEC).

## Modules principaux

- **Contacts**
  - Fiche contact (prospect/client/ancien client)
  - Champs utiles (source, secteur, taille, tags, score)
  - Import / export (selon les rôles)

- **Opportunités**
  - Pipeline commercial (étapes, probabilités, prévision CA)
  - Vue kanban + déplacement d’étape (selon les rôles)

- **Devis**
  - Création de devis rattachés à un contact
  - Statuts (brouillon, envoyé, accepté, refusé)

- **Activités**
  - Activités commerciales liées au suivi (rendez-vous, appels, etc.)

- **Campagnes**
  - Création / suivi / envoi de campagnes marketing

- **Factures**
  - Factures rattachées à un devis
  - Statut de paiement: `en_attente`, `paye`, `en_retard`, `annule`
  - Export **FEC** (CSV) pour la comptabilité

- **Recouvrement (Administration)**
  - Page dédiée au suivi des factures échues
  - Actions: relance, marquer payée, annuler

## Rôles & accès (permissions)

Les utilisateurs ont un champ `role` (voir `app/Models/User.php`).
Un middleware `role` protège les routes (voir `routes/web.php` et `app/Http/Middleware/EnsureRole.php`).

- **Admin (`admin`)**
  - Accès complet à l’application (gestion utilisateurs incluse).

- **Commercial (`commercial`)**
  - Gestion: contacts, opportunités, devis, activités
  - Lecture: factures

- **Directeur commercial (`directeur_commercial`)**
  - Suivi/vision globale commerciale + opportunités
  - Lecture: contacts, devis, factures

- **Marketing (`marketing`)**
  - Gestion: campagnes
  - Lecture: contacts, devis, factures

- **Administration (`administration`)**
  - Suivi: contacts
  - Facturation/recouvrement/compta: factures + relances + export FEC

## Comptes de test disponibles

- **Admin**
  - **Email**: `aichangaidoaissata19@gmail.com'
  - **Mot de passe**: `password`

- **Commercial**
  - **Email**: ` commercial@gmail.com`
  - **Mot de passe**: `password`

- **Marketing**
  - **Email**: `senecodou@gmail.com`
  - **Mot de passe**: `password`

- **Directeur commercial (seed)**
  - **Email**: `.com`
  - **Mot de passe**: `password`

- **Administration (seed)**
  - **Email**: ` konteaicha@gmail.comm`
  - **Mot de passe**: `password`

- **Directeur commercial**
  - **Email**: `directeurcommercial@gmail.com`
  - **Mot de passe**: `Password!`

- **Administration (facturation / recouvrement / comptabilité)**
  - **Email**: ``
  - **Mot de passe**: ``

## Installation & lancement (local)

Prérequis: PHP 8.2+, Composer, une base de données (SQLite/MySQL), Node.js (si tu utilises un build front, optionnel ici).

1) Installer les dépendances

```bash
composer install
```

2) Configurer l’environnement

- Copier `.env.example` vers `.env` (si besoin)
- Configurer `APP_URL` et la base de données

3) Générer la clé et migrer

```bash
php artisan key:generate
php artisan migrate
```

4) Données de test (seed)

```bash
php artisan db:seed
```

5) Démarrer

```bash
php artisan serve
```

## À savoir (fonctionnement)

- **Dashboards**: un tableau de bord différent selon le rôle (voir `DashboardController` et `resources/views/dashboard/*`).
- **Historique**: certaines actions créent des entrées d’historique (`HistoryLog`) lors de création / modification / suppression / relance.
- **Relances facture**: envoie un email au contact lié au devis (`InvoiceReminderMail`) puis met la facture en `en_retard`.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
