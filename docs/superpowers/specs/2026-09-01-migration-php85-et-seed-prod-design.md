# Migration vers PHP 8.5 et seed des données de production

Date : 2026-09-01
Statut : validé, prêt pour implémentation

## Contexte

Le CV en ligne (https://cv.vinvui.com) doit déménager vers un nouveau serveur qui tourne
en PHP 8.5. Le projet est aujourd'hui un Laravel 11.2 monté depuis un squelette Laravel 10,
avec Inertia 1 et Vue 3.2, servi par Jetstream pour la partie authentifiée.

Deux objectifs :

1. Rendre le projet installable et fonctionnel sous PHP 8.5.
2. Disposer d'un seed fidèle aux données de production, pour repartir d'une base pleine
   sur le nouveau serveur sans transfert manuel de dump.

## État des lieux

### Blocage dur pour PHP 8.5

`inertiajs/inertia-laravel` v1.0.0 déclare `php: ^7.3|~8.0.0|~8.1.0|~8.2.0|~8.3.0|~8.4.0`.
Cette borne haute énumérative exclut PHP 8.5. Le paquet doit donc monter, et sa version 3
exige `laravel/framework: ^11.35|^12.0|^13.0`. La montée de Laravel n'est pas un choix de
confort, elle est entraînée par cette contrainte.

### Versions constatées et cibles

Relevé fait le 2026-09-01 sur repo.packagist.org et registry.npmjs.org.

| Paquet | Actuel | Cible | Contrainte PHP de la cible |
| --- | --- | --- | --- |
| laravel/framework | v11.2.0 | ^13.0 | ^8.3 |
| laravel/jetstream | v5.0.2 | ^5.5 | ^8.2.0 |
| laravel/fortify | v1.21.1 | ^1.39 | ^8.2 |
| laravel/sanctum | v4.0.1 | ^4.3 | ^8.2 |
| inertiajs/inertia-laravel | v1.0.0 | ^3.3 | ^8.2.0 |
| tightenco/ziggy | v1.8.2 | ^2.6 | >=8.1 |
| laravel/tinker | v2.9.0 | ^3.0 | ^8.1 |
| phpunit/phpunit | 10.5.16 | ^12.0 | >=8.3 |
| laravel/pint | ^1.0 | ^1.30 | ^8.3.0 |
| nunomaduro/collision | ^8.0 | ^8.9 | ^8.2.0 |

Côté npm : vite 4 vers 8, @vitejs/plugin-vue 4 vers 6, laravel-vite-plugin 0.7 vers 3.2,
vue 3.2 vers 3.5, @inertiajs/vue3 1 vers 3.7, marked 12 vers 18, ajout de ziggy-js 2.6.
Tailwind reste volontairement en 3.4.

Laravel 13 introduit une dépendance à `symfony/polyfill-php85`, ce qui confirme que
PHP 8.5 est la plateforme visée par cette branche.

### Ruptures de compatibilité qui touchent effectivement ce code

Dépouillées depuis les guides d'upgrade 12.x et 13.x, filtrées sur ce qui existe dans le repo.

| Origine | Changement | Conséquence ici |
| --- | --- | --- |
| Laravel 12 | La règle de validation `image` refuse désormais les SVG | Casse l'upload de logos. Trois contrôleurs valident `'image', 'mimes:jpeg,jpg,png,gif,svg'`, or 23 des 76 fichiers de production sont des SVG. Correction : `image:allow_svg`. |
| Laravel 13 | `VerifyCsrfToken` renommé `PreventRequestForgery`, avec vérification de l'origine via `Sec-Fetch-Site` | Le middleware republié `app/Http/Middleware/VerifyCsrfToken.php` disparaît avec le squelette slim. |
| Laravel 13 | `session.serialization` passe à `json` dans le squelette | Appliqué. Invalide les sessions actives, sans conséquence puisque le serveur change. |
| Laravel 13 | `cache.serializable_classes` ajouté, à `false` | Appliqué. Le projet ne met pas d'objets en cache. |
| Laravel 13 | Préfixes de cache et nom de cookie de session passent en tirets | Sans effet, les valeurs viennent de la config applicative. |
| Laravel 12 | Le disque `local` pointe par défaut vers `storage/app/private` | Sans effet, `config/filesystems.php` définit `local` explicitement sur `storage_path('app')`. |
| Laravel 12 | Carbon 2 retiré, Carbon 3 requis | Aucun usage direct de Carbon dans le code applicatif. |

Les autres items des deux guides (UUIDv7, Concurrency, upsert MySQL, DELETE avec JOIN,
événements de queue, précédence de routes par domaine, vues de pagination Bootstrap,
`Js::from`) ne concernent aucun code présent.

### Fichiers à rapatrier

77 fichiers, 28,5 Mo au total : 52 PNG, 23 SVG, 1 WEBP dans `/storage/image/`, plus une
photo de profil dans `/storage/profile-photos/`. Cinq PNG pèsent entre 1 et 1,8 Mo. Ce poids
est accepté en connaissance de cause ; l'optimisation des images est hors périmètre.

### Autres manques relevés

- Pas de `.env.example` dans le repo, ce qui est gênant pour installer sur un nouveau serveur.
- `Project::$fillable` déclare `status`, colonne absente de toutes les migrations.
- `resources/sql/projects.sql` existe mais n'est jamais chargé par `DatabaseSeeder`, et ne
  contient pas la colonne `external_url` ajoutée en 2024, ni la table pivot `project_skill`.

## Source des données de seed

`FrontController::index` publie `about`, `links`, `user`, `skills`, `projects` (avec leurs
skills) et `formations` dans les props Inertia de la page publique. Les données sont donc
récupérables sans authentification, en lisant l'attribut `data-page` du HTML de la page
d'accueil. Volumes constatés : 1 about, 6 links, 25 skills, 10 projects, 5 formations, 1 user.

Aucun accès au backend n'est nécessaire.

Note sur les données personnelles : `about` porte l'adresse, le téléphone et l'email, et
`user` porte l'email. Ces valeurs sont déjà publiques sur le CV et déjà versionnées dans
`resources/sql/abouts.sql`. Le seed ne fait donc pas fuiter d'information nouvelle. Le mot de
passe utilisateur n'est pas exposé par les props et sera un mot de passe de développement
explicite, à changer sur le nouveau serveur.

## Stratégie de vérification

Ni `php` ni `composer` ne sont installés sur la machine de développement, et il n'y a ni
`.env` ni base locale. Docker est disponible, avec l'image `php:8.5-cli` déjà présente.

- Composer tourne dans un conteneur jetable `php:8.5-cli`, ce qui valide la résolution des
  dépendances sous la version PHP réellement ciblée et non sous une autre.
- `migrate --seed` et la suite de tests tournent sur SQLite dans un fichier temporaire.
- Le seed est en plus rejoué sur un MySQL en conteneur, parce que les migrations utilisent
  `$table->enum('level', ...)`, traduit différemment par SQLite (contrainte check) et MySQL,
  et parce que la production tourne sur MySQL.

Critère objectif de réussite du seed : un test `DatabaseSeederTest` vérifie les comptes
attendus (1 about, 6 links, 25 skills, 10 projects, 5 formations), le rattachement des skills
aux projets, et la présence des fichiers copiés dans `storage/app/public`.

## Architecture cible

### Phase A, montée des dépendances backend

`composer.json` passe à `php: ^8.3` et aux versions cibles du tableau ci-dessus. Correction
de la validation SVG dans les trois contrôleurs. `phpunit.xml` mis au format PHPUnit 12.
La structure des fichiers ne bouge pas dans cette phase, afin que tout échec soit imputable
aux dépendances seules.

### Phase B, passage au squelette slim

`bootstrap/app.php` devient le point de configuration unique :

- `withRouting` pour `web`, `api`, `commands` et la route de santé
- `withMiddleware` reprend le groupe `web` actuel, dont `HandleInertiaRequests`
- `withExceptions` reprend le `dontFlash` de l'ancien handler
- le rate limiter `api` de `RouteServiceProvider` est déplacé dans `AppServiceProvider`

Fichiers supprimés : `app/Http/Kernel.php`, `app/Console/Kernel.php`,
`app/Exceptions/Handler.php`, les middlewares republiés de `app/Http/Middleware/` à
l'exception de `HandleInertiaRequests`, ainsi que `RouteServiceProvider`,
`AuthServiceProvider`, `EventServiceProvider` et `BroadcastServiceProvider`.

Conservés et déclarés dans `bootstrap/providers.php` : `AppServiceProvider`,
`FortifyServiceProvider`, `JetstreamServiceProvider`.

Point de vigilance : `RouteServiceProvider::HOME` est susceptible d'être référencé par
Fortify ou Jetstream. Chaque référence est vérifiée avant retrait de la constante.

`tests/CreatesApplication.php` est retiré au profit du trait fourni par le framework.

Création du `.env.example` manquant, aligné sur les clés réellement lues par la config.

### Phase C, montée du front

`package.json` passe aux versions cibles npm. Tailwind reste en 3.4 et
`tailwind.config.js` n'est pas touché, afin que le rendu visuel du CV ne bouge pas.

Point de rupture connu : `resources/js/app.js` importe `ZiggyVue` depuis
`../../vendor/tightenco/ziggy/dist/vue.m`, chemin qui n'existe plus en Ziggy 2. L'import
devient `import { ZiggyVue } from 'ziggy-js'`, et la publication de l'objet `Ziggy` doit
être revue en conséquence.

Les ruptures d'API du client Inertia entre la v1 et la v3 seront vérifiées contre la
documentation officielle au moment de la phase, sur les 69 composants Vue du projet.
Elles ne sont volontairement pas anticipées ici.

### Phase D, seed des données de production

```
database/seeders/
  DatabaseSeeder.php          orchestre les seeders et copie les fichiers
  AboutSeeder.php
  SkillSeeder.php
  ProjectSeeder.php           rattache les skills via Eloquent
  FormationSeeder.php
  LinkSeeder.php
  UserSeeder.php
  data/
    about.json  skills.json  projects.json  formations.json  links.json
  storage/
    image/                    76 fichiers
    profile-photos/           1 fichier
```

Chaque seeder lit son JSON et insère via Eloquent, en conservant les identifiants d'origine
pour que les relations restent valides. `ProjectSeeder` rattache les skills d'après les ids
présents dans `projects.json`. `DatabaseSeeder` copie ensuite l'arborescence
`database/seeders/storage/` vers `storage/app/public/`.

Le mécanisme actuel est retiré : suppression de `resources/sql/` et des appels
`DB::unprepared`. Le JSON est choisi plutôt que le SQL parce qu'il est indépendant du SGBD,
lisible en revue de diff, et qu'il permet de gérer la table pivot proprement.

Correction au passage : retrait de `status` de `Project::$fillable`.

## Hors périmètre

Sauf demande explicite ultérieure : migration vers Tailwind 4, optimisation ou conversion
des images, refonte des contrôleurs, conteneurisation du projet, mise en place de CI.

## Écarts constatés à l'implémentation

Relevé après réalisation. Le corps du document ci-dessus décrit les décisions prises
avant de coder ; cette section note ce que l'exécution a démenti ou révélé.

### Contrainte PHP portée à ^8.4 au lieu de ^8.3

Le squelette Laravel 13 déclare `php: ^8.3` mais son `config/database.php` utilise
`Pdo\Mysql::ATTR_SSL_CA`, une classe introduite par PHP 8.4. Déclarer `^8.3` aurait donc
été faux. Le projet déclare `php: ^8.4`, qui est le minimum réel du code et couvre le
serveur cible en 8.5.

### Ordre des phases inversé

Les 5 tests d'affichage échouaient sur l'absence de manifeste Vite, indépendamment de
Laravel. La phase front a donc été traitée avant la phase squelette, afin de disposer
d'une suite verte servant de référence avant de toucher à la structure.

### Ruptures non anticipées, découvertes à l'exécution

| Point | Détail |
| --- | --- |
| `PDO::MYSQL_ATTR_SSL_CA` déprécié | Seul avertissement de dépréciation PHP 8.5 réellement émis par le projet, dans `config/database.php`. Remplacé par `Pdo\Mysql::ATTR_SSL_CA`. |
| Inertia v3 cherche `resources/js/pages` | En minuscules, alors que le projet utilise `Pages`. Toute assertion `assertInertia()->component()` échouait. `config/inertia.php` a été publié et `pages.paths` pointé sur `resource_path('js/Pages')`, plutôt que de renommer 69 composants. |
| `<title inertia>` renommé | Inertia v3 attend `data-inertia`. Corrigé dans `resources/views/app.blade.php`. |
| `config/sanctum.php` | Référençait `App\Http\Middleware\VerifyCsrfToken` et `EncryptCookies`, tous deux supprimés par la phase squelette. Aligné sur la configuration de Sanctum 4.3, avec `PreventRequestForgery` plutôt que l'alias déprécié `ValidateCsrfToken`. |
| `CACHE_DRIVER` et `BROADCAST_DRIVER` | Noms d'avant Laravel 11 encore lus par `config/cache.php` et `config/broadcasting.php`. Renommés en `CACHE_STORE` et `BROADCAST_CONNECTION`. |
| `ExampleTest` sans `RefreshDatabase` | Passait uniquement parce que `phpunit.xml` laissait les tests taper la base réelle. `RefreshDatabase` activé. |
| `storage:link --relative` | Exige `symfony/filesystem`, que Laravel 13 ne tire plus. Sans importance sur le serveur, où `storage:link` suffit. |
| `SendEmailVerificationNotification` | N'était enregistré que par l'`EventServiceProvider` supprimé. Sans effet ici : `Features::emailVerification()` et `Features::registration()` sont désactivées dans `config/fortify.php`. |

### Anomalie préexistante corrigée

`resources/js/app.js` se terminait par un écouteur `mousemove` faisant
`document.querySelector('.light').style` sans garde. L'élément `.light` est fourni par
`GuestLayout`, donc il est présent sur la page d'accueil et sur les pages de connexion,
mais absent de `AppLayout`. Toute page du back-office levait donc
`TypeError: Cannot read properties of null` à chaque mouvement de souris.

Le défaut est antérieur à cette migration. Il a été corrigé à la demande, par une sortie
anticipée quand l'élément est absent. Vérifié au navigateur : 40 mouvements de souris sur
le back-office sans aucune erreur, et le halo suit toujours le curseur sur la page
d'accueil.

### Vérifications effectuées

- 36 tests, 140 assertions, 0 échec, 10 ignorés (features Jetstream désactivées), sous
  PHP 8.5.9, Laravel 13.29.0, PHPUnit 12.5.34.
- `migrate:fresh --seed` validé sur SQLite et sur MySQL 8.0, avec contrôle de l'`enum`
  `level`, des accents, des apostrophes typographiques et des emojis sur 4 octets.
- 0 référence d'image en base sans fichier correspondant sur le disque public.
- Rendu réel vérifié au navigateur : page d'accueil, connexion, back-office. Console sans
  erreur ni avertissement sur la page publique.
- `pint --test` conforme sur les 17 fichiers écrits ou modifiés.

## Déploiement sur Laravel Forge

Le script de déploiement est versionné dans `deploy.sh` à la racine, et doit être collé
dans Forge sous Site, Deployments, Deploy Script.

Il est écrit pour la stratégie "zero-downtime deployments", que Forge active par défaut sur
tout nouveau site et qui ne peut pas être ajoutée après coup. Le code est cloné dans un
répertoire `releases`, puis un lien symbolique `current` bascule sur la nouvelle release
une fois toutes les étapes réussies.

Conséquences sur la forme du script :

- Pas de `git pull` ni de `cd` en dur : la macro `$CREATE_RELEASE()` clone le code, et
  `cd $FORGE_RELEASE_DIRECTORY` place la suite dans le contexte de la nouvelle release.
- Pas de rechargement de PHP-FPM. Chaque déploiement atterrit dans un répertoire neuf,
  donc jamais présent dans OPcache : il n'y a aucun code périmé à invalider.
- `$ACTIVATE_RELEASE()` vient après toutes les étapes de préparation, et
  `$RESTART_QUEUES()` après l'activation, pour que les workers reprennent le nouveau code.
  Cette dernière macro est sans effet tant que `QUEUE_CONNECTION=sync`.
- `set -e` est déterminant dans ce mode : sans lui, un `npm run build` en échec
  n'empêcherait pas `$ACTIVATE_RELEASE()` de basculer le symlink sur une release dépourvue
  d'assets, et le site servirait "Vite manifest not found".
- `public/build` est dans `.gitignore`, donc les assets sont construits sur le serveur.
  Vite 8 exige Node >= 20.19 ou >= 22.12. Les déploiements Forge sont plafonnés à 10
  minutes, ce qui laisse une marge confortable pour ce projet.
- `php artisan optimize` remplace les quatre commandes de cache. Vérifié : `route:cache`
  passe malgré la closure de `routes/api.php`, grâce à `laravel/serializable-closure`.
- Le seed est volontairement absent du script : c'est une opération unique, et les
  identifiants explicites des jeux de données la feraient échouer au second passage.

### Shared path obligatoire sur storage

Forge partage automatiquement le seul fichier `.env` entre les releases. Le répertoire
`storage` doit être déclaré explicitement comme shared path dans les réglages du site.

C'est impératif ici, et pas un détail de confort : les 77 images du CV vivent dans
`storage/app/public`. Sans ce partage, chaque release repart avec un `storage` vierge et
toutes les images du CV disparaissent dès le deuxième déploiement, alors que la base
continue de les référencer.

Une fois `storage` partagé, la chaîne de liens se résout correctement :
`<release>/public/storage` pointe vers `<release>/storage/app/public`, qui pointe vers
`/home/forge/cv.vinvui.com/storage/app/public`.

### Variables d'environnement retenues

`CACHE_STORE=file` et non `database` : aucune migration ne crée la table `cache`.
`SESSION_DRIVER=database` en revanche est possible, la migration
`2023_07_27_074334_create_sessions_table` existe, et c'est le défaut de `config/session.php`.
`QUEUE_CONNECTION=sync` évite d'avoir à superviser un worker, l'application n'ayant aucun
travail en file.

`APP_NAME` n'était pas défini sur l'ancienne production : le titre servi avant hydratation
était littéralement "Laravel". Il est désormais renseigné, le titre définitif restant
construit côté client depuis `about.title` et `about.subtitle`.

### Première mise en ligne, opérations uniques

1. Créer le site et la base dans Forge, en PHP 8.5
2. Ajouter `storage` dans les shared paths du site
3. Renseigner le `.env`, puis `php artisan key:generate`
4. Premier déploiement, qui joue les migrations
5. `php artisan db:seed --force` depuis `/home/forge/cv.vinvui.com/current`, une seule fois
6. Se connecter et changer immédiatement le mot de passe installé par `UserSeeder`

Le seed lancé depuis `current` écrit dans le `storage` partagé, donc les images survivent
aux déploiements suivants.

### Vérification effectuée sur les caches de production

`php artisan optimize` puis parcours de l'application : page d'accueil, connexion, route de
santé et service des images répondent tous correctement config, routes, vues et événements
mis en cache. Les 25 compétences, 10 projets, 5 formations et 6 liens sont bien servis.

À noter pour l'avenir : Inertia v3 ne transporte plus les données initiales dans
l'attribut `data-page` mais dans un `<script data-page="app" type="application/json">`.
Le procédé d'extraction utilisé pour construire ce seed depuis l'ancienne production devra
donc être adapté s'il faut le rejouer après cette migration.
