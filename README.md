# Challenge PREX Julien Wolin

## Acerca del proyecto
El presente proyecto consiste en una API REST que consume un servicio de terceros ( [GIPHY](https://www.giphy.com/) ) e implementa los siguientes servicios:
- Login
- Buscar GIFS   
- Buscar GIF por ID
- Guardar GIF favorito

Además, proporciona la documentación necesaria para la instalación, preparación de datos de prueba y comprensión del funcionamiento del sistema.

## Tecnologías empleadas

- [PHP 8.3](https://www.php.net/downloads.php#v8.3.8).
- [Laravel 10](https://laravel.com/).
- [MySQL](https://www.mysql.com/).
- [UML](https://www.uml.org/).
- [Docker](https://www.docker.com/).



## Guía de Instalación y Configuración
```bash
git clone hhttps://github.com/wj-004/prex_julien.git
cd prex_julien
```
Instalar las dependencias del proyecto:
```bash
php artisan somposer install
```

Crear el archivo .env del proyecto a partir del archivo de ejemplo .env.example. y completar las variables: 
- GIPHY_API_KEY: necesaria para consumir los servicios de GIPHY 
- PASSPORT_TOKEN_EXPIRATION: Establece el tiempo de expiración del token (en minutos).
- PASSPORT_REFRESH_TOKEN_EXPIRATION: Establece cada cuantos días expira el refresh token.
```bash
GIPHY_API_KEY=""
PASSPORT_TOKEN_EXPIRATION=30
PASSPORT_REFRESH_TOKEN_EXPIRATION=7
``` 


Levantar el servicio de Laravel Sail:  
Utilizar el paquete oficial Laravel Sail para manejo de Docker. Para ello, si no tiene configurada la opción "sail", utilizar "/vendor/bin/sail"  
```bash
sail up
```
Opcional: Levantar el servicio de Laravel Sail en segundo plano:
```bash
sail up -d
```


Correr las migraciones y seeders:
```bash
sail artisan migrate
sail artisan db:seed
```

Instalar
```bash
sail artisan passport:install --force
```


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

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

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

```
@startuml
:Usuario: --> (Login)
:Usuario: --> (Buscar GIFs)
:Usuario: --> (Buscar GIF por ID)
:Usuario: --> (Guardar GIF favorito)
@enduml
