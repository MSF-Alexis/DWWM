# Build l'image de dev
## Commande a lancer depuis **/2_MYSQL** en racine
> docker build -t mysql-dev-env .
# Créer un container
> docker run -d `
  --name mysql-dev-container `
  -p 3306:3306 `
  -v slip2bain:/var/lib/mysql `
  -e MYSQL_ROOT_PASSWORD=secret `
  -e MYSQL_DATABASE=database `
  -e MYSQL_USER=user_1 `
  -e MYSQL_PASSWORD=secret_1 `
  mysql:9.2.0

docker run -d `
 --name mariadb-dev-container `
 -p 3306:3306 `
 -v mariadb-env-volume:/var/lib/mysql `
 -e MARIADB_ROOT_PASSWORD=my-secret-pw `
 -e MARIADB_DATABASE=main-database `
 mariadb:latest