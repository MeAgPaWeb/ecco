# **Conservación preventiva de edificios de bibliotecas basados en el clima interior**
## 1. Objetivo del proyecto: 
Desarrollar una aplicación que gestione usuarios, bibliotecas y salas (pertenecientes a una biblioteca), permitiendo que un usuario registrado pueda conocer cuál es el clima ideal de una sala basado en la condición previa a la cual los materiales de dicha sala se aclimataron. Esta información previa se obtiene a través de dataloggers que registran durante cierto tiempo la temperatura y humedad de la sala en cuestión.

## 2. User Stories desarrolladas:
*    I. Como usuario de una biblioteca monitorizada que aún no ha sido incorporada a sistema (nuevo usuario) deseo registrarme como usuario del sistema, para poder registrar los datos de mi biblioteca.

*    II. Como nuevo usuario deseo registrar la biblioteca en el sistema para poder luego conocer los datos del clima que se desprendan del análisis que realiza el sistema.

*    III. Como usuario registrado deseo visualizar para una sala con datos cargados:
        ** A. Media móvil
        ** B. Objetivo climático

*    IV.  Como usuario de una biblioteca registrada en el sistema deseo registrarme como usuario autorizado a acceder a los datos de una biblioteca.

## 3. Modelo de diseño en UML:
![alt text](https://github.com/MeAgPaWeb/ecco/blob/master/modelo/Modelo.png)

## 4. Tecnologías usadas en el desarrollo y consideraciones de implementación importantes:
* `Symfony3.4`
* `Doctrine`
* `jQuery`
* `PHP`
* `MySQL`
* `[ Nginx | Apache2 ]`
* `Bootstrap`
* `AdminLTE`
* `Highchart`
* `Jpegoptim`
* `Optipng`
* `Node`

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
