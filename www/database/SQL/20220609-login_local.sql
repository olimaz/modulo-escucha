-- por si acaso
delete from catalogos.criterio_fijo where id_grupo=400;
delete from catalogos.criterio_fijo_grupo where id_grupo=400;

-- Nuevos permisos
insert into catalogos.criterio_fijo_grupo(id_grupo, descripcion)
values (400,'Roles de version liviana');

insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(400,1,'Administrador');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(400,101,'1. Público');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(400,102,'2. Público Clasificado');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(400,103,'3. Público Reservado');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(400,99,'Sin perfil - Deshabilitado');

-- Clave '123' para sim@comisiondelaverdad.co
update users set password='$2y$10$moMqRhJH8a7PqbdV9Fi/bOdG0sQtB3gICJyHfSgar2.9.3KxYmDU2' where id=2;

-- Para diferenciar los nuevos usuarios
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion) values (5,25,'Usuarios de autenticacion local');