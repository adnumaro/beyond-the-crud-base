# Beyond the crud base architecture

## Getting started

This is a Laravel project, so you need to have PHP and Composer installed.
On the other hand, this project use laravel sail, so you need to have Docker and Docker Compose installed.

### Setup
1. Clone the repository
2. Run `just setup`

## Commands

### Run tests
```shell
  just pest
```

### Format the code
```shell
  just pint
  just rector
```

### Run IDE Helper Generator for Laravel

```shell
  just ide-helper
```

### Run Artisan Commands

```shell
  just artisan [command]
```

### Run Composer Commands

```shell
  just composer [command]
```

### Run npm Commands

npm commands are run in host.

```shell
  just npm [command]
```
