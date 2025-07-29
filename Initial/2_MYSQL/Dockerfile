FROM mysql:9.2.0

# Configurations obligatoires (surchargeables à l'exécution)
ENV MYSQL_ROOT_PASSWORD=defaultrootpass \
    MYSQL_DATABASE=defaultdb \
    MYSQL_USER=defaultuser \
    MYSQL_PASSWORD=defaultpass
# Configuration MySQL
# COPY DOCKER_CONF/my.cnf /etc/mysql/conf.d/
# COPY DOCKER_CONF/init.sql /docker-entrypoint-initdb.d/

# Nettoyage
RUN rm -rf /var/lib/mysql/test

# Santé
HEALTHCHECK --interval=30s --timeout=10s --retries=3 \
  CMD mysqladmin ping -uroot -p${MYSQL_ROOT_PASSWORD} || exit 1

# Ports et volumes
EXPOSE 3306
VOLUME /var/lib/mysql

# Permissions
RUN chown -R mysql:mysql /docker-entrypoint-initdb.d