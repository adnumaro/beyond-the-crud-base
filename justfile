#!/usr/bin/env just --justfile
export PATH := join(justfile_directory(), "node_modules", "bin") + ":" + env_var('PATH')

setup:
  cp -n .env.example .env
  composer install
  just sail up -d
  just artisan migrate
  just sail npm install

sail *args:
  ./vendor/bin/sail {{args}}

composer *args:
  just sail composer {{args}}

artisan *args:
  just sail artisan {{args}}

npm *args:
  just sail npm {{args}}

pint *args:
  just docker-compose exec laravel.test vendor/bin/pint {{args}}

pest *args:
  just docker-compose exec laravel.test vendor/bin/pest {{args}}

rector *args:
  just docker-compose exec laravel.test vendor/bin/rector process {{args}}

[private]
docker-compose *args:
  docker compose -f ./docker-compose.yml {{args}}
