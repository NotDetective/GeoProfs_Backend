# GeoProfs
> The API for the GeoProfs project

## Table of Contents
- [Authors](#Authors)
- [Installation](#installation)
- [Usage](#usage)
- [Docs](#docs)

## Authors
- [@NotDetective](https://github.com/NotDetective)
- [@Jannus](https://github.com/Jannus-dev)
- [@bleenie](https://github.com/bleenie)

## Installation

### Clone
```bash
git clone https://github.com/NotDetective/GeoProfs_API.git
```

```bash
cd GeoProfs_API
```

### Setup
```bash
composer install
```

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

you need to run a local MySQL server and create a database named `geoprofs`
here are a few programs that can help you with that:
- [XAMPP](https://www.apachefriends.org/index.html)
- [MAMP](https://www.mamp.info/en/)
- [Laragon](https://laragon.org/)

```bash
php artisan migrate
```

```bash
php artisan db:seed
```

## Usage

### Start the server
```bash
php artisan serve
```

### Run OpenAPI Generator
```bash
php artisan openapi:generate
```

## Docs
- [Postman](https://learning.postman.com/docs/introduction/overview/)
- [Swagger-PHP](https://zircote.github.io/swagger-php/)
- [Laravel](https://laravel.com/docs/11.x)





