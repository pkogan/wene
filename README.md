# Fork Wene - UNCOMA

## Instalación
Se deja disponible un archivo `.env.example` a modo de ejemplo para utilizar en la instalación.

Si usted quisiera modificar o agregar algún servicio de `docker-compose.yml` sin afectar el repositorio puede hacerlo mediante el uso de `docker-compose.override.yml` está ignorado por defecto.

### Instalar paquetes
Una vez ejecutandose el ambiente, puede ingresar al servicio `php`:
```sh
docker compose exec php bash

# Ejecutar
composer install
```

### Crear carpetas
Crear las carpetas en la raiz del proyecto:
  - `tmp`
  - `archivos/adjuntos`
  - `archivos/certificados`

De no crearlas puede visualizarse errores como: `session_start(): open(....) failed: No such file or directory`.

Es posible que también haya que reparar los permisos, puede ingresar al contenedor y repararlos:
```
chown -R www-data:www-data .
```

### Consideraciones de la base de datos
En cuanto a la base de datos, existen dos dumps:
1. `bd/wenelimpia.sql`: está más completa sin embargo tiene un problema de un bug que poseía la versión de phpmyadmin para exportar el tipo de dato `point` (debía exportarlo como hexadecimal).
2. `dump/wene.sql`: al contrario de la primera, no falla la importación, tiene menos información según lo analizado. Nos tomamos el atrevimiento de agregar el campo `point` (que si existe en el otro dump) para la tabla `dependencias`. Las lineas  agregadas son las siguientes
```sql
ALTER TABLE `dependencia` 
ADD `port` INT NULL DEFAULT NULL AFTER `smtp`, 
ADD `protocol` VARCHAR(10) NULL DEFAULT NULL AFTER `port`;
```

Por defecto dejamos que el motor de base de datos importe el dump que está en el repositorio oficial, en el archivo `docker-compose.yml` puede encontrar la linea que define esto:
```yml
    volumes:
        - ./dump:/docker-entrypoint-initdb.d
```

## Resumen
En muy pocas palabras, el usuario `admin` puede crear dependencias que es una forma de englobar a una sede u organización que emitirá los certificados. Estas están "gestionadas" por usuarios como `gestor` que poseen la capacidad de crear certificados, registrar personas y asociar dichas personas a los certificados. Hay dos roles más `hacedor` y `certificante` (falta completar).

### Sobre los templates (diseños de certificados)
En cuanto a los `templates`, es posible crear nuevos, los mismos se encuentran en `views/certificado/template`. Esto permite personalizar certificados. 

Además de crearlos en el `CRUD /template` se deben asociar a la dependencia para poder utilizarlos. Si te estás preguntando cómo hacerlo, vas al listado de dependencias, haces click en el ícono del ojo (`dependencias/view?id=<id>`) y en el view de esa dependencia hay un botón de `Agregar Template`.

## Acceso por defecto
En el dump vienen 2 usarios cargados, `admin` y `gestor`. La contraseña es la misma que el usuario.
