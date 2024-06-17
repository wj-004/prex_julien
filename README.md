# Challenge PREX Julien Wolin

## Acerca del proyecto
El presente proyecto consiste en una API REST que consume un servicio de terceros ( [GIPHY](https://www.giphy.com/) ) e implementa los siguientes servicios:
- Login
- Buscar GIFS   
- Buscar GIF por ID
- Guardar GIF favorito

Además, proporciona la documentación necesaria para la instalación, preparación de datos de prueba y comprensión del funcionamiento del sistema.

## Tecnologías empleadas

- [PHP 8.2](https://www.php.net/downloads.php#v8.2.10).
- [Laravel 10](https://laravel.com/).
- [MySQL](https://www.mysql.com/).
- [UML](https://www.uml.org/).
- [Docker](https://www.docker.com/).



## Guía de Instalación y Configuración


### 1. Clonar el repositorio:
```bash
git clone https://github.com/wj-004/prex_julien.git
cd prex_julien
```

### 2. Instalar las dependencias del proyecto:
```bash
composer install
```

### 3. Crear el archivo .env del proyecto a partir del archivo de ejemplo .env.example.
```bash
cp .env.example .env
```

### 4. Configurar las variables de entorno:
- GIPHY_API_KEY: necesaria para consumir los servicios de GIPHY 
- PASSPORT_TOKEN_EXPIRATION: Establece el tiempo de expiración del token (en minutos).
- PASSPORT_REFRESH_TOKEN_EXPIRATION: Establece cada cuantos días expira el refresh token.
```bash
GIPHY_API_KEY
PASSPORT_TOKEN_EXPIRATION
PASSPORT_REFRESH_TOKEN_EXPIRATION
``` 


### 5. Iniciar el servicio de Laravel Sail:  
Utilizar el paquete oficial Laravel Sail para manejo de Docker. Si no tiene configurada la opción "sail" utilizar "./vendor/bin/sail"  
```bash
sail up
```
* Opcional: Levantar el servicio de Laravel Sail en segundo plano:
```bash
sail up -d
```

### 6. Generar la Clave de la Aplicación:
```bash
sail artisan key:generate
```


### 7. Ejecutar las Migraciones y Seeders:
```bash
sail artisan migrate --seed
```

### 8. Instalar y configurar Passport
```bash
sail artisan passport:install
```



## Uso de la API REST  
### Endpoints de Servicios GIF

| Método | Endpoint                 | Descripción           
|--------|--------------------------|----------------------
| POST   |  /api/gifs/search        | Buscar GIFs           
| GET    |  /api/gifs/get-by-id/{id}| Buscar GIF por ID
| POST   |  /api/gifs/add-bookmark  | Guardar GIF favorito  


### Endpoints de Autenticación

| Método | Endpoint                 | Descripción           
|--------|--------------------------|----------------------
| POST   |  /api/register           | Registro de usuario           
| POST   |  /api/login              | Inicio de sesión
| POST   |  /api/logout             | Terminar sesión  



<hr>

## Documentación de Servicios


## Casos de Uso
<img src="./zzz_documents/casos_de_uso.png"/>



### Buscar GIFs

|ENDPOINT: | /api/gifs/search |
|-|-|

|ENTRADA:|
|-|

|Parámetro	| Tipo	    |Descripción	        | Requerido |
|-----------|-----------|-----------------------|-----------|
|QUERY	    |cadena	    | Filtro de consulta	| Sí
|LIMIT	    |numérico	| Límite de resultados	| No
|OFFSET	    |numérico	| Desplazamiento	    | No

|SALIDA:|
|-|

| Tipo      |	Descripción                 |
|-----------|-------------------------------|
| Colección |	Resultados de la búsqueda   |

|Diagrama de Secuencia:|
|-|

```mermaid
    
    sequenceDiagram
        participant User
        participant API
        participant AuthController
        participant GifController
        participant GifService
        participant GiphyAPI

        User->>API: Enter search query
        API->>AuthController: Send request with token (POST /gifs/search)
        AuthController->>GifController: Authenticate and forward request
        GifController->>GifService: Call searchGif with query
        GifService->>GiphyAPI: Send request to Giphy API
        GiphyAPI-->>GifService: Return GIF data
        GifService->>GifService: Create ResponseDTO
        GifService->>GifService: Dispatch GifSearchPerformed event
        alt GIFs found
            GifService-->>GifController: Return search results
            GifController-->>AuthController: Return search results
            AuthController-->>API: Return search results
            API-->>User: Display search results
        else No GIFs found
            GifService-->>GifController: Return "No results"
            GifController-->>AuthController: Return "No results"
            AuthController-->>API: Return "No results"
            API-->>User: Display "No results"
        end
        alt Error in search
            GifService-->>GifController: Return error message
            GifController-->>AuthController: Return error message
            AuthController-->>API: Return error message
            API-->>User: Display error message
        end


```
<hr>

### Buscar GIF por ID

|ENDPOINT: | /api/gifs/get-by-id/{id} |
|-|-|

|ENTRADA:|
|-|

|Parámetro	| Tipo	    |Descripción	        | Requerido |
|-----------|-----------|-----------------------|-----------|
|ID	        |cadena	    | Identificador del GIF	| Sí        |

|SALIDA:|
|-|

| Tipo      |	Descripción                 |
|-----------|-------------------------------|
| Colección |	Datos del recurso consultado|

|Diagrama de Secuencia:|
|-|

```mermaid
    
    sequenceDiagram
        participant User
        participant API
        participant GifController
        participant GifService
        participant GiphyAPI

        User->>API: Send request to get GIF by ID (GET /gifs/get-by-id/{id})
        API->>GifController: Forward request
        GifController->>GifService: Call getById with ID
        alt ID is empty
            GifService-->>GifController: Return "ID is required" error
            GifController-->>API: Return "ID is required" error
            API-->>User: Return "ID is required" error
        else ID is valid
            GifService->>GiphyAPI: Send request to Giphy API with ID
            GiphyAPI-->>GifService: Return GIF data
            GifService->>GifService: Create GifResponseDTO
            GifService->>GifService: Dispatch GifGetByIdPerformed event
            alt GIF found
                GifService-->>GifController: Return GIF data
                GifController-->>API: Return GIF data
                API-->>User: Return GIF data
            else Error or GIF not found
                GifService-->>GifController: Return error message
                GifController-->>API: Return error message
                API-->>User: Return error message
            end
        end
```

<hr>



### Guardar GIF Favorito

|ENDPOINT: | /api/gifs/add-bookmark |
|-|-|

|ENTRADA:|
|-|

|Parámetro	| Tipo	    |Descripción	            | Requerido |
|-----------|-----------|---------------------------|-----------|
| GIF_ID    | cadena    | Identificador del GIF	    | Sí        |
| ALIAS	    | cadena	| Alias del GIF	            | Sí        |
| USER_ID	| numérico	| Identificador del usuario | Sí        |

|SALIDA:|
|-|

| Tipo      |	Descripción                       |
|-----------|-------------------------------------|
| Datos     |	Confirmación de guardado exitoso  |

|Diagrama de Secuencia:|
|-|

```mermaid
    
    sequenceDiagram
        participant User
        participant API
        participant AuthController
        participant GifController
        participant GifService

        User->>API: Enter user_id, gif_id, alias
        API->>AuthController: Send request with token (POST /gifs/add-bookmark)
        AuthController->>GifController: Authenticate and forward request
        GifController->>GifService: Call addBookmark with query

        GifService->>DB: create

        GifService->>GifService: Create ResponseDTO
        GifService->>GifService: Dispatch GifBookmarked event
        
        GifService-->>GifController: Return search results
        GifController-->>AuthController: Return search results
        AuthController-->>API: Return search results
        API-->>User: Display search results
        
```
<hr>



### Servicios de Log
El proyecto hace uso de Events y Listeners para registrar toda la interacción con los servicios de la API.

|Diagrama de Secuencia:|
|-|

```mermaid

    sequenceDiagram
    
    participant GifService
    participant GifSearchPerformed
    participant LogGifBase


    GifService->>GifService: Create GifResponseDTO
    GifService->>GifSearchPerformed: Dispatch GifSearchPerformed event
    GifSearchPerformed->>LogGifBase: Handle event
    LogGifBase->>GifApiRequest: Log request and response data

```

<hr>


### Secuencia completa Search con log:

```mermaid

    sequenceDiagram
    participant User
    participant API
    participant GifController
    participant GifService
    participant GiphyAPI
    participant GifSearchPerformed
    participant LogGifBase

    User->>API: Send search request for GIFs (POST /gifs/search)
    API->>GifController: Forward request
    GifController->>GifService: Call searchGif with request
    GifService->>GiphyAPI: Send request to Giphy API
    GiphyAPI-->>GifService: Return GIF search results
    GifService->>GifService: Create GifResponseDTO
    GifService->>GifSearchPerformed: Dispatch GifSearchPerformed event
    GifSearchPerformed->>LogGifBase: Handle event
    LogGifBase->>DB: create GifApiRequest
    alt GIFs found
        GifService-->>GifController: Return GIF search results
        GifController-->>API: Return GIF search results
        API-->>User: Return GIF search results
    else No GIFs found
        GifService-->>GifController: Return "No results" message
        GifController-->>API: Return "No results" message
        API-->>User: Return "No results" message
    end
    

```

### Secuencia completa GetById con log:
```mermaid

    sequenceDiagram
        participant User
        participant API
        participant GifController
        participant GifService
        participant GiphyAPI
        participant GifGetByIdPerformed
        participant LogGifBase

        User->>API: Send request to get GIF by ID (GET /gifs/get-by-id/{id})
        API->>GifController: Forward request
        GifController->>GifService: Call getById with ID
        alt ID is empty
            GifService-->>GifController: Return "ID is required" error
            GifController-->>API: Return "ID is required" error
            API-->>User: Return "ID is required" error
        else ID is valid
            GifService->>GiphyAPI: Send request to Giphy API with ID
            GiphyAPI-->>GifService: Return GIF data
            GifService->>GifService: Create GifResponseDTO
            GifService->>GifGetByIdPerformed: Dispatch GifGetByIdPerformed event
            GifGetByIdPerformed->>LogGifBase: Handle event
            LogGifBase->>DB: create GifApiRequest
            alt GIF found
                GifService-->>GifController: Return GIF data
                GifController-->>API: Return GIF data
                API-->>User: Return GIF data
            else Error or GIF not found
                GifService-->>GifController: Return error message
                GifController-->>API: Return error message
                API-->>User: Return error message
            end
        end
```

<hr>


### Registrar Usuario

|ENDPOINT: | /api/register |
|-|-|

|ENTRADA:|
|-|

|Parámetro	| Tipo	    |Descripción	            | Requerido |
|-----------|-----------|---------------------------|-----------|
| name      | cadena    | Nombre de usuario 	    | Sí        |
| email	    | cadena	| Correo electrónico        | Sí        |
| password	| cadena	| Contraseña                | Sí        |
| password	| cadena	| Contraseña                | Sí        |

|SALIDA:|
|-|

| Tipo      |	Descripción                       |
|-----------|-------------------------------------|
| Datos     |	Confirmación de registro exitoso  |

|Diagrama de Secuencia:|
|-|

```mermaid
    sequenceDiagram
        participant Controller
        participant Request
        participant User
        participant Hash
        participant Validation
        participant Response

        Controller->>+Request: register(Request request)

        alt Validation Successful
            Request-->>Controller: Data validated
            Controller->>+User: User::create(array data)
            User-->>Controller: User created
            Controller->>+Hash: Hash::make(string password)
            Hash-->>Controller: Encrypted password
            Controller->>+Controller: jsonResponse(true, "User created successfully.")
            Controller-->>-Response: JsonResponse
        else Validation Failed
            Request-->>Controller: Invalid data
            Controller->>+Controller: jsonResponse(false, "Error creating user.", array data)
            Controller-->>-Response: JsonResponse
        end
```

<hr>


### Login

|ENDPOINT: | /api/login |
|-|-|

|ENTRADA:|
|-|

|Parámetro	| Tipo	    |Descripción	        | Requerido |
|-----------|-----------|-----------------------|-----------|
| email     | cadena    | Email de usurio	    | Sí        |
| password  | cadena	| Contraseña del usuario| Sí        |

|SALIDA:|
|-|

| Tipo      |	Descripción                       |
|-----------|-------------------------------------|
| Datos     |	Confirmación de ingreso           |
| Datos     |	Token de ingreso                  |


|Diagrama de Secuencia:|
|-|

```mermaid
sequenceDiagram
    participant Controller
    participant Request
    participant Passport
    participant Response
    Controller->>+Request: login(Request request)
    Request-->>-Controller: Data received
    Controller->>+Request: validate(request)
    alt Validation Successful
        Request-->>-Controller: Data validated
        Controller->>+Passport: Passport::attempt(array credentials)
        alt Valid Token
            Passport-->>-Controller: Token generated
            Controller->>+Controller: jsonResponse(true, "User logged successfully.", array data)
            Controller-->>-Response: JsonResponse
        else Invalid Token
            Controller->>+Controller: jsonResponse(false, "Invalid login details.")
            Controller-->>-Response: JsonResponse
        end
    else Validation Failed
        Controller->>+Controller: jsonResponse(false, "Error logging in.", array data)
        Controller-->>-Response: JsonResponse
    end
    
```

<hr>

### Logout

|ENDPOINT: | /api/logout |
|-|-|


|SALIDA:|
|-|

| Tipo      |	Descripción                       |
|-----------|-------------------------------------|
| Datos     |	Confirmación de sesión terminada  |

|Diagrama de Secuencia:|
|-|

```mermaid
    sequenceDiagram
        participant User
        participant API
        participant AuthController
        participant Passport

        User->>API: Request to logout (GET /logout)
        API->>AuthController: Send logout request
        AuthController->>Passport: Revoke user's token
        Passport-->>AuthController: Token revoked
        AuthController->>API: Return success response
        API-->>User: Receive success response, log out completed
```
<hr>



## Diagrama Entidad Relación
<img src="./zzz_documents/DER.png"/>



## Apagar el Entorno
Para apagar el entorno de desarrollo, ejecuta:
```bash
sail down
```

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>



