# **Conservación preventiva de edificios de bibliotecas basados en el clima interior**
## Instalación previa de:
* `php`
* `mysql`
* `apache2` o `nginx`
* `jpegoptim`
* `optipng`
* `node`
## Clonar el repositorio
* SSH
```bash
git clone git@github.com:MeAgPaWeb/cpebbci.git
```
* HTTPS
```bash
git clone https://github.com/MeAgPaWeb/cpebbci.git
```
## Preparar el proyecto
* Entrar al directorio y dar permisos a cache, logs y sessions
```bash
cd cpebbci
bash # El siguiente filtro corre en bash
HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d" " -f1`
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var

```
* Instalar las dependencias, también en este punto se configura el `parameter.yml`
```bash
composer update
```
* Crear la base de datos y crear las tablas respectivamente
```bash
php bin/console doctrine:database:create
php bin/console doctrine:schema:create
```
* Compila y aplica filtros de `javascript` y `css`
```bash
php bin/console assetic:dump
```
* Arrancar el servidor
```bash
php bin/console server:start
```
