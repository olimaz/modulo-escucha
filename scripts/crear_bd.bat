cat www/database/crear_bd.sql | docker exec -i me-db psql -U dba
cat www/database/entrevistas.sql | docker exec -i me-db psql -U dba entrevistas
