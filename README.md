
# API RESTful de Gestión de Productos

Este proyecto es una API desarrollada con Laravel que permite gestionar productos, sus costos asociados y sus precios en diferentes divisas.  
La API ofrece endpoints RESTful para CRUD de productos, gestión de precios y monedas, con interacción mediante Eloquent ORM y documentación Swagger.

---

## 🧾 Descripción del proyecto

La API permite:

- Crear, consultar, actualizar y eliminar productos.
- Asignar precios a productos en distintas divisas.
- Consultar las tasas de cambio (exchange rates).
- Acceso mediante formato JSON.
- Documentación interactiva disponible con Swagger.
- Uso de Eloquent para relaciones entre `products`, `currencies` y `product_prices`.

---

## ✅ Requisitos mínimos

- PHP >= 8.2
- Composer >= 2.x
- Laravel >= 11
- MySQL o PostgreSQL

---

## 🚀 Instalación

```bash
git clone https://github.com/jomiduto/apiProducts.git
cd apiProducts

composer install
cp .env.example .env
php artisan key:generate
```
**Configurar archivo .env**
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=root
DB_PASSWORD=
```
**Ejecutar migraciones e iniciar el servidor**
```bash
php artisan migrate
php artisan serve
```

**Opcional**

Si Swagger no esta instalado, se debe ejecutar el siguiente comando:
```bash
composer require "darkaonline/l5-swagger"
```
---
## 🔍 Endpoints disponibles


|  Método| Ruta |
|--|--|
| GET | /api/products  |
| POST| /api/products  |
| GET | /api/products/{id}  |
| PUT| /api/products/{id}  |
| DELETE| /api/products/{id}  |
| GET | /api/products/{id}/prices |
| POST| /api/products/{id}/prices  |
| GET | /api/currencies  |
| POST| /api/currencies  |
| GET | /api/currencies/{id} |
| PUT| /api/currencies/{id}  |
| DELETE| /api/currencies/{id} |


---
## 📘Documentación Swagger

Documentación disponible en:
```bash
http://localhost:8000/api/documentation
```
Generada automáticamente con el paquete ```bashl5-swagger```.

---
## 🗂️ Importar Colección Postman

- Seleccionar el archivo ```ApiProducts.postman_collection.json```, ubicado en la raíz del proyecto.
- Crear una variable ```base_url``` con el siguiente valor:
```bash
http://localhost:8000/api
```
---
## 🗂️ Importar Colección Insomnia

- Seleccionar el archivo ```Insomnia_2025-06-19.yaml```, ubicado en la raíz del proyecto.
- Crear una variable ```base_url``` con el siguiente valor:
```bash
http://localhost:8000/api
```
---
## 🔒 Seguridad

-   Validaciones estrictas de entrada con `Request::validate()`
-   Control de errores con `try/catch`
-   Estructura lista para integrar autenticación si se requiere
