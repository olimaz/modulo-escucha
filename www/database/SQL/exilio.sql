insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (1,13,'Internacional','ii');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (2,14,'ALEMANIA','ii001');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (2,14,'BELGICA','ii002');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (2,14,'DINAMARCA','ii003');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (2,14,'ESPAÑA','ii004');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (2,14,'FRANCIA','ii005');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (2,14,'','');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (2,14,'GRAN BRETAÑA ','ii006');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (2,14,'HOLANDA','ii007');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (2,14,'ITALIA','ii008');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (2,14,'NORUEGA','ii009');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (2,14,'SUECIA','ii010');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (2,14,'SUIZA','ii011');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'BERLIN','ii001001');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'BRUSELAS','ii002001');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'COPENAGUE','ii003001');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'ALBACETE','ii004001');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'ALICANTE','ii004002');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'BARCELONA','ii004003');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'BILBAO','ii004004');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'GIJON','ii004005');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'MADRID','ii004006');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'VALENCIA','ii004007');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'VALLADOLID','ii004008');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'GAILLAC','ii005001');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'TOLOUSE','ii005002');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'LYON','ii005003');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'IRLANDA','ii006001');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'LONDRES','ii006002');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'Todo el país','ii007001');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'Todo el país','ii008001');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'Todo el país','ii009001');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'Todo el país','ii010001');
insert into catalogos.geo(nivel, id_tipo, descripcion, codigo) values (3,6,'Todo el país','ii011001');

update catalogos.geo
set id_padre = p.id_geo
from catalogos.geo p
where
substr(p.codigo,1,2)=substr(geo.codigo,1,2)
and geo.nivel=2 and p.nivel=1 and geo.id_padre is null;

update catalogos.geo
set id_padre = p.id_geo
from catalogos.geo p
where
substr(p.codigo,1,5)=substr(geo.codigo,1,5)
and geo.nivel=3 and p.nivel=2 and geo.id_padre is null;

select * from catalogos.geo where codigo like 'ii%'