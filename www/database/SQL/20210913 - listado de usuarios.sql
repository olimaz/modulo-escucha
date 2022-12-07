select u.username, u.email, u.name, i.descripcion as perfil, c.descripcion as area
from users u
         join esclarecimiento.entrevistador e on u.id = e.id_usuario
         join catalogos.criterio_fijo i on e.id_nivel=i.id_opcion and i.id_grupo=4
         join catalogos.cev c on e.id_territorio = c.id_geo
order by u.name, u.username;
