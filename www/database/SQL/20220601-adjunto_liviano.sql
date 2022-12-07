
alter table esclarecimiento.adjunto
    add liviano_ubicacion varchar(200);

alter table esclarecimiento.adjunto
    add liviano_tamano bigint;

alter table esclarecimiento.adjunto
    add liviano_md5 varchar(100);


update esclarecimiento.adjunto a
set liviano_ubicacion=l.archivo_liviano_nombre
  , liviano_tamano=l.archivo_liviano_tamano
  , liviano_md5 = l.archivo_liviano_md5
from
    sim.legado l
where l.id_adjunto=a.id_adjunto;
