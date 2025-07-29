#!/bin/bash
DATE=$(date +%F)
DB="masolutionformation"
USER="root"
PASSWORD="my-secret-pw"
BACKUP_DIR="/backup"
mariadb-dump --user=$USER --password=$PASSWORD $DB > $BACKUP_DIR/${DB}_$DATE.sql