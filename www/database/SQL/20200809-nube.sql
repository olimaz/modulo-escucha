INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable", "otro_cual") VALUES (333, 'Nube de palabras: terminos a ignorar', 'Utilizado en la nube de palabras', 1, DEFAULT);
delete from catalogos.cat_item where id_cat=333;
insert into catalogos.cat_item(id_cat, descripcion) values
(333,'a'),(333,'ante'),(333,'bajo'),(333,'cabe'),(333,'con'),(333,'contra'),(333,'de'),(333,'desde'),(333,'en'),(333,'entre'),(333,'hacia'),(333,'hasta'),(333,'mediante'),(333,'para'),(333,'por'),(333,'según'),(333,'sin'),(333,'so'),(333,'tras'),(333,'durante'),(333,'vía'),(333,'versus'),(333,'y'),(333,'o'),(333,'ENT'),(333,'TEST');

insert into catalogos.cat_item(id_cat, descripcion) values
(333,'que'),(333,'el'),(333,'la'),(333,'los'),(333,'las'),(333,'un'),(333,'uno'),(333,'unas'),(333,'unos');