# Nem-konvencionális utazási iroda

## Inditás
Dockerrel:
* Minden be van állitva elvileg
```bash
cd .docker
docker compose up --build
```
Docker nélkül (PHP 8.1 + Composer):
* Másold le a .env.example fájlt .env néven, és ird át a DB_* változókat
```bash
composer install
php artisan serve
```

## Adatbázis kezelése
Web interfész az adatbázishoz: `http://localhost:7474/`

* Connect URL: bolt://localhost:7687
* Username: neo4j
* Password: 12345678

### Adatbázis import
Dockerben:
* A dumpot másoljuk a .docker/database/data mappába
* A projektet megállitva:
```bash
docker compose run database bash
bin/neo4j-admin database load --overwrite-destination=true --from-path=data neo4j
```

## Kód felépitése
* A HTML/CSS/JS az app/resources mappáiban található (egyelőre minden a welcome.blade.php-ban van)
* A controller kód az app/Http/Controllers mappában
* A modellek majd az app/Models mappában
* A route mappingek az app/routes mappában (jelenleg egyetlen route van, ami közvetlenül megjeleniti a "welcome" viewet)
