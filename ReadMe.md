# 🛍️ Proyecto Tienda Online

## 📌 Descripción
Este proyecto es una tienda en línea desarrollada en PHP siguiendo la arquitectura MVC (Modelo-Vista-Controlador). Permite gestionar categorías, productos y usuarios, además de contar con un sistema de autenticación.

---

## 📚 Índice

1. [Estructura del Proyecto](#estructura-del-proyecto)
2. [Descripción de Archivos](#descripción-de-archivos)

---

## 📂 Estructura del Proyecto

La siguiente es la estructura del proyecto y su propósito general:

```
PROYECTOTIENDAFINAL/
│── assets/              # Archivos estáticos como CSS e imágenes
│   ├── css/             # Estilos CSS
│   │   └── styles.css   # Hoja de estilos principal
│   └── img/             # Imágenes del proyecto
│
│── config/              # Archivos de configuración
│   ├── config.php       # Configuración general del proyecto
│   └── DatabaseConfig.php # Configuración de la base de datos
│
│── Controllers/         # Controladores de la aplicación
│   ├── CategoryController.php   # Controlador para las categorías
│   ├── DashboardController.php  # Controlador del dashboard
│   ├── ProductController.php    # Controlador de productos
│   └── UserController.php       # Controlador de usuarios
│
│── database/            # Contiene la base de datos
│   └── SQL.sql          # Script SQL con la estructura de la base de datos
│
│── Lib/                 # Librerías y utilidades
│   └── utils.php        # Funciones de utilidad
│
│── Models/              # Modelos de la aplicación
│   ├── Category.php     # Modelo de categorías
│   ├── Product.php      # Modelo de productos
│   └── User.php         # Modelo de usuarios
│
│── Public/              # Carpeta pública con el punto de entrada
│   └── index.php        # Archivo principal de la aplicación
│
│── Views/               # Vistas de la aplicación
│   ├── category/        # Vistas relacionadas con categorías
│   │   ├── create.php   # Crear una categoría
│   │   ├── edit.php     # Editar una categoría
│   │   └── index.php    # Listar categorías
│   ├── home/            # Vista de inicio
│   │   └── index.php    # Página principal
│   ├── layout/          # Componentes de la interfaz
│   │   ├── footer.php   # Pie de página
│   │   ├── header.php   # Encabezado
│   │   └── sidebar.php  # Barra lateral
│   ├── products/        # Vistas relacionadas con productos
│   │   ├── category.php # Categoría de productos
│   │   ├── create.php   # Crear un producto
│   │   ├── edit.php     # Editar un producto
│   │   └── gestion.php  # Gestión de productos
│   └── user/            # Vistas de usuario
│       ├── edit.php     # Editar usuario
│       ├── login.php    # Página de inicio de sesión
│       └── registro.php # Página de registro de usuario
│
│── vendor/              # Dependencias de Composer
│
│── .env                 # Variables de entorno (credenciales y configuración)
│── .gitignore           # Archivos ignorados en Git
│── composer.json        # Configuración de dependencias PHP
│── composer.lock        # Archivo de bloqueo de dependencias
```

---

## 📝 Descripción de Archivos

### assets/
- **styles.css**: Contiene los estilos generales de la tienda online.
- **img/**: Carpeta donde se almacenan las imágenes de los productos que se suben.

### config/
- **config.php**: Archivo que carga la configuración general del proyecto, incluyendo la conexión a la base de datos.
- **DatabaseConfig.php**: Clase encargada de gestionar la conexión a la base de datos utilizando PDO. Carga las credenciales desde el archivo `.env` y establece la configuración necesaria para la conexión.

### Controllers/
- **CategoryController.php**: Controlador encargado de gestionar las categorías. Permite listar, crear, editar y eliminar categorías, además de verificar permisos de usuario.
- **DashboardController.php**: Controlador que gestiona la página principal del dashboard. Obtiene todas las categorías y selecciona un producto destacado de cada una para mostrarlos en la página de inicio.
- **ProductController.php**: Controlador que maneja la gestión de productos. Permite listar, crear, editar y eliminar productos. También se encarga de la validación de datos y la carga de imágenes asociadas a los productos.
- **UserController.php**: Controlador encargado de gestionar los usuarios. Permite registrar nuevos usuarios, autenticarlos en el sistema y actualizar la información del perfil. También maneja la validación de credenciales y permisos de acceso.

---

### Models/

#### 1. **Category.php**

El modelo `Category` gestiona las categorías de productos en la tienda online.

**Métodos principales:**
- **`save()`**: Guarda una nueva categoría en la base de datos.
- **`update()`**: Actualiza una categoría existente.
- **`delete()`**: Elimina una categoría por su ID.
- **`getAll()`**: Obtiene todas las categorías.
- **`getOneCategory($id)`**: Obtiene una categoría específica por su ID.
- **`checkCategoryExists($nombre)`**: Verifica si una categoría con el mismo nombre ya existe.
- **`checkCategoryExistsExcept($nombre, $id)`**: Comprueba si existe otra categoría con el mismo nombre, excluyendo una ID específica.

---

#### 2. **User.php**

El modelo `User` gestiona los usuarios de la tienda online, incluyendo registro, autenticación y actualización de datos.

**Métodos principales:**
- **`saveDB()`**: Guarda un nuevo usuario en la base de datos.
- **`checkUserExists($email)`**: Verifica si un usuario existe por su email.
- **`login($email, $password, $recuerdame)`**: Autentica a un usuario por su email y contraseña.
- **`getUserById($id)`**: Obtiene un usuario por su ID.
- **`update()`**: Actualiza los datos del usuario en la base de datos.

---

#### 3. **Product.php**

El modelo `Product` gestiona los productos de la tienda online.

**Métodos principales:**
- **`save()`**: Guarda un nuevo producto en la base de datos.
- **`getAll()`**: Obtiene todos los productos.
- **`getOneProduct($id)`**: Obtiene un producto específico por su ID.
- **`update()`**: Actualiza los datos de un producto existente.
- **`delete()`**: Elimina un producto por su ID.
- **`getProductsByCategory($categoria_id)`**: Obtiene todos los productos de una categoría específica.
- **`getCategoryName($categoria_id)`**: Obtiene el nombre de una categoría por su ID.

---

### Public/

#### 1. **index.php**

Archivo principal de la aplicación. Es el punto de entrada para todas las solicitudes.

**Funcionalidades:**
- **Inicio de sesión automático:** Si existe una cookie `remember_me`, se restaura la sesión del usuario correspondiente.
- **Carga de configuración y autoload:** Incluye los archivos `config.php` y `autoload.php` para cargar la configuración y las dependencias.
- **Enrutamiento:** Determina el controlador y la acción a ejecutar basándose en los parámetros de la URL (`controller` y `action`).
  - Si no se especifica un controlador o acción, se usa `DashboardController` y `index` por defecto.
  - Si el controlador o la acción no existen, se redirige al `DashboardController`.
- **Ejecución de la acción:** Llama al método correspondiente del controlador solicitado.

**Flujo de trabajo:**
1. Verifica si hay una sesión activa o una cookie `remember_me` para restaurar la sesión.
2. Carga la configuración y las dependencias.
3. Determina el controlador y la acción a ejecutar.
4. Ejecuta la acción correspondiente o redirige al dashboard si hay errores.

---

### Vendor/

La carpeta `vendor/` contiene las dependencias de Composer y librerías externas utilizadas en el proyecto. No se recomienda modificar manualmente los archivos dentro de esta carpeta, ya que son gestionados automáticamente por Composer.

**Contenido principal:**
- Dependencias de PHP instaladas a través de Composer.
- Autoloader de Composer para cargar clases automáticamente.
- Archivos de configuración y bibliotecas de terceros.

---

### Views/category/

#### 1. **create.php**

Vista para crear una nueva categoría.

**Características:**
- Muestra un formulario para ingresar el nombre de la categoría.
- Valida que el nombre tenga entre 3 y 100 caracteres alfanuméricos.
- Muestra mensajes de error si la creación falla.
- Incluye un enlace para volver a la lista de categorías.

---

#### 2. **edit.php**

Vista para editar una categoría existente.

**Características:**
- Muestra un formulario prellenado con el nombre de la categoría.
- Valida que el nombre tenga entre 3 y 100 caracteres alfanuméricos.
- Muestra mensajes de error si la actualización falla.
- Incluye un enlace para volver a la lista de categorías.

---

#### 3. **index.php**

Vista para gestionar las categorías.

**Características:**
- Muestra una tabla con todas las categorías existentes.
- Permite crear, editar y eliminar categorías (solo para administradores).
- Muestra mensajes de éxito o error después de realizar acciones.
- Incluye confirmación antes de eliminar una categoría.

---

### Views/home/

#### 1. **index.php**

Vista principal de la página de inicio.

**Características:**
- Muestra mensajes de éxito o error relacionados con el registro de usuarios.
- Incluye una sección de productos destacados.
- Utiliza el archivo `sidebar.php` para mostrar opciones de usuario (inicio de sesión, cierre de sesión, edición de perfil, etc.).
- Muestra una lista de productos con su imagen, nombre y precio.
- Si el usuario está autenticado, muestra un botón "Comprar" para cada producto.

---

### Views/layout/

#### 1. **footer.php**

Pie de página común para todas las vistas.

**Características:**
- Muestra un mensaje de derechos de autor con el año actual.
- Cierra las etiquetas `<body>` y `<html>`.

---

#### 2. **header.php**

Cabecera común para todas las vistas.

**Características:**
- Define la estructura básica del documento HTML (DOCTYPE, metadatos, enlace a estilos CSS).
- Muestra el logotipo de la tienda y un enlace a la página de inicio.
- Incluye un menú de navegación con categorías de productos y enlaces de usuario (registro e inicio de sesión).

---

#### 3. **sidebar.php**

Barra lateral común para todas las vistas.

**Características:**
- Muestra un mensaje de bienvenida si el usuario está autenticado.
- Incluye enlaces para cerrar sesión y editar el perfil.
- Si el usuario es administrador, muestra enlaces adicionales para gestionar categorías y productos.
- Si el usuario no está autenticado, muestra un mensaje indicando que no se ha identificado.

---

### Views/products/

#### 1. **category.php**

Vista que muestra los productos de una categoría específica.

**Características:**
- Muestra mensajes de éxito o error relacionados con la gestión de productos.
- Incluye el nombre de la categoría en el título.
- Utiliza el archivo `sidebar.php` para mostrar opciones de usuario.
- Muestra una lista de productos con su imagen, nombre y precio.
- Si el usuario está autenticado, muestra un botón "Comprar" para cada producto.
- Si no hay productos en la categoría, muestra un mensaje indicando que no hay productos disponibles.

---

#### 2. **create.php**

Vista para crear un nuevo producto.

**Características:**
- Muestra un formulario para ingresar los detalles del producto (nombre, descripción, precio, stock, categoría e imagen).
- Valida que los campos cumplan con los requisitos mínimos (longitud, tipo de dato, etc.).
- Muestra mensajes de error si la creación falla.
- Incluye un enlace para volver a la lista de productos.

---

#### 3. **edit.php**

Vista para editar un producto existente.

**Características:**
- Muestra un formulario prellenado con los datos actuales del producto.
- Permite cambiar la imagen del producto (opcional).
- Valida que los campos cumplan con los requisitos mínimos.
- Muestra mensajes de error si la actualización falla.
- Incluye un enlace para volver a la lista de productos.

---

#### 4. **gestion.php**

Vista para gestionar los productos (solo para administradores).

**Características:**
- Muestra una tabla con todos los productos existentes (ID, nombre, precio, stock).
- Permite crear, editar y eliminar productos.
- Muestra mensajes de éxito o error después de realizar acciones.
- Incluye confirmación antes de eliminar un producto.
- Si no hay productos, muestra un mensaje indicando que no hay productos disponibles.

---

### Views/user/

#### 1. **edit.php**

Vista para editar el perfil del usuario.

**Características:**
- Muestra un formulario prellenado con los datos actuales del usuario (nombre, apellidos, email).
- Permite actualizar la contraseña (opcional).
- Si el usuario es administrador, permite cambiar el rol (usuario o administrador).
- Muestra mensajes de éxito o error después de la actualización.
- Incluye un enlace para volver a la página de inicio.

---

#### 2. **login.php**

Vista para iniciar sesión.

**Características:**
- Muestra un formulario para ingresar el email y la contraseña.
- Incluye una opción "Recuérdame" para mantener la sesión activa mediante cookies.
- Muestra mensajes de error si el inicio de sesión falla.
- Incluye un enlace para registrarse si el usuario no tiene una cuenta.

---

#### 3. **registro.php**

Vista para registrar un nuevo usuario.

**Características:**
- Muestra un formulario para ingresar los datos del usuario (nombre, apellidos, email y contraseña).
- Valida que los campos estén completos.
- Muestra mensajes de error si el registro falla.
- Incluye un enlace para iniciar sesión si el usuario ya tiene una cuenta.

---

### Configuración y Dependencias

#### 1. **.env**

Archivo de configuración para variables de entorno.

**Contenido:**
- **DBHOST**: Host de la base de datos (por ejemplo, `localhost`).
- **DBNAME**: Nombre de la base de datos (por ejemplo, `tienda`).
- **DBUSER**: Usuario de la base de datos (por ejemplo, `root`).
- **DBPASSWORD**: Contraseña de la base de datos (dejado en blanco si no hay contraseña).

**Uso:**
- Este archivo se utiliza para almacenar credenciales y configuraciones sensibles fuera del código fuente.

---

#### 2. **.gitignore**

Archivo que especifica qué archivos y directorios deben ser ignorados por Git.

**Contenido:**
- Ignora el archivo `.env` para evitar que se suban credenciales al repositorio.
- Ignora la carpeta `vendor/` para evitar subir dependencias de Composer.

**Uso:**
- Asegura que archivos sensibles y dependencias no se incluyan en el control de versiones.

---

#### 3. **composer.json**

Archivo de configuración de Composer para gestionar dependencias y autoloading.

**Contenido:**
- **name**: Nombre del proyecto (`usuario/proyecto-tienda-final`).
- **description**: Descripción del proyecto.
- **type**: Tipo de proyecto (`project`).
- **require**: Dependencias requeridas (por ejemplo, `vlucas/phpdotenv` para manejar variables de entorno).
- **autoload**: Configuración de autoloading para cargar clases automáticamente.
  - **psr-4**: Define los namespaces y sus rutas correspondientes (`Controllers\\`, `Models\\`, etc.).

**Uso:**
- Gestiona las dependencias del proyecto y configura el autoloading para cargar clases automáticamente.

---