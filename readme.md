# Dwira blanca

Dwira Blanca is a web application that offers the best plans for tourists in casablanca along with a reservation feature.

## development environment
### prerequisites

* PHP 8
* Composer 
* Symfony CLI
* Docker
* Docker-compose

You can check requirements with: 

```bash
symfony check:requirements
```

### Launch the development environment

```bash
docker-compose up -d
symfony server:start

```

## do tests

```bash
php bin/phpunit --testdox

``` 