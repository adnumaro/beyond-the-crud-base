#!/usr/bin/env just --justfile
export PATH := join(justfile_directory(), "node_modules", "bin") + ":" + env_var('PATH')

sail *args:
  ./vendor/bin/sail {{args}}

pint *args:
  just docker-compose exec laravel.test vendor/bin/pint {{args}}

[private]
docker-compose *args:
  docker compose -f ./docker-compose.yml {{args}}
