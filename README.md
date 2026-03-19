# NavStrike

Systeme de ciblage et de tir de missiles — Fregate FREMM, Marine Nationale.

## Installation

```bash
composer install
php -S localhost:8080 -t src/
```

## Stack

- PHP 8.3
- MySQL (via mysqli)
- Docker

## Structure

- `src/` — Code source PHP (controllers, models, helpers, config)
- `templates/` — Templates de vues
- `composer.json` — Dependances PHP
- `Dockerfile` — Configuration conteneur
- `.env` — Variables d'environnement

## Modules

- **CIC** — Centre d'Information et de Combat
- **Cibles** — Suivi et gestion des cibles hostiles
- **Missiles** — Inventaire et sequences de tir (Exocet, Aster, SCALP)
- **Radar** — Operations radar et capteurs distants
- **Missions** — Planification et briefings
- **Equipage** — Gestion des postes de combat

## Deploiement

```bash
docker build -t navstrike .
docker run -p 80:80 navstrike
```

## Contact

LV Marc Dupont — m.dupont@marine.defense.gouv.fr
Division Systemes de Combat — FREMM Aquitaine
