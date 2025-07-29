# Build l'image de dev
`docker build -t php-apache-dev-env .`
> Commande a lancer depuis **/1_PHP** en racine
# Créer un container
`docker run -d -p 8080:80 -v ${pwd}:/var/www/html --name php-apache-dev-container php-apache-dev-env:latest`
> Commande a lancer depuis **/1_PHP/EXEMEPLE_ET_EP** en racine


# Utiliser le docker-compose pour avoir le même réseau avec mysql sql 
> docker-compose -p learning-env up