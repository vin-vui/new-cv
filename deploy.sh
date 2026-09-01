#!/usr/bin/env bash
#
# Script de deploiement Laravel Forge pour cv.vinvui.com
#
# Ecrit pour la strategie "zero-downtime deployments", activee par defaut sur les
# nouveaux sites Forge. A coller dans Forge : Site > Deployments > Deploy Script.
#
# Prealable indispensable, cote Forge : ajouter "storage" dans les shared paths du site.
# Sans cela, chaque release repart avec un storage vide et les 77 images du CV
# disparaissent des le deuxieme deploiement.
#
# Ce script ne seede PAS la base : le seed est une operation unique, decrite dans
# docs/superpowers/specs/2026-09-01-migration-php85-et-seed-prod-design.md

# Arrete le script des la premiere erreur. Determinant ici : sans cette ligne, un
# "npm run build" en echec n'empecherait pas $ACTIVATE_RELEASE() de basculer le
# symlink sur une release sans assets.
set -e

$CREATE_RELEASE()

cd $FORGE_RELEASE_DIRECTORY

$FORGE_COMPOSER install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Les assets compiles ne sont pas versionnes : public/build est dans .gitignore.
# Vite 8 exige Node >= 20.19 ou >= 22.12.
npm ci --no-audit --no-fund
npm run build

$FORGE_PHP artisan migrate --force

# Lie <release>/public/storage vers <release>/storage/app/public, qui pointe lui-meme
# vers le storage partage entre les releases.
$FORGE_PHP artisan storage:link --force

# optimize = config:cache + event:cache + route:cache + view:cache
$FORGE_PHP artisan optimize

$ACTIVATE_RELEASE()

# Sans effet tant que QUEUE_CONNECTION=sync, mais c'est l'emplacement correct :
# apres l'activation, pour que les workers reprennent le nouveau code.
$RESTART_QUEUES()
