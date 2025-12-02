# API REST de Notas Personales

## Descripción

Esta es una API REST simple y ligera, desarrollada con PHP nativo y MySQL, para gestionar una aplicación de "Notas Personales". No utiliza ningún framework, lo que la hace ideal para fines educativos y para entornos donde se requiere un despliegue rápido y con mínimas dependencias.

La API soporta operaciones CRUD completas (Crear, Leer, Actualizar, Borrar) para las notas.

## Cómo Instalar y Ejecutar en XAMPP

Sigue estos pasos para poner en marcha la API en tu entorno local con XAMPP.

### Prerrequisitos

- **XAMPP** instalado (que incluye Apache y MySQL). [Descargar XAMPP](https://www.apachefriends.org/index.html)

### Pasos de Instalación

1.  **Inicia los servicios de XAMPP:** Abre el panel de control de XAMPP y asegúrate de que los módulos de **Apache** y **MySQL** estén en ejecución.

2.  **Crea la Base de Datos:**
    -   Abre tu navegador y ve a `http://localhost/phpmyadmin/`.
    -   Haz clic en la pestaña **"SQL"**.
    -   Copia el contenido completo del archivo `database.sql` y pégalo en el cuadro de texto.
    -   Haz clic en el botón **"Continuar"** (Go). Esto creará la base de datos `notes_app`, la tabla `notes` y añadirá 3 registros de ejemplo.

3.  **Copia los Archivos del Proyecto:**
    -   Navega hasta el directorio `htdocs` dentro de tu instalación de XAMPP (ej: `C:/xampp/htdocs/`).
    -   Crea una nueva carpeta para el proyecto, por ejemplo, `api-notas`.
    -   Copia los archivos `api.php`, `db.php` y el nuevo `index.html` dentro de esta carpeta (`htdocs/api-notas/`).

4.  **¡Listo!** El proyecto ya está completamente operativo.
    -   Para usar la **API** directamente, la URL base es: `http://localhost/api-notas/api.php`.
    -   Para usar la **interfaz gráfica**, abre en tu navegador la URL: `http://localhost/api-notas/index.html`.

---

## Interfaz de Usuario

El archivo `index.html` proporciona una interfaz gráfica simple para interactuar con la API de forma visual. Permite ver, crear, editar y eliminar notas sin necesidad de usar herramientas como `curl` o Postman.

Simplemente abre `http://localhost/api-notas/index.html` en tu navegador para empezar a usarla.

## Endpoints de la API

Aquí tienes ejemplos de cómo interactuar con cada endpoint usando `curl`.

### 1. Obtener todas las notas

-   **Método:** `GET`
-   **Endpoint:** `/api.php`

```bash
curl http://localhost/api-notas/api.php
```

### 2. Obtener una nota por su ID

-   **Método:** `GET`
-   **Endpoint:** `/api.php?id={ID}`

Ejemplo para obtener la nota con `id=1`:
```bash
curl http://localhost/api-notas/api.php?id=1
```

### 3. Crear una nueva nota

-   **Método:** `POST`
-   **Endpoint:** `/api.php`
-   **Body (JSON):**

```bash
curl -X POST http://localhost/api-notas/api.php \
-H "Content-Type: application/json" \
-d '{
    "title": "Nuevo Libro para Leer",
    "author": "Carlos Ruiz",
    "body": "Comprar el libro 'La Sombra del Viento'.",
    "classification": "personal"
}'
```

### 4. Actualizar una nota existente

-   **Método:** `PUT`
-   **Endpoint:** `/api.php?id={ID}`
-   **Body (JSON):**

Ejemplo para actualizar la nota con `id=2`:
```bash
curl -X PUT http://localhost/api-notas/api.php?id=2 \
-H "Content-Type: application/json" \
-d '{
    "title": "Lista de la compra semanal",
    "author": "Ana Gómez",
    "body": "Leche, huevos, pan, aguacates y pollo.",
    "classification": "home"
}'
```

### 5. Eliminar una nota

-   **Método:** `DELETE`
-   **Endpoint:** `/api.php?id={ID}`

Ejemplo para eliminar la nota con `id=3`:
```bash
curl -X DELETE http://localhost/api-notas/api.php?id=3
```
# actividad-14
