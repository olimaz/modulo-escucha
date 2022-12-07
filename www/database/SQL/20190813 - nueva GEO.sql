-- Crear las tablas
create table catalogos.geo_nueva
(
    id_geo_nueva serial            not null
        constraint geo_nueva_pk
            primary key,
    id_padre     integer,
    nivel        integer default 0 not null,
    descripcion  varchar(100)      not null,
    id_tipo      integer,
    codigo       varchar(10),
    lat          double precision,
    lon          double precision
);

comment on table catalogos.geo_nueva is 'Catálogo geográfico multinivel, nueva version';

alter table catalogos.geo_nueva
    owner to dba;


-- equivalencias
create table catalogos.geo_equivalencia
(
    id              serial      not null
        constraint geo_equivalencia_pkey
            primary key,
    codigo_original varchar(20) not null,
    codigo_nuevo    varchar(20) not null,
    id_original     integer,
    id_nuevo        integer,
    created_at      timestamp(0),
    updated_at      timestamp(0)
);

alter table catalogos.geo_equivalencia
    owner to dba;

create index catalogos_geo_equivalencia_codigo_original_index
    on catalogos.geo_equivalencia (codigo_original);

create index catalogos_geo_equivalencia_codigo_nuevo_index
    on catalogos.geo_equivalencia (codigo_nuevo);

create index catalogos_geo_equivalencia_id_original_index
    on catalogos.geo_equivalencia (id_original);

create index catalogos_geo_equivalencia_id_nuevo_index
    on catalogos.geo_equivalencia (id_nuevo);

create table catalogos.veredas
(
    id_veredas serial not null
        constraint veredas_pk
            primary key,
    object_id  integer,
    cod_n1     varchar(20),
    cod_n2     varchar(20),
    cod_n3     varchar(20),
    nombre_n1  varchar(200),
    nombre_n2  varchar(200),
    nombre_n3  varchar(200),
    fuente     varchar(200),
    lat        real,
    lon        real
);

comment on table catalogos.veredas is 'Tabla temporal para importar nuevo listado geografico con coordenadas';

alter table catalogos.veredas
    owner to dba;

create index veredas_cod_n1_index
    on catalogos.veredas (cod_n1);

create index veredas_cod_n2_index
    on catalogos.veredas (cod_n2);

create index veredas_cod_n3_index
    on catalogos.veredas (cod_n3);

create index veredas_nombre_n1_index
    on catalogos.veredas (nombre_n1);

create index veredas_nombre_n2_index
    on catalogos.veredas (nombre_n2);

create index veredas_nombre_n3_index
    on catalogos.veredas (nombre_n3);



-- --------------------
-- IMPORTANTE, después de esto, poblar las tablas con el script "veredas.sql"
-- --------------------


delete from catalogos.geo_nueva where true;


-- Crear los departamentos
insert into catalogos.geo_nueva (nivel,descripcion,codigo)
select distinct 1,nombre_n1,cod_n1
from catalogos.veredas
order by 1, cod_n1,nombre_n1;

--Crear los municipios
insert into catalogos.geo_nueva (nivel,descripcion,codigo)
select distinct 2,nombre_n2,cod_n2
from catalogos.veredas
order by 2, cod_n2,nombre_n2;

-- Crear los lugares poblados
insert into catalogos.geo_nueva (nivel,descripcion,codigo,lat,lon)
select distinct 3,nombre_n3,cod_n3,lat,lon
from catalogos.veredas
order by 3, cod_n3,nombre_n3;

-- Meter los internacionales
insert into catalogos.geo_nueva(descripcion,nivel,codigo)
select descripcion,nivel,codigo from catalogos.geo where codigo ilike 'ii%';

insert into catalogos.geo_equivalencia (codigo_original, codigo_nuevo)
select codigo as original, codigo as nuevo from catalogos.geo
where codigo ilike 'ii%';



-- Control
select nivel,count(1) from catalogos.geo_nueva
group by 1
order by 1

-- ---------------------------------actualizar padres
-- poner padre al nivel 2
UPDATE catalogos.geo_nueva h
SET id_padre = p.id_geo_nueva
FROM catalogos.geo_nueva p
WHERE substring(h.codigo,1,2)=substring(p.codigo,1,2)
        and h.nivel=2 and p.nivel=1;

-- control
select * from catalogos.geo_nueva
where codigo like '05%' and nivel <=2
order by codigo;


-- poner padre al nivel 3
UPDATE catalogos.geo_nueva h
SET id_padre = p.id_geo_nueva
FROM catalogos.geo_nueva p
WHERE substring(h.codigo,1,5)=substring(p.codigo,1,5)
        and h.nivel=3 and p.nivel=2;

-- control
select * from catalogos.geo_nueva
where codigo like '05%' and nivel >=2
order by codigo;

-- control final
select * from catalogos.geo_nueva
where id_padre is null;


-- Tabla de equivalencias entre codigos antiguos y nuevos

UPDATE catalogos.geo_equivalencia
SET id_original = id_geo
FROM catalogos.geo
WHERE geo.codigo=geo_equivalencia.codigo_original;



UPDATE catalogos.geo_equivalencia
SET id_nuevo = id_geo_nueva
FROM catalogos.geo_nueva
WHERE geo_nueva.codigo = geo_equivalencia.codigo_nuevo;

-- ---------------------------------
-- Actualizar la tabla geografica
-- ---------------------------------


alter table catalogos.geo
	add descripcion_2 varchar(100);

alter table catalogos.geo
	add codigo_2 varchar(10);

alter table catalogos.geo
	add id_geo_2 int;

alter table catalogos.geo
	add lat float;

alter table catalogos.geo
	add lon float;

alter table catalogos.geo
	add nivel_2 int;

-- PASO 1: actualizar los existentes con el que les va a tocar
update catalogos.geo
set id_geo_2=id_nuevo
from catalogos.geo_equivalencia
    where id_geo=id_original;

-- PASO 2: append de los nuevos  (por diferencia)
-- OBTENER EL ID MAYOR PARA NO SOBREESCRIBIR EL NOMBRE DE LOS COMUNES
select max(id_geo) from catalogos.geo;

insert into catalogos.geo (id_geo_2,descripcion_2,codigo_2,descripcion)
select n.id_geo_nueva,n.descripcion,n.codigo, 'NUEVA'  from catalogos.geo_nueva n
    left join catalogos.geo on (id_geo_nueva=id_geo_2)
    where id_geo_2 is null and n.nivel=3
    order by n.codigo;

-- PASO 3: actualizar coordenadas
update catalogos.geo
    set lat=n.lat, lon=n.lon
    from catalogos.geo_nueva n
    where id_geo_2=id_geo_nueva;

-- PASO 4: actualizar nombre, codigo y nivel
-- preliminar
update catalogos.geo
    set descripcion_2 = n.descripcion, codigo_2=n.codigo, nivel_2=n.nivel
    from catalogos.geo_nueva n
    where id_geo_2=id_geo_nueva;

-- definitiva
update catalogos.geo
    set descripcion=descripcion_2, codigo=codigo_2, nivel=nivel_2
    where descripcion_2 is not null
        and id_geo > 9210;  --usar el id_obtenido en el paso 1

-- control: sin latitud por nivel
select nivel, count(1) from catalogos.geo
    where lat is null
    group by 1 ;

-- Volver a calcular los padres

update catalogos.geo
    set id_padre=null
    where nivel=1;

UPDATE catalogos.geo h
SET id_padre = p.id_geo
FROM catalogos.geo p
WHERE substring(h.codigo,1,2)=substring(p.codigo,1,2)
        and h.nivel=2 and p.nivel=1;

UPDATE catalogos.geo h
SET id_padre = p.id_geo
FROM catalogos.geo p
WHERE substring(h.codigo,1,5)=substring(p.codigo,1,5)
        and h.nivel=3 and p.nivel=2;


-- Control de calidad: que no hayan padres sin hijos
select count(1)
from catalogos.geo p left join catalogos.geo h on (h.id_padre = p.id_geo)
where p.nivel=2
 and h.id_geo is null;

 select count(1)
from catalogos.geo p left join catalogos.geo h on (h.id_padre = p.id_geo)
where p.nivel=1
 and h.id_geo is null;




 -- Lat/Lon de cabeceras
 update catalogos.geo set lat=5.789211, lon=-75.428818 where codigo='05002000';
update catalogos.geo set lat=8.08069, lon=-73.22127 where codigo='54003000';
update catalogos.geo set lat=6.633805, lon=-76.064764 where codigo='05004000';
update catalogos.geo set lat=3.991043, lon=-73.765966 where codigo='50006000';
update catalogos.geo set lat=8.510884, lon=-77.278628 where codigo='27006000';
update catalogos.geo set lat=1.805465, lon=-75.888378 where codigo='41006000';
update catalogos.geo set lat=8.567987, lon=-74.555406 where codigo='13006000';
update catalogos.geo set lat=2.259965, lon=-75.772215 where codigo='41013000';
update catalogos.geo set lat=4.376631, lon=-74.668456 where codigo='25001000';
update catalogos.geo set lat=8.310112, lon=-73.611279 where codigo='20011000';
update catalogos.geo set lat=6.161706, lon=-73.522385 where codigo='68013000';
update catalogos.geo set lat=5.610306, lon=-75.454592 where codigo='17013000';
update catalogos.geo set lat=5.169966, lon=-72.552368 where codigo='85010000';
update catalogos.geo set lat=10.035898, lon=-73.237741 where codigo='20013000';
update catalogos.geo set lat=3.222319, lon=-75.239961 where codigo='41016000';
update catalogos.geo set lat=4.878027, lon=-74.438447 where codigo='25019000';
update catalogos.geo set lat=1.328974, lon=-75.878603 where codigo='18029000';
update catalogos.geo set lat=11.162399, lon=-72.588722 where codigo='44035000';
update catalogos.geo set lat=5.75898, lon=-73.914147 where codigo='68020000';
update catalogos.geo set lat=4.673917, lon=-75.781782 where codigo='76020000';
update catalogos.geo set lat=0.882219, lon=-77.700317 where codigo='52022000';
update catalogos.geo set lat=6.375735, lon=-75.141528 where codigo='05021000';
update catalogos.geo set lat=10.200227, lon=-74.055674 where codigo='47030000';
update catalogos.geo set lat=2.522544, lon=-75.315691 where codigo='41020000';
update catalogos.geo set lat=1.91423, lon=-76.854856 where codigo='19022000';
update catalogos.geo set lat=4.970503, lon=-73.378719 where codigo='15022000';
update catalogos.geo set lat=3.391612, lon=-74.932571 where codigo='73024000';
update catalogos.geo set lat=2.063892, lon=-75.788045 where codigo='41026000';
update catalogos.geo set lat=8.79211, lon=-74.163883 where codigo='13030000';
update catalogos.geo set lat=4.567131, lon=-74.953824 where codigo='73026000';
update catalogos.geo set lat=6.036429, lon=-75.70174 where codigo='05030000';
update catalogos.geo set lat=6.906973, lon=-75.07359 where codigo='05031000';
update catalogos.geo set lat=4.783549, lon=-74.764359 where codigo='73030000';
update catalogos.geo set lat=4.56394, lon=-74.53078 where codigo='25035000';
update catalogos.geo set lat=1.26242, lon=-77.514549 where codigo='52036000';
update catalogos.geo set lat=5.096549, lon=-76.695536 where codigo='27450000';
update catalogos.geo set lat=4.172646, lon=-76.165311 where codigo='76036000';
update catalogos.geo set lat=5.656895, lon=-75.879439 where codigo='05034000';
update catalogos.geo set lat=6.113188, lon=-75.711307 where codigo='05036000';
update catalogos.geo set lat=6.884946, lon=-75.335431 where codigo='05038000';
update catalogos.geo set lat=4.762033, lon=-74.463558 where codigo='25040000';
update catalogos.geo set lat=7.07573, lon=-75.146867 where codigo='05040000';
update catalogos.geo set lat=5.238162, lon=-75.782766 where codigo='17042000';
update catalogos.geo set lat=4.79423, lon=-75.992849 where codigo='76041000';
update catalogos.geo set lat=6.302511, lon=-75.853622 where codigo='05044000';
update catalogos.geo set lat=4.631635, lon=-75.094092 where codigo='73043000';
update catalogos.geo set lat=7.88183, lon=-76.625819 where codigo='05045000';
update catalogos.geo set lat=5.106364, lon=-75.941632 where codigo='66045000';
update catalogos.geo set lat=5.518415, lon=-72.884063 where codigo='15047000';
update catalogos.geo set lat=10.591961, lon=-74.188125 where codigo='47053000';
update catalogos.geo set lat=5.27129, lon=-75.490701 where codigo='17050000';
update catalogos.geo set lat=6.69408, lon=-73.017758 where codigo='68051000';
update catalogos.geo set lat=7.079946, lon=-70.756141 where codigo='81001000';
update catalogos.geo set lat=7.029632, lon=-71.428695 where codigo='81065000';
update catalogos.geo set lat=4.272467, lon=-74.414676 where codigo='25053000';
update catalogos.geo set lat=7.642951, lon=-72.79861 where codigo='54051000';
update catalogos.geo set lat=8.850335, lon=-76.426785 where codigo='05051000';
update catalogos.geo set lat=5.754529, lon=-73.437123 where codigo='15051000';
update catalogos.geo set lat=8.458626, lon=-73.94299 where codigo='13042000';
update catalogos.geo set lat=5.730854, lon=-75.142276 where codigo='05055000';
update catalogos.geo set lat=2.255507, lon=-77.248998 where codigo='19050000';
update catalogos.geo set lat=4.726981, lon=-76.121569 where codigo='76054000';
update catalogos.geo set lat=10.252955, lon=-75.347535 where codigo='13052000';
update catalogos.geo set lat=6.156142, lon=-75.787047 where codigo='05059000';
update catalogos.geo set lat=4.535101, lon=-75.68159 where codigo='63001000';
update catalogos.geo set lat=10.255797, lon=-75.020012 where codigo='13062000';
update catalogos.geo set lat=9.496195, lon=-73.975628 where codigo='20032000';
update catalogos.geo set lat=3.590935, lon=-75.381528 where codigo='73067000';
update catalogos.geo set lat=8.311087, lon=-75.147004 where codigo='23068000';
update catalogos.geo set lat=5.411656, lon=-76.415967 where codigo='27073000';
update catalogos.geo set lat=2.040741, lon=-77.216799 where codigo='19075000';
update catalogos.geo set lat=4.949776, lon=-75.958258 where codigo='66075000';
update catalogos.geo set lat=10.391258, lon=-73.0286 where codigo='20443000';
update catalogos.geo set lat=10.793577, lon=-74.915194 where codigo='08078000';
update catalogos.geo set lat=3.152603, lon=-75.05434 where codigo='41078000';
update catalogos.geo set lat=1.674062, lon=-78.136496 where codigo='52079000';
update catalogos.geo set lat=6.438564, lon=-75.331845 where codigo='05079000';
update catalogos.geo set lat=5.932791, lon=-73.615489 where codigo='68077000';
update catalogos.geo set lat=6.635344, lon=-73.223466 where codigo='68079000';
update catalogos.geo set lat=4.568337, lon=-72.96572 where codigo='50110000';
update catalogos.geo set lat=7.064422, lon=-73.849771 where codigo='68081000';
update catalogos.geo set lat=10.95512, lon=-72.795554 where codigo='44078000';
update catalogos.geo set lat=8.947889, lon=-74.107057 where codigo='13074000';
update catalogos.geo set lat=3.494364, lon=-69.815061 where codigo='94343000';
update catalogos.geo set lat=9.7034, lon=-73.279402 where codigo='20045000';
update catalogos.geo set lat=4.993614, lon=-75.80522 where codigo='17088000';
update catalogos.geo set lat=2.645089, lon=-75.972393 where codigo='19517000';
update catalogos.geo set lat=5.989418, lon=-72.911709 where codigo='15087000';
update catalogos.geo set lat=1.595603, lon=-77.016225 where codigo='52083000';
update catalogos.geo set lat=7.371493, lon=-76.714451 where codigo='27086000';
update catalogos.geo set lat=1.420202, lon=-75.871453 where codigo='18094000';
update catalogos.geo set lat=5.201167, lon=-75.868719 where codigo='66088000';
update catalogos.geo set lat=6.568945, lon=-76.895102 where codigo='27099000';
update catalogos.geo set lat=6.332847, lon=-75.552467 where codigo='05088000';
update catalogos.geo set lat=6.605414, lon=-75.666673 where codigo='05086000';
update catalogos.geo set lat=4.800714, lon=-74.740773 where codigo='25086000';
update catalogos.geo set lat=5.226924, lon=-73.126813 where codigo='15090000';
update catalogos.geo set lat=1.503153, lon=-77.135781 where codigo='52051000';
update catalogos.geo set lat=5.74657, lon=-75.978568 where codigo='05091000';
update catalogos.geo set lat=5.994314, lon=-76.781171 where codigo='27425000';
update catalogos.geo set lat=5.910464, lon=-72.80903 where codigo='15092000';
update catalogos.geo set lat=6.109015, lon=-75.984189 where codigo='05093000';
update catalogos.geo set lat=6.899732, lon=-73.283822 where codigo='68092000';
update catalogos.geo set lat=4.872513, lon=-74.539548 where codigo='25095000';
update catalogos.geo set lat=6.330609, lon=-72.584791 where codigo='15097000';
update catalogos.geo set lat=5.050771, lon=-77.052189 where codigo='27430000';
update catalogos.geo set lat=2.348458, lon=-78.326712 where codigo='52490000';
update catalogos.geo set lat=7.611327, lon=-72.647158 where codigo='54099000';
update catalogos.geo set lat=4.737189, lon=-74.344304 where codigo='25099000';
update catalogos.geo set lat=1.837518, lon=-76.96669 where codigo='19100000';
update catalogos.geo set lat=5.985953, lon=-73.771524 where codigo='68101000';
update catalogos.geo set lat=4.338637, lon=-76.184878 where codigo='76100000';
update catalogos.geo set lat=9.973821, lon=-73.888102 where codigo='20060000';
update catalogos.geo set lat=5.454533, lon=-73.362063 where codigo='15104000';
update catalogos.geo set lat=7.112453, lon=-75.550727 where codigo='05107000';
update catalogos.geo set lat=5.690148, lon=-73.923346 where codigo='15106000';
update catalogos.geo set lat=7.114892, lon=-73.132501 where codigo='68001000';
update catalogos.geo set lat=8.039446, lon=-72.866946 where codigo='54109000';
update catalogos.geo set lat=3.876601, lon=-77.012881 where codigo='76109000';
update catalogos.geo set lat=4.358602, lon=-75.740325 where codigo='63111000';
update catalogos.geo set lat=5.512832, lon=-73.942595 where codigo='15109000';
update catalogos.geo set lat=8.222239, lon=-75.481988 where codigo='23079000';
update catalogos.geo set lat=9.319637, lon=-74.973941 where codigo='70110000';
update catalogos.geo set lat=3.015196, lon=-76.642751 where codigo='19110000';
update catalogos.geo set lat=1.38507, lon=-77.155808 where codigo='52110000';
update catalogos.geo set lat=3.899127, lon=-76.298645 where codigo='76111000';
update catalogos.geo set lat=4.20933, lon=-76.156398 where codigo='76113000';
update catalogos.geo set lat=6.720715, lon=-75.906844 where codigo='05113000';
update catalogos.geo set lat=5.830172, lon=-72.884028 where codigo='15114000';
update catalogos.geo set lat=6.591505, lon=-73.246477 where codigo='68121000';
update catalogos.geo set lat=3.984846, lon=-74.484296 where codigo='25120000';
update catalogos.geo set lat=4.284762, lon=-72.792969 where codigo='50124000';
update catalogos.geo set lat=3.526135, lon=-67.412545 where codigo='94886000';
update catalogos.geo set lat=7.577204, lon=-75.348961 where codigo='05120000';
update catalogos.geo set lat=4.730928, lon=-74.435949 where codigo='25123000';
update catalogos.geo set lat=7.741863, lon=-73.048522 where codigo='54128000';
update catalogos.geo set lat=7.268555, lon=-72.642197 where codigo='54125000';
update catalogos.geo set lat=6.405392, lon=-75.983937 where codigo='05125000';
update catalogos.geo set lat=4.335004, lon=-75.830806 where codigo='76122000';
update catalogos.geo set lat=8.788969, lon=-75.115985 where codigo='70124000';
update catalogos.geo set lat=4.440182, lon=-75.428798 where codigo='73124000';
update catalogos.geo set lat=2.622649, lon=-76.57052 where codigo='19130000';
update catalogos.geo set lat=4.92015, lon=-74.024273 where codigo='25126000';
update catalogos.geo set lat=10.249938, lon=-74.914924 where codigo='13140000';
update catalogos.geo set lat=1.958595, lon=-72.654943 where codigo='95015000';
update catalogos.geo set lat=4.523618, lon=-75.644635 where codigo='63130000';
update catalogos.geo set lat=6.092146, lon=-75.636565 where codigo='05129000';
update catalogos.geo set lat=5.554451, lon=-73.865351 where codigo='15131000';
update catalogos.geo set lat=2.79743, lon=-76.484599 where codigo='19137000';
update catalogos.geo set lat=7.348056, lon=-72.945788 where codigo='68132000';
update catalogos.geo set lat=3.032803, lon=-76.408126 where codigo='19142000';
update catalogos.geo set lat=6.979295, lon=-75.297158 where codigo='05134000';
update catalogos.geo set lat=10.380127, lon=-74.881411 where codigo='08137000';
update catalogos.geo set lat=2.685067, lon=-75.326323 where codigo='41132000';
update catalogos.geo set lat=5.030386, lon=-73.103924 where codigo='15135000';
update catalogos.geo set lat=8.78755, lon=-76.240758 where codigo='23090000';
update catalogos.geo set lat=10.459616, lon=-74.880321 where codigo='08141000';
update catalogos.geo set lat=3.412681, lon=-76.348932 where codigo='76130000';
update catalogos.geo set lat=7.380333, lon=-73.917587 where codigo='13160000';
update catalogos.geo set lat=6.751949, lon=-76.026163 where codigo='05138000';
update catalogos.geo set lat=5.346825, lon=-74.49143 where codigo='25148000';
update catalogos.geo set lat=6.527315, lon=-72.695378 where codigo='68147000';
update catalogos.geo set lat=4.403955, lon=-73.947005 where codigo='25151000';
update catalogos.geo set lat=6.409506, lon=-74.757345 where codigo='05142000';
update catalogos.geo set lat=5.54867, lon=-75.644405 where codigo='05145000';
update catalogos.geo set lat=6.62648, lon=-72.626607 where codigo='68152000';
update catalogos.geo set lat=7.755318, lon=-76.65554 where codigo='05147000';
update catalogos.geo set lat=0.863022, lon=-77.729637 where codigo='52224000';
update catalogos.geo set lat=4.150574, lon=-74.717184 where codigo='73148000';
update catalogos.geo set lat=5.349187, lon=-73.901352 where codigo='25154000';
update catalogos.geo set lat=6.724619, lon=-75.282415 where codigo='05150000';
update catalogos.geo set lat=1.334266, lon=-74.844581 where codigo='18150000';
update catalogos.geo set lat=4.748408, lon=-75.922783 where codigo='76147000';
update catalogos.geo set lat=1.012104, lon=-71.295822 where codigo='97161000';
update catalogos.geo set lat=7.002677, lon=-73.910429 where codigo='05893000';
update catalogos.geo set lat=5.078619, lon=-75.120304 where codigo='73152000';
update catalogos.geo set lat=3.827498, lon=-73.689282 where codigo='50150000';
update catalogos.geo set lat=7.978558, lon=-75.197702 where codigo='05154000';
update catalogos.geo set lat=6.753431, lon=-72.974651 where codigo='68160000';
update catalogos.geo set lat=8.885193, lon=-75.792242 where codigo='23162000';
update catalogos.geo set lat=5.95584, lon=-72.947885 where codigo='15162000';
update catalogos.geo set lat=6.84145, lon=-72.695293 where codigo='68162000';
update catalogos.geo set lat=10.32692, lon=-74.869013 where codigo='47161000';
update catalogos.geo set lat=5.371868, lon=-76.608572 where codigo='27160000';
update catalogos.geo set lat=1.360262, lon=-77.283069 where codigo='52240000';
update catalogos.geo set lat=4.949219, lon=-74.593786 where codigo='25168000';
update catalogos.geo set lat=9.545877, lon=-75.31289 where codigo='70230000';
update catalogos.geo set lat=5.213436, lon=-72.870104 where codigo='85015000';
update catalogos.geo set lat=3.724314, lon=-75.481944 where codigo='73168000';
update catalogos.geo set lat=6.286268, lon=-73.146564 where codigo='68167000';
update catalogos.geo set lat=7.280762, lon=-72.968226 where codigo='68169000';
update catalogos.geo set lat=4.863649, lon=-74.052201 where codigo='25175000';
update catalogos.geo set lat=7.66615, lon=-76.676499 where codigo='05172000';
update catalogos.geo set lat=6.341818, lon=-73.3729 where codigo='68176000';
update catalogos.geo set lat=9.149335, lon=-75.628635 where codigo='23168000';
update catalogos.geo set lat=9.25763, lon=-73.812689 where codigo='20175000';
update catalogos.geo set lat=7.602036, lon=-72.602093 where codigo='54172000';
update catalogos.geo set lat=5.167393, lon=-73.368668 where codigo='15172000';
update catalogos.geo set lat=4.984436, lon=-75.607796 where codigo='17174000';
update catalogos.geo set lat=9.105928, lon=-75.40028 where codigo='23182000';
update catalogos.geo set lat=4.442172, lon=-74.044355 where codigo='25178000';
update catalogos.geo set lat=6.061639, lon=-73.637456 where codigo='68179000';
update catalogos.geo set lat=5.615479, lon=-73.817647 where codigo='15176000';
update catalogos.geo set lat=5.605297, lon=-73.484917 where codigo='15232000';
update catalogos.geo set lat=9.361726, lon=-73.600896 where codigo='20178000';
update catalogos.geo set lat=6.552997, lon=-72.500156 where codigo='15180000';
update catalogos.geo set lat=6.187219, lon=-72.471282 where codigo='15183000';
update catalogos.geo set lat=7.13839, lon=-72.664832 where codigo='54174000';
update catalogos.geo set lat=6.027942, lon=-73.446932 where codigo='15185000';
update catalogos.geo set lat=5.558498, lon=-73.282602 where codigo='15187000';
update catalogos.geo set lat=10.02815, lon=-74.625173 where codigo='47170000';
update catalogos.geo set lat=4.888, lon=-73.368325 where codigo='15236000';
update catalogos.geo set lat=4.528358, lon=-73.922672 where codigo='25181000';
update catalogos.geo set lat=5.145906, lon=-73.683951 where codigo='25183000';
update catalogos.geo set lat=9.276841, lon=-74.643858 where codigo='13188000';
update catalogos.geo set lat=11.006351, lon=-74.246527 where codigo='47189000';
update catalogos.geo set lat=8.87773, lon=-75.622072 where codigo='23189000';
update catalogos.geo set lat=5.409373, lon=-73.29573 where codigo='15189000';
update catalogos.geo set lat=6.314508, lon=-73.949681 where codigo='68190000';
update catalogos.geo set lat=4.617052, lon=-75.636022 where codigo='63190000';
update catalogos.geo set lat=6.53877, lon=-75.086972 where codigo='05190000';
update catalogos.geo set lat=5.85088, lon=-76.022578 where codigo='05101000';
update catalogos.geo set lat=10.567776, lon=-75.324847 where codigo='13222000';
update catalogos.geo set lat=2.342534, lon=-76.496845 where codigo='19585000';
update catalogos.geo set lat=6.057455, lon=-75.185608 where codigo='05197000';
update catalogos.geo set lat=4.286429, lon=-74.898046 where codigo='73200000';
update catalogos.geo set lat=5.061613, lon=-73.977843 where codigo='25200000';
update catalogos.geo set lat=3.376661, lon=-74.802667 where codigo='41206000';
update catalogos.geo set lat=1.189532, lon=-76.972489 where codigo='86219000';
update catalogos.geo set lat=5.634314, lon=-73.323763 where codigo='15204000';
update catalogos.geo set lat=6.394147, lon=-75.257399 where codigo='05206000';
update catalogos.geo set lat=6.768987, lon=-72.694294 where codigo='68207000';
update catalogos.geo set lat=6.045723, lon=-75.90742 where codigo='05209000';
update catalogos.geo set lat=10.25781, lon=-74.831793 where codigo='47205000';
update catalogos.geo set lat=5.091329, lon=-76.650404 where codigo='27205000';
update catalogos.geo set lat=6.356354, lon=-73.241852 where codigo='68209000';
update catalogos.geo set lat=1.207219, lon=-77.46596 where codigo='52207000';
update catalogos.geo set lat=0.910936, lon=-77.549875 where codigo='52210000';
update catalogos.geo set lat=6.290551, lon=-73.474701 where codigo='68211000';
update catalogos.geo set lat=8.46914, lon=-73.337297 where codigo='54206000';
update catalogos.geo set lat=6.35776, lon=-75.502934 where codigo='05212000';
update catalogos.geo set lat=5.475374, lon=-74.045078 where codigo='15212000';
update catalogos.geo set lat=9.586673, lon=-74.826949 where codigo='13212000';
update catalogos.geo set lat=4.391643, lon=-75.686942 where codigo='63212000';
update catalogos.geo set lat=0.853485, lon=-77.517919 where codigo='52215000';
update catalogos.geo set lat=3.173915, lon=-76.25914 where codigo='19212000';
update catalogos.geo set lat=6.295594, lon=-73.040705 where codigo='68217000';
update catalogos.geo set lat=9.319202, lon=-75.294726 where codigo='70215000';
update catalogos.geo set lat=5.828579, lon=-72.844477 where codigo='15215000';
update catalogos.geo set lat=4.809131, lon=-74.102502 where codigo='25214000';
update catalogos.geo set lat=6.500259, lon=-72.73902 where codigo='15218000';
update catalogos.geo set lat=3.798639, lon=-75.194625 where codigo='73217000';
update catalogos.geo set lat=6.303412, lon=-70.203575 where codigo='81220000';
update catalogos.geo set lat=7.001702, lon=-72.108323 where codigo='15223000';
update catalogos.geo set lat=5.543082, lon=-73.454781 where codigo='15224000';
update catalogos.geo set lat=5.250243, lon=-73.766892 where codigo='25224000';
update catalogos.geo set lat=7.904003, lon=-72.504773 where codigo='54001000';
update catalogos.geo set lat=7.539453, lon=-72.772408 where codigo='54223000';
update catalogos.geo set lat=5.580241, lon=-72.96616 where codigo='15226000';
update catalogos.geo set lat=4.268788, lon=-73.486138 where codigo='50226000';
update catalogos.geo set lat=4.444509, lon=-69.798541 where codigo='99773000';
update catalogos.geo set lat=0.906234, lon=-77.792003 where codigo='52227000';
update catalogos.geo set lat=1.647639, lon=-77.578362 where codigo='52233000';
update catalogos.geo set lat=4.059885, lon=-74.692625 where codigo='73226000';
update catalogos.geo set lat=7.157363, lon=-76.971296 where codigo='27150000';
update catalogos.geo set lat=1.033597, lon=-75.920311 where codigo='18205000';
update catalogos.geo set lat=6.605089, lon=-73.068926 where codigo='68229000';
update catalogos.geo set lat=9.20112, lon=-73.542884 where codigo='20228000';
update catalogos.geo set lat=6.999974, lon=-76.262987 where codigo='05234000';
update catalogos.geo set lat=3.656878, lon=-76.689454 where codigo='76233000';
update catalogos.geo set lat=3.931584, lon=-76.486036 where codigo='76126000';
update catalogos.geo set lat=11.272481, lon=-73.309046 where codigo='44090000';
update catalogos.geo set lat=10.896701, lon=-72.886526 where codigo='44098000';
update catalogos.geo set lat=10.977821, lon=-74.804808 where codigo='08001000';
update catalogos.geo set lat=3.539122, lon=-74.896769 where codigo='73236000';
update catalogos.geo set lat=6.485775, lon=-75.394202 where codigo='05237000';
update catalogos.geo set lat=4.83464, lon=-75.674704 where codigo='66170000';
update catalogos.geo set lat=10.400115, lon=-75.503973 where codigo='13001000';
update catalogos.geo set lat=7.71464, lon=-72.657258 where codigo='54239000';
update catalogos.geo set lat=6.326887, lon=-75.766822 where codigo='05240000';
update catalogos.geo set lat=4.908992, lon=-76.04182 where codigo='76243000';
update catalogos.geo set lat=7.599494, lon=-74.805973 where codigo='05250000';
update catalogos.geo set lat=9.004476, lon=-73.972315 where codigo='47245000';
update catalogos.geo set lat=2.117177, lon=-76.982294 where codigo='19532000';
update catalogos.geo set lat=4.76103, lon=-76.221581 where codigo='76246000';
update catalogos.geo set lat=4.352267, lon=-73.713374 where codigo='50245000';
update catalogos.geo set lat=8.510773, lon=-73.446807 where codigo='54245000';
update catalogos.geo set lat=5.899952, lon=-76.142096 where codigo='27245000';
update catalogos.geo set lat=9.717306, lon=-75.121738 where codigo='13244000';
update catalogos.geo set lat=6.698657, lon=-73.511571 where codigo='68235000';
update catalogos.geo set lat=6.083904, lon=-75.335637 where codigo='05148000';
update catalogos.geo set lat=3.563687, lon=-73.794443 where codigo='50251000';
update catalogos.geo set lat=3.684376, lon=-76.311747 where codigo='76248000';
update catalogos.geo set lat=2.478002, lon=-78.110764 where codigo='52250000';
update catalogos.geo set lat=6.409095, lon=-72.445079 where codigo='15244000';
update catalogos.geo set lat=4.579507, lon=-74.443349 where codigo='25245000';
update catalogos.geo set lat=10.1492, lon=-73.961066 where codigo='20238000';
update catalogos.geo set lat=9.84827, lon=-74.235748 where codigo='47058000';
update catalogos.geo set lat=1.678987, lon=-75.282787 where codigo='18247000';
update catalogos.geo set lat=3.739313, lon=-73.835049 where codigo='50270000';
update catalogos.geo set lat=4.509175, lon=-76.237175 where codigo='76250000';
update catalogos.geo set lat=-1.74708, lon=-73.209265 where codigo='91263000';
update catalogos.geo set lat=6.482594, lon=-72.496337 where codigo='15248000';
update catalogos.geo set lat=6.245315, lon=-73.497069 where codigo='68245000';
update catalogos.geo set lat=10.031219, lon=-74.97534 where codigo='13248000';
update catalogos.geo set lat=10.652272, lon=-72.921557 where codigo='44110000';
update catalogos.geo set lat=9.661481, lon=-73.747097 where codigo='20250000';
update catalogos.geo set lat=1.570817, lon=-75.326052 where codigo='18256000';
update catalogos.geo set lat=1.453602, lon=-77.439773 where codigo='52254000';
update catalogos.geo set lat=8.989499, lon=-73.949865 where codigo='13268000';
update catalogos.geo set lat=5.248737, lon=-74.290379 where codigo='25258000';
update catalogos.geo set lat=6.056581, lon=-73.81437 where codigo='68250000';
update catalogos.geo set lat=10.403754, lon=-74.823972 where codigo='47258000';
update catalogos.geo set lat=7.470854, lon=-73.203309 where codigo='68255000';
update catalogos.geo set lat=10.612041, lon=-74.269535 where codigo='47268000';
update catalogos.geo set lat=2.330805, lon=-72.627956 where codigo='95025000';
update catalogos.geo set lat=9.107368, lon=-75.194199 where codigo='70233000';
update catalogos.geo set lat=4.852228, lon=-74.263613 where codigo='25260000';
update catalogos.geo set lat=1.743167, lon=-77.335072 where codigo='52256000';
update catalogos.geo set lat=6.137603, lon=-75.26389 where codigo='05697000';
update catalogos.geo set lat=1.427254, lon=-77.097285 where codigo='52258000';
update catalogos.geo set lat=2.452184, lon=-76.810734 where codigo='19256000';
update catalogos.geo set lat=1.408121, lon=-77.391851 where codigo='52260000';
update catalogos.geo set lat=8.573097, lon=-73.102518 where codigo='54250000';
update catalogos.geo set lat=7.937973, lon=-72.60406 where codigo='54261000';
update catalogos.geo set lat=2.013218, lon=-75.937306 where codigo='41244000';
update catalogos.geo set lat=6.138297, lon=-73.099415 where codigo='68264000';
update catalogos.geo set lat=6.669718, lon=-72.700011 where codigo='68266000';
update catalogos.geo set lat=6.566219, lon=-75.516677 where codigo='05264000';
update catalogos.geo set lat=6.166403, lon=-75.583448 where codigo='05266000';
update catalogos.geo set lat=4.150799, lon=-74.885311 where codigo='73268000';
update catalogos.geo set lat=4.808231, lon=-74.345265 where codigo='25269000';
update catalogos.geo set lat=5.120378, lon=-74.951974 where codigo='73270000';
update catalogos.geo set lat=5.297408, lon=-75.562209 where codigo='17272000';
update catalogos.geo set lat=4.675006, lon=-75.658034 where codigo='63272000';
update catalogos.geo set lat=5.669037, lon=-72.99373 where codigo='15272000';
update catalogos.geo set lat=4.281986, lon=-74.813985 where codigo='73275000';
update catalogos.geo set lat=1.682994, lon=-77.072688 where codigo='19290000';
update catalogos.geo set lat=1.61631, lon=-75.60751 where codigo='18001000';
update catalogos.geo set lat=5.85954, lon=-72.918499 where codigo='15276000';
update catalogos.geo set lat=5.803377, lon=-73.970957 where codigo='68271000';
update catalogos.geo set lat=3.321637, lon=-76.236863 where codigo='76275000';
update catalogos.geo set lat=7.074052, lon=-73.097913 where codigo='68276000';
update catalogos.geo set lat=4.485795, lon=-73.893655 where codigo='25279000';
update catalogos.geo set lat=10.887124, lon=-72.85208 where codigo='44279000';
update catalogos.geo set lat=6.794137, lon=-71.771734 where codigo='81300000';
update catalogos.geo set lat=4.33919, lon=-73.939173 where codigo='25281000';
update catalogos.geo set lat=5.926657, lon=-75.671629 where codigo='05282000';
update catalogos.geo set lat=5.153534, lon=-75.036205 where codigo='73283000';
update catalogos.geo set lat=6.776357, lon=-76.130718 where codigo='05284000';
update catalogos.geo set lat=3.462213, lon=-73.619545 where codigo='50287000';
update catalogos.geo set lat=10.518133, lon=-74.189168 where codigo='47288000';
update catalogos.geo set lat=1.001091, lon=-77.449317 where codigo='52287000';
update catalogos.geo set lat=4.71348, lon=-74.206206 where codigo='25286000';
update catalogos.geo set lat=5.403992, lon=-73.795764 where codigo='25288000';
update catalogos.geo set lat=4.337531, lon=-74.372879 where codigo='25290000';
update catalogos.geo set lat=4.693113, lon=-73.520294 where codigo='25293000';
update catalogos.geo set lat=4.991991, lon=-73.872096 where codigo='25295000';
update catalogos.geo set lat=5.752003, lon=-73.549224 where codigo='15293000';
update catalogos.geo set lat=4.81719, lon=-73.63704 where codigo='25297000';
update catalogos.geo set lat=6.638891, lon=-73.287946 where codigo='68296000';
update catalogos.geo set lat=10.896831, lon=-74.885962 where codigo='08296000';
update catalogos.geo set lat=4.76264, lon=-73.610796 where codigo='25299000';
update catalogos.geo set lat=8.32185, lon=-73.742582 where codigo='20295000';
update catalogos.geo set lat=5.945635, lon=-73.343969 where codigo='68298000';
update catalogos.geo set lat=5.802355, lon=-72.805573 where codigo='15296000';
update catalogos.geo set lat=5.08228, lon=-73.364864 where codigo='15299000';
update catalogos.geo set lat=2.196687, lon=-75.628456 where codigo='41298000';
update catalogos.geo set lat=4.206553, lon=-75.790011 where codigo='63302000';
update catalogos.geo set lat=1.643959, lon=-77.019691 where codigo='52203000';
update catalogos.geo set lat=2.386009, lon=-75.546019 where codigo='41306000';
update catalogos.geo set lat=3.724999, lon=-76.26835 where codigo='76306000';
update catalogos.geo set lat=6.679571, lon=-75.951529 where codigo='05306000';
update catalogos.geo set lat=4.308855, lon=-74.795888 where codigo='25307000';
update catalogos.geo set lat=6.377579, lon=-75.444562 where codigo='05308000';
update catalogos.geo set lat=7.073982, lon=-73.167696 where codigo='68307000';
update catalogos.geo set lat=6.682749, lon=-75.220901 where codigo='05310000';
update catalogos.geo set lat=8.390114, lon=-73.380442 where codigo='20310000';
update catalogos.geo set lat=7.887509, lon=-72.797065 where codigo='54313000';
update catalogos.geo set lat=6.139714, lon=-75.183271 where codigo='05313000';
update catalogos.geo set lat=3.544874, lon=-73.706262 where codigo='50313000';
update catalogos.geo set lat=4.519055, lon=-74.350851 where codigo='25312000';
update catalogos.geo set lat=6.87604, lon=-72.855764 where codigo='68318000';
update catalogos.geo set lat=6.459665, lon=-72.500748 where codigo='15317000';
update catalogos.geo set lat=3.761676, lon=-76.333662 where codigo='76318000';
update catalogos.geo set lat=1.221619, lon=-77.677232 where codigo='52699000';
update catalogos.geo set lat=5.383303, lon=-73.686279 where codigo='25317000';
update catalogos.geo set lat=0.960343, lon=-77.731608 where codigo='52317000';
update catalogos.geo set lat=6.814087, lon=-75.240464 where codigo='05315000';
update catalogos.geo set lat=2.02494, lon=-75.757715 where codigo='41319000';
update catalogos.geo set lat=6.246129, lon=-73.418966 where codigo='68320000';
update catalogos.geo set lat=5.071652, lon=-74.603532 where codigo='25320000';
update catalogos.geo set lat=1.130626, lon=-77.549818 where codigo='52320000';
update catalogos.geo set lat=0.919256, lon=-77.568555 where codigo='52323000';
update catalogos.geo set lat=9.144777, lon=-74.225689 where codigo='47318000';
update catalogos.geo set lat=3.879411, lon=-73.770724 where codigo='50318000';
update catalogos.geo set lat=4.029912, lon=-74.971359 where codigo='73319000';
update catalogos.geo set lat=2.570659, lon=-77.885596 where codigo='19318000';
update catalogos.geo set lat=6.307892, lon=-73.320834 where codigo='68322000';
update catalogos.geo set lat=8.468037, lon=-74.536633 where codigo='70265000';
update catalogos.geo set lat=6.275489, lon=-75.442805 where codigo='05318000';
update catalogos.geo set lat=4.866518, lon=-73.878399 where codigo='25322000';
update catalogos.geo set lat=6.231992, lon=-75.158492 where codigo='05321000';
update catalogos.geo set lat=4.518164, lon=-74.789999 where codigo='25324000';
update catalogos.geo set lat=4.934942, lon=-73.83366 where codigo='25326000';
update catalogos.geo set lat=5.007074, lon=-73.471978 where codigo='15322000';
update catalogos.geo set lat=5.315756, lon=-75.799442 where codigo='66318000';
update catalogos.geo set lat=5.955196, lon=-73.700556 where codigo='68324000';
update catalogos.geo set lat=5.031381, lon=-74.884874 where codigo='73055000';
update catalogos.geo set lat=4.878229, lon=-74.467563 where codigo='25328000';
update catalogos.geo set lat=4.217887, lon=-73.817261 where codigo='25335000';
update catalogos.geo set lat=4.967378, lon=-73.490057 where codigo='15325000';
update catalogos.geo set lat=6.025218, lon=-73.574105 where codigo='68327000';
update catalogos.geo set lat=6.462916, lon=-72.412082 where codigo='15332000';
update catalogos.geo set lat=4.255298, lon=-74.003057 where codigo='25339000';
update catalogos.geo set lat=8.321593, lon=-73.145887 where codigo='54344000';
update catalogos.geo set lat=8.956184, lon=-74.077388 where codigo='13300000';
update catalogos.geo set lat=6.543813, lon=-73.308299 where codigo='68344000';
update catalogos.geo set lat=6.156856, lon=-71.763459 where codigo='85125000';
update catalogos.geo set lat=11.067521, lon=-72.76008 where codigo='44378000';
update catalogos.geo set lat=6.207605, lon=-75.733968 where codigo='05347000';
update catalogos.geo set lat=7.506186, lon=-72.48319 where codigo='54347000';
update catalogos.geo set lat=5.079901, lon=-75.178083 where codigo='73347000';
update catalogos.geo set lat=5.799196, lon=-75.907139 where codigo='05353000';
update catalogos.geo set lat=2.582315, lon=-75.450179 where codigo='41349000';
update catalogos.geo set lat=5.211854, lon=-74.759958 where codigo='73349000';
update catalogos.geo set lat=4.427955, lon=-75.187804 where codigo='73001000';
update catalogos.geo set lat=4.176262, lon=-74.531821 where codigo='73352000';
update catalogos.geo set lat=0.968468, lon=-77.521338 where codigo='52352000';
update catalogos.geo set lat=1.055155, lon=-77.496501 where codigo='52354000';
update catalogos.geo set lat=3.867935, lon=-67.923854 where codigo='94001000';
update catalogos.geo set lat=2.54867, lon=-76.065154 where codigo='19355000';
update catalogos.geo set lat=0.826811, lon=-77.638193 where codigo='52356000';
update catalogos.geo set lat=2.649892, lon=-75.635209 where codigo='41357000';
update catalogos.geo set lat=2.450729, lon=-77.979835 where codigo='52696000';
update catalogos.geo set lat=6.17595, lon=-75.611425 where codigo='05360000';
update catalogos.geo set lat=5.156666, lon=-76.686667 where codigo='27361000';
update catalogos.geo set lat=7.172172, lon=-75.764842 where codigo='05361000';
update catalogos.geo set lat=5.613909, lon=-72.980356 where codigo='15362000';
update catalogos.geo set lat=2.777647, lon=-76.324379 where codigo='19364000';
update catalogos.geo set lat=3.262544, lon=-76.539365 where codigo='76364000';
update catalogos.geo set lat=5.597518, lon=-75.818898 where codigo='05364000';
update catalogos.geo set lat=5.384903, lon=-73.363953 where codigo='15367000';
update catalogos.geo set lat=5.79126, lon=-75.785315 where codigo='05368000';
update catalogos.geo set lat=6.145985, lon=-72.570522 where codigo='15368000';
update catalogos.geo set lat=4.562469, lon=-74.694278 where codigo='25368000';
update catalogos.geo set lat=5.876522, lon=-73.782778 where codigo='68368000';
update catalogos.geo set lat=6.73236, lon=-73.096018 where codigo='68370000';
update catalogos.geo set lat=10.829161, lon=-75.034704 where codigo='08372000';
update catalogos.geo set lat=4.79071, lon=-73.663019 where codigo='25372000';
update catalogos.geo set lat=7.10286, lon=-77.762455 where codigo='27372000';
update catalogos.geo set lat=8.048119, lon=-75.335001 where codigo='23350000';
update catalogos.geo set lat=2.198535, lon=-75.979114 where codigo='41378000';
update catalogos.geo set lat=5.859088, lon=-73.964924 where codigo='68377000';
update catalogos.geo set lat=4.721619, lon=-73.968648 where codigo='25377000';
update catalogos.geo set lat=5.095352, lon=-73.444852 where codigo='15380000';
update catalogos.geo set lat=6.028164, lon=-75.430252 where codigo='05376000';
update catalogos.geo set lat=5.003315, lon=-76.003199 where codigo='66383000';
update catalogos.geo set lat=-1.443689, lon=-72.789192 where codigo='91405000';
update catalogos.geo set lat=1.600581, lon=-76.971258 where codigo='52378000';
update catalogos.geo set lat=3.649478, lon=-76.568444 where codigo='76377000';
update catalogos.geo set lat=5.468454, lon=-74.673207 where codigo='17380000';
update catalogos.geo set lat=7.639192, lon=-73.328034 where codigo='54385000';
update catalogos.geo set lat=6.145176, lon=-75.63691 where codigo='05380000';
update catalogos.geo set lat=1.298683, lon=-77.405608 where codigo='52381000';
update catalogos.geo set lat=8.618142, lon=-73.801723 where codigo='20383000';
update catalogos.geo set lat=0.423351, lon=-76.90469 where codigo='86865000';
update catalogos.geo set lat=9.561813, lon=-73.335306 where codigo='20400000';
update catalogos.geo set lat=10.510058, lon=-73.072439 where codigo='44420000';
update catalogos.geo set lat=1.472893, lon=-77.579936 where codigo='52385000';
update catalogos.geo set lat=2.182113, lon=-73.786899 where codigo='50350000';
update catalogos.geo set lat=6.186639, lon=-74.583314 where codigo='05585000';
update catalogos.geo set lat=5.397455, lon=-75.5465 where codigo='17388000';
update catalogos.geo set lat=4.634001, lon=-74.456026 where codigo='25386000';
update catalogos.geo set lat=1.48826, lon=-75.4361 where codigo='18410000';
update catalogos.geo set lat=5.358902, lon=-74.39092 where codigo='25394000';
update catalogos.geo set lat=6.178557, lon=-73.589583 where codigo='68397000';
update catalogos.geo set lat=-1.322433, lon=-69.578386 where codigo='91407000';
update catalogos.geo set lat=5.198944, lon=-74.393987 where codigo='25398000';
update catalogos.geo set lat=5.74664, lon=-75.605325 where codigo='05390000';
update catalogos.geo set lat=2.389177, lon=-75.890802 where codigo='41396000';
update catalogos.geo set lat=8.214093, lon=-73.237772 where codigo='54398000';
update catalogos.geo set lat=5.491223, lon=-70.413012 where codigo='99524000';
update catalogos.geo set lat=6.127979, lon=-72.334178 where codigo='85136000';
update catalogos.geo set lat=2.178652, lon=-76.763073 where codigo='19392000';
update catalogos.geo set lat=4.454604, lon=-75.788557 where codigo='63401000';
update catalogos.geo set lat=2.399197, lon=-78.190126 where codigo='52390000';
update catalogos.geo set lat=5.974296, lon=-75.360585 where codigo='05400000';
update catalogos.geo set lat=4.534466, lon=-76.10344 where codigo='76400000';
update catalogos.geo set lat=1.598962, lon=-77.130599 where codigo='52399000';
update catalogos.geo set lat=8.853566, lon=-75.282551 where codigo='70400000';
update catalogos.geo set lat=3.239735, lon=-74.351977 where codigo='50370000';
update catalogos.geo set lat=6.316941, lon=-72.559636 where codigo='15403000';
update catalogos.geo set lat=2.002863, lon=-76.779788 where codigo='19397000';
update catalogos.geo set lat=4.995065, lon=-74.336376 where codigo='25402000';
update catalogos.geo set lat=4.524423, lon=-76.036341 where codigo='76403000';
update catalogos.geo set lat=5.523507, lon=-74.234639 where codigo='15401000';
update catalogos.geo set lat=4.901048, lon=-75.878853 where codigo='66400000';
update catalogos.geo set lat=7.298391, lon=-72.496083 where codigo='54377000';
update catalogos.geo set lat=5.562616, lon=-72.578273 where codigo='15377000';
update catalogos.geo set lat=6.219376, lon=-73.809138 where codigo='68385000';
update catalogos.geo set lat=5.281264, lon=-76.629354 where codigo='27810000';
update catalogos.geo set lat=7.114318, lon=-73.220546 where codigo='68406000';
update catalogos.geo set lat=1.935454, lon=-77.302986 where codigo='52405000';
update catalogos.geo set lat=3.526079, lon=-74.024714 where codigo='50400000';
update catalogos.geo set lat=5.306457, lon=-73.711574 where codigo='25407000';
update catalogos.geo set lat=4.860833, lon=-74.911716 where codigo='73408000';
update catalogos.geo set lat=-4.2032, lon=-69.945488 where codigo='91001000';
update catalogos.geo set lat=4.920319, lon=-75.061791 where codigo='73411000';
update catalogos.geo set lat=6.677767, lon=-75.812145 where codigo='05411000';
update catalogos.geo set lat=1.351096, lon=-77.523491 where codigo='52411000';
update catalogos.geo set lat=5.499902, lon=-76.542532 where codigo='27413000';
update catalogos.geo set lat=9.239558, lon=-75.817797 where codigo='23417000';
update catalogos.geo set lat=8.905705, lon=-76.354687 where codigo='23419000';
update catalogos.geo set lat=9.380169, lon=-75.268141 where codigo='70418000';
update catalogos.geo set lat=7.83419, lon=-72.505913 where codigo='54405000';
update catalogos.geo set lat=6.755866, lon=-73.101821 where codigo='68418000';
update catalogos.geo set lat=7.944838, lon=-72.83209 where codigo='54418000';
update catalogos.geo set lat=10.610378, lon=-75.142752 where codigo='08421000';
update catalogos.geo set lat=4.972232, lon=-73.319634 where codigo='15425000';
update catalogos.geo set lat=6.506735, lon=-72.593281 where codigo='68425000';
update catalogos.geo set lat=6.552045, lon=-74.787853 where codigo='05425000';
update catalogos.geo set lat=5.080531, lon=-73.607258 where codigo='25426000';
update catalogos.geo set lat=4.732254, lon=-74.266278 where codigo='25430000';
update catalogos.geo set lat=9.240918, lon=-74.757519 where codigo='13430000';
update catalogos.geo set lat=10.234243, lon=-75.190074 where codigo='13433000';
update catalogos.geo set lat=11.378963, lon=-72.241366 where codigo='44430000';
update catalogos.geo set lat=8.541589, lon=-74.628417 where codigo='70429000';
update catalogos.geo set lat=6.702516, lon=-72.729436 where codigo='68432000';
update catalogos.geo set lat=10.855914, lon=-74.77226 where codigo='08433000';
update catalogos.geo set lat=10.448814, lon=-74.959655 where codigo='08436000';
update catalogos.geo set lat=11.773924, lon=-72.44758 where codigo='44560000';
update catalogos.geo set lat=4.81747, lon=-72.280906 where codigo='85139000';
update catalogos.geo set lat=5.060395, lon=-75.491456 where codigo='17001000';
update catalogos.geo set lat=5.009072, lon=-73.540946 where codigo='25436000';
update catalogos.geo set lat=5.254865, lon=-75.153284 where codigo='17433000';
update catalogos.geo set lat=2.892011, lon=-72.133237 where codigo='50325000';
update catalogos.geo set lat=9.162183, lon=-74.28847 where codigo='13440000';
update catalogos.geo set lat=9.98396, lon=-75.302024 where codigo='13442000';
update catalogos.geo set lat=6.17304, lon=-75.337801 where codigo='05440000';
update catalogos.geo set lat=5.549651, lon=-74.004617 where codigo='15442000';
update catalogos.geo set lat=5.200249, lon=-74.889191 where codigo='73443000';
update catalogos.geo set lat=5.474718, lon=-75.600449 where codigo='17442000';
update catalogos.geo set lat=5.299026, lon=-75.052703 where codigo='17444000';
update catalogos.geo set lat=4.937268, lon=-75.738812 where codigo='66440000';
update catalogos.geo set lat=5.284174, lon=-75.259824 where codigo='17446000';
update catalogos.geo set lat=7.322827, lon=-73.016178 where codigo='68444000';
update catalogos.geo set lat=6.249048, lon=-75.575787 where codigo='05001000';
update catalogos.geo set lat=4.508059, lon=-73.350439 where codigo='25438000';
update catalogos.geo set lat=4.204009, lon=-74.645176 where codigo='73449000';
update catalogos.geo set lat=1.797126, lon=-77.164775 where codigo='19450000';
update catalogos.geo set lat=3.382246, lon=-74.044357 where codigo='50330000';
update catalogos.geo set lat=2.845803, lon=-77.248175 where codigo='19418000';
update catalogos.geo set lat=1.290577, lon=-75.507486 where codigo='18460000';
update catalogos.geo set lat=5.196195, lon=-73.144605 where codigo='15455000';
update catalogos.geo set lat=1.336803, lon=-71.951239 where codigo='95200000';
update catalogos.geo set lat=3.251565, lon=-76.229502 where codigo='19455000';
update catalogos.geo set lat=5.297455, lon=-75.882162 where codigo='66456000';
update catalogos.geo set lat=1.254062, lon=-70.23361 where codigo='97001000';
update catalogos.geo set lat=1.150326, lon=-76.64994 where codigo='86001000';
update catalogos.geo set lat=6.474865, lon=-72.970789 where codigo='68464000';
update catalogos.geo set lat=6.673967, lon=-72.809012 where codigo='68468000';
update catalogos.geo set lat=9.240009, lon=-75.676458 where codigo='23464000';
update catalogos.geo set lat=9.238779, lon=-74.424254 where codigo='13468000';
update catalogos.geo set lat=5.752879, lon=-72.800213 where codigo='15464000';
update catalogos.geo set lat=5.723728, lon=-72.84909 where codigo='15466000';
update catalogos.geo set lat=5.876604, lon=-73.574141 where codigo='15469000';
update catalogos.geo set lat=5.946508, lon=-75.523761 where codigo='05467000';
update catalogos.geo set lat=8.295587, lon=-74.473899 where codigo='13458000';
update catalogos.geo set lat=7.977873, lon=-75.418474 where codigo='23466000';
update catalogos.geo set lat=4.566336, lon=-75.750675 where codigo='63470000';
update catalogos.geo set lat=8.75626, lon=-75.879005 where codigo='23001000';
update catalogos.geo set lat=4.877409, lon=-72.895843 where codigo='85162000';
update catalogos.geo set lat=9.246004, lon=-76.131595 where codigo='23500000';
update catalogos.geo set lat=8.275027, lon=-73.868475 where codigo='13473000';
update catalogos.geo set lat=2.753988, lon=-76.627863 where codigo='19473000';
update catalogos.geo set lat=1.486491, lon=-75.724375 where codigo='18479000';
update catalogos.geo set lat=9.33208, lon=-75.307384 where codigo='70473000';
update catalogos.geo set lat=2.509205, lon=-78.451287 where codigo='52473000';
update catalogos.geo set lat=5.577523, lon=-73.367695 where codigo='15476000';
update catalogos.geo set lat=4.874566, lon=-75.170761 where codigo='73461000';
update catalogos.geo set lat=6.976906, lon=-76.819999 where codigo='05475000';
update catalogos.geo set lat=7.24403, lon=-76.436542 where codigo='05480000';
update catalogos.geo set lat=6.224407, lon=-77.403782 where codigo='27075000';
update catalogos.geo set lat=7.30014, lon=-72.746775 where codigo='54480000';
update catalogos.geo set lat=5.531964, lon=-74.102952 where codigo='15480000';
update catalogos.geo set lat=5.610941, lon=-75.174932 where codigo='05483000';
update catalogos.geo set lat=4.397897, lon=-74.82856 where codigo='25483000';
update catalogos.geo set lat=2.54583, lon=-75.809167 where codigo='41483000';
update catalogos.geo set lat=3.624136, lon=-75.093061 where codigo='73483000';
update catalogos.geo set lat=8.088034, lon=-74.776787 where codigo='05495000';
update catalogos.geo set lat=8.425752, lon=-76.78497 where codigo='05490000';
update catalogos.geo set lat=5.166359, lon=-75.519919 where codigo='17486000';
update catalogos.geo set lat=2.935429, lon=-75.277781 where codigo='41001000';
update catalogos.geo set lat=5.067559, lon=-73.878677 where codigo='25486000';
update catalogos.geo set lat=4.306552, lon=-74.619758 where codigo='25488000';
update catalogos.geo set lat=5.125529, lon=-74.386608 where codigo='25489000';
update catalogos.geo set lat=5.768811, lon=-72.93783 where codigo='15491000';
update catalogos.geo set lat=5.069499, lon=-74.37898 where codigo='25491000';
update catalogos.geo set lat=5.575539, lon=-74.888733 where codigo='17495000';
update catalogos.geo set lat=4.956036, lon=-76.607074 where codigo='27491000';
update catalogos.geo set lat=9.160648, lon=-75.048776 where codigo='70235000';
update catalogos.geo set lat=5.354931, lon=-73.457222 where codigo='15494000';
update catalogos.geo set lat=5.637793, lon=-72.194941 where codigo='85225000';
update catalogos.geo set lat=5.708556, lon=-77.26656 where codigo='27495000';
update catalogos.geo set lat=4.574891, lon=-75.973188 where codigo='76497000';
update catalogos.geo set lat=6.340048, lon=-73.122337 where codigo='68498000';
update catalogos.geo set lat=8.243639, lon=-73.354758 where codigo='54498000';
update catalogos.geo set lat=6.267568, lon=-73.300414 where codigo='68500000';
update catalogos.geo set lat=5.594394, lon=-73.308152 where codigo='15500000';
update catalogos.geo set lat=6.627493, lon=-75.812606 where codigo='05501000';
update catalogos.geo set lat=6.343861, lon=-72.812477 where codigo='68502000';
update catalogos.geo set lat=2.02549, lon=-75.995183 where codigo='41503000';
update catalogos.geo set lat=0.677514, lon=-76.880556 where codigo='86320000';
update catalogos.geo set lat=4.789629, lon=-71.341123 where codigo='85230000';
update catalogos.geo set lat=3.935261, lon=-75.22072 where codigo='73504000';
update catalogos.geo set lat=1.058501, lon=-77.566014 where codigo='52506000';
update catalogos.geo set lat=4.089127, lon=-74.478041 where codigo='25506000';
update catalogos.geo set lat=5.657939, lon=-74.181323 where codigo='15507000';
update catalogos.geo set lat=9.525565, lon=-75.228625 where codigo='70508000';
update catalogos.geo set lat=5.14002, lon=-73.397364 where codigo='15511000';
update catalogos.geo set lat=5.131936, lon=-74.158038 where codigo='25513000';
update catalogos.geo set lat=5.528753, lon=-75.459827 where codigo='17513000';
update catalogos.geo set lat=3.223382, lon=-76.313779 where codigo='19513000';
update catalogos.geo set lat=5.10058, lon=-73.05217 where codigo='15514000';
update catalogos.geo set lat=2.44916, lon=-75.773293 where codigo='41518000';
update catalogos.geo set lat=8.958106, lon=-73.625385 where codigo='20517000';
update catalogos.geo set lat=5.48338, lon=-76.73925 where codigo='27600000';
update catalogos.geo set lat=5.370769, lon=-74.15282 where codigo='25518000';
update catalogos.geo set lat=5.780318, lon=-73.116467 where codigo='15516000';
update catalogos.geo set lat=2.255215, lon=-76.61394 where codigo='19760000';
update catalogos.geo set lat=5.292936, lon=-72.702694 where codigo='15518000';
update catalogos.geo set lat=2.886357, lon=-75.433844 where codigo='41524000';
update catalogos.geo set lat=5.019128, lon=-75.6212 where codigo='17524000';
update catalogos.geo set lat=1.723444, lon=-76.132958 where codigo='41530000';
update catalogos.geo set lat=6.538242, lon=-73.291206 where codigo='68522000';
update catalogos.geo set lat=10.740795, lon=-74.753126 where codigo='08520000';
update catalogos.geo set lat=6.406012, lon=-73.288199 where codigo='68524000';
update catalogos.geo set lat=3.534416, lon=-76.298809 where codigo='76520000';
update catalogos.geo set lat=9.333208, lon=-75.541517 where codigo='70523000';
update catalogos.geo set lat=5.120428, lon=-75.023352 where codigo='73520000';
update catalogos.geo set lat=7.373884, lon=-72.648836 where codigo='54518000';
update catalogos.geo set lat=7.436762, lon=-72.63831 where codigo='54520000';
update catalogos.geo set lat=4.190807, lon=-74.486732 where codigo='25524000';
update catalogos.geo set lat=6.443281, lon=-72.459143 where codigo='15522000';
update catalogos.geo set lat=6.416706, lon=-73.170284 where codigo='68533000';
update catalogos.geo set lat=4.375658, lon=-73.212735 where codigo='25530000';
update catalogos.geo set lat=4.308744, lon=-74.302329 where codigo='25535000';
update catalogos.geo set lat=5.656521, lon=-73.978624 where codigo='15531000';
update catalogos.geo set lat=5.626193, lon=-72.42221 where codigo='15533000';
update catalogos.geo set lat=1.766101, lon=-78.184229 where codigo='52427000';
update catalogos.geo set lat=5.881163, lon=-71.893149 where codigo='85250000';
update catalogos.geo set lat=5.987302, lon=-72.748476 where codigo='15537000';
update catalogos.geo set lat=10.188485, lon=-74.916517 where codigo='47541000';
update catalogos.geo set lat=8.688072, lon=-73.665523 where codigo='20550000';
update catalogos.geo set lat=5.382568, lon=-75.160886 where codigo='17541000';
update catalogos.geo set lat=6.221736, lon=-75.212538 where codigo='05541000';
update catalogos.geo set lat=7.02178, lon=-75.908322 where codigo='05543000';
update catalogos.geo set lat=4.807123, lon=-75.716662 where codigo='66001000';
update catalogos.geo set lat=5.558575, lon=-73.050977 where codigo='15542000';
update catalogos.geo set lat=5.516077, lon=-76.974643 where codigo='27025000';
update catalogos.geo set lat=6.99267, lon=-73.053295 where codigo='68547000';
update catalogos.geo set lat=1.140818, lon=-77.864597 where codigo='52435000';
update catalogos.geo set lat=4.542941, lon=-74.878879 where codigo='73547000';
update catalogos.geo set lat=2.639625, lon=-76.530047 where codigo='19548000';
update catalogos.geo set lat=4.334448, lon=-75.703165 where codigo='63548000';
update catalogos.geo set lat=9.330387, lon=-74.453518 where codigo='47545000';
update catalogos.geo set lat=6.532676, lon=-73.172878 where codigo='68549000';
update catalogos.geo set lat=8.914983, lon=-74.462309 where codigo='13549000';
update catalogos.geo set lat=10.748313, lon=-75.108163 where codigo='08549000';
update catalogos.geo set lat=5.722716, lon=-72.484376 where codigo='15550000';
update catalogos.geo set lat=2.266736, lon=-75.80483 where codigo='41548000';
update catalogos.geo set lat=1.854622, lon=-76.049606 where codigo='41551000';
update catalogos.geo set lat=10.462266, lon=-74.615523 where codigo='47551000';
update catalogos.geo set lat=4.953453, lon=-77.365996 where codigo='27077000';
update catalogos.geo set lat=3.196978, lon=-75.643703 where codigo='73555000';
update catalogos.geo set lat=8.407639, lon=-75.584037 where codigo='23555000';
update catalogos.geo set lat=9.79249, lon=-74.784794 where codigo='47555000';
update catalogos.geo set lat=1.62846, lon=-77.459877 where codigo='52540000';
update catalogos.geo set lat=10.777752, lon=-74.853734 where codigo='08558000';
update catalogos.geo set lat=10.64186, lon=-74.752443 where codigo='08560000';
update catalogos.geo set lat=2.457484, lon=-76.597928 where codigo='19001000';
update catalogos.geo set lat=5.727435, lon=-71.99284 where codigo='85263000';
update catalogos.geo set lat=0.806717, lon=-77.572467 where codigo='52560000';
update catalogos.geo set lat=3.419086, lon=-76.240861 where codigo='76563000';
update catalogos.geo set lat=3.750575, lon=-74.927621 where codigo='73563000';
update catalogos.geo set lat=13.37462, lon=-81.370282 where codigo='88564000';
update catalogos.geo set lat=1.239098, lon=-77.597413 where codigo='52565000';
update catalogos.geo set lat=10.417795, lon=-73.586042 where codigo='20570000';
update catalogos.geo set lat=8.502609, lon=-75.508174 where codigo='23570000';
update catalogos.geo set lat=5.222033, lon=-76.030806 where codigo='66572000';
update catalogos.geo set lat=5.793685, lon=-75.838974 where codigo='05576000';
update catalogos.geo set lat=10.99257, lon=-74.284292 where codigo='47570000';
update catalogos.geo set lat=5.87773, lon=-73.677451 where codigo='68572000';
update catalogos.geo set lat=0.885121, lon=-77.504249 where codigo='52573000';
update catalogos.geo set lat=-1.005489, lon=-74.014316 where codigo='91530000';
update catalogos.geo set lat=-2.149536, lon=-71.754587 where codigo='91536000';
update catalogos.geo set lat=0.501586, lon=-76.499127 where codigo='86568000';
update catalogos.geo set lat=6.485489, lon=-74.406266 where codigo='05579000';
update catalogos.geo set lat=5.974973, lon=-74.581673 where codigo='15572000';
update catalogos.geo set lat=0.684157, lon=-76.604409 where codigo='86569000';
update catalogos.geo set lat=6.183899, lon=-67.488244 where codigo='99001000';
update catalogos.geo set lat=10.997705, lon=-74.950238 where codigo='08573000';
update catalogos.geo set lat=2.623797, lon=-72.757087 where codigo='50450000';
update catalogos.geo set lat=9.003632, lon=-76.26144 where codigo='23574000';
update catalogos.geo set lat=4.312037, lon=-72.082951 where codigo='50568000';
update catalogos.geo set lat=0.963488, lon=-76.407975 where codigo='86571000';
update catalogos.geo set lat=-0.18571, lon=-74.783415 where codigo='86573000';
update catalogos.geo set lat=7.889227, lon=-75.672013 where codigo='23580000';
update catalogos.geo set lat=3.271892, lon=-73.372549 where codigo='50577000';
update catalogos.geo set lat=4.09286, lon=-72.955854 where codigo='50573000';
update catalogos.geo set lat=-3.789897, lon=-70.356425 where codigo='91540000';
update catalogos.geo set lat=6.651469, lon=-74.056448 where codigo='68573000';
update catalogos.geo set lat=1.910952, lon=-75.156371 where codigo='18592000';
update catalogos.geo set lat=2.941654, lon=-73.207474 where codigo='50590000';
update catalogos.geo set lat=6.281095, lon=-71.101834 where codigo='81591000';
update catalogos.geo set lat=5.464967, lon=-74.654727 where codigo='25572000';
update catalogos.geo set lat=-0.62229, lon=-72.383241 where codigo='91669000';
update catalogos.geo set lat=8.361551, lon=-72.408608 where codigo='54553000';
update catalogos.geo set lat=3.220933, lon=-76.415572 where codigo='19573000';
update catalogos.geo set lat=5.884409, lon=-74.638761 where codigo='05591000';
update catalogos.geo set lat=7.345732, lon=-73.899973 where codigo='68575000';
update catalogos.geo set lat=4.681871, lon=-74.714212 where codigo='25580000';
update catalogos.geo set lat=10.170212, lon=-74.71747 where codigo='47960000';
update catalogos.geo set lat=0.870633, lon=-77.636767 where codigo='52585000';
update catalogos.geo set lat=3.858175, lon=-74.930821 where codigo='73585000';
update catalogos.geo set lat=9.237875, lon=-75.72252 where codigo='23586000';
update catalogos.geo set lat=5.117887, lon=-74.479338 where codigo='25592000';
update catalogos.geo set lat=4.329833, lon=-73.86306 where codigo='25594000';
update catalogos.geo set lat=4.623661, lon=-75.76385 where codigo='63594000';
update catalogos.geo set lat=5.340643, lon=-75.7306 where codigo='66594000';
update catalogos.geo set lat=5.522932, lon=-74.181249 where codigo='15580000';
update catalogos.geo set lat=4.74496, lon=-74.533461 where codigo='25596000';
update catalogos.geo set lat=4.520511, lon=-74.593825 where codigo='25599000';
update catalogos.geo set lat=7.577657, lon=-72.475625 where codigo='54599000';
update catalogos.geo set lat=5.401271, lon=-73.335824 where codigo='15599000';
update catalogos.geo set lat=5.53887, lon=-73.632219 where codigo='15600000';
update catalogos.geo set lat=5.229421, lon=-72.760867 where codigo='85279000';
update catalogos.geo set lat=8.665059, lon=-73.822453 where codigo='13580000';
update catalogos.geo set lat=7.02795, lon=-74.691937 where codigo='05604000';
update catalogos.geo set lat=10.702835, lon=-74.716632 where codigo='47605000';
update catalogos.geo set lat=10.4947, lon=-75.124557 where codigo='08606000';
update catalogos.geo set lat=4.261552, lon=-73.563037 where codigo='50606000';
update catalogos.geo set lat=3.823013, lon=-76.520837 where codigo='76606000';
update catalogos.geo set lat=6.061276, lon=-75.502296 where codigo='05607000';
update catalogos.geo set lat=4.282281, lon=-74.773085 where codigo='25612000';
update catalogos.geo set lat=1.213147, lon=-77.996054 where codigo='52612000';
update catalogos.geo set lat=9.490923, lon=-75.356258 where codigo='70204000';
update catalogos.geo set lat=8.292291, lon=-73.386346 where codigo='20614000';
update catalogos.geo set lat=8.587969, lon=-73.839632 where codigo='13600000';
update catalogos.geo set lat=3.53017, lon=-75.644616 where codigo='73616000';
update catalogos.geo set lat=4.156634, lon=-76.288263 where codigo='76616000';
update catalogos.geo set lat=11.538185, lon=-72.910324 where codigo='44001000';
update catalogos.geo set lat=6.146238, lon=-75.376158 where codigo='05615000';
update catalogos.geo set lat=7.264597, lon=-73.15028 where codigo='68615000';
update catalogos.geo set lat=7.436058, lon=-77.11287 where codigo='27615000';
update catalogos.geo set lat=5.423955, lon=-75.7023 where codigo='17614000';
update catalogos.geo set lat=5.163661, lon=-75.767851 where codigo='17616000';
update catalogos.geo set lat=2.777912, lon=-75.258269 where codigo='41615000';
update catalogos.geo set lat=10.387382, lon=-73.172048 where codigo='20621000';
update catalogos.geo set lat=4.413283, lon=-76.15202 where codigo='76622000';
update catalogos.geo set lat=4.011182, lon=-75.606091 where codigo='73622000';
update catalogos.geo set lat=5.356984, lon=-73.208294 where codigo='15621000';
update catalogos.geo set lat=2.260951, lon=-76.740193 where codigo='19622000';
update catalogos.geo set lat=4.239388, lon=-75.240379 where codigo='73624000';
update catalogos.geo set lat=7.393906, lon=-73.499886 where codigo='68655000';
update catalogos.geo set lat=10.788984, lon=-74.754287 where codigo='08634000';
update catalogos.geo set lat=6.853474, lon=-75.814178 where codigo='05628000';
update catalogos.geo set lat=10.631003, lon=-74.915558 where codigo='08638000';
update catalogos.geo set lat=4.8534, lon=-73.039109 where codigo='85300000';
update catalogos.geo set lat=6.151485, lon=-75.615466 where codigo='05631000';
update catalogos.geo set lat=5.698132, lon=-73.764469 where codigo='15632000';
update catalogos.geo set lat=6.098533, lon=-72.248123 where codigo='85315000';
update catalogos.geo set lat=5.583028, lon=-73.542471 where codigo='15638000';
update catalogos.geo set lat=8.94372, lon=-75.445485 where codigo='23660000';
update catalogos.geo set lat=1.993106, lon=-76.045037 where codigo='41660000';
update catalogos.geo set lat=2.039872, lon=-78.65814 where codigo='52520000';
update catalogos.geo set lat=5.404497, lon=-75.487296 where codigo='17653000';
update catalogos.geo set lat=10.490463, lon=-74.794015 where codigo='47675000';
update catalogos.geo set lat=7.772695, lon=-72.809536 where codigo='54660000';
update catalogos.geo set lat=3.928988, lon=-75.017083 where codigo='73671000';
update catalogos.geo set lat=4.637509, lon=-75.570599 where codigo='63690000';
update catalogos.geo set lat=5.963568, lon=-75.97646 where codigo='05642000';
update catalogos.geo set lat=5.492653, lon=-73.486294 where codigo='15646000';
update catalogos.geo set lat=5.413017, lon=-74.992175 where codigo='17662000';
update catalogos.geo set lat=1.333882, lon=-77.592063 where codigo='52678000';
update catalogos.geo set lat=9.182089, lon=-75.379154 where codigo='70670000';
update catalogos.geo set lat=1.879911, lon=-76.270053 where codigo='41668000';
update catalogos.geo set lat=7.761071, lon=-73.393283 where codigo='20710000';
update catalogos.geo set lat=6.913517, lon=-75.675701 where codigo='05647000';
update catalogos.geo set lat=12.580129, lon=-81.706689 where codigo='88001000';
update catalogos.geo set lat=6.812504, lon=-72.848861 where codigo='68669000';
update catalogos.geo set lat=9.145177, lon=-75.509173 where codigo='23670000';
update catalogos.geo set lat=10.031828, lon=-74.214331 where codigo='47660000';
update catalogos.geo set lat=9.373221, lon=-75.759384 where codigo='23672000';
update catalogos.geo set lat=3.914246, lon=-75.479259 where codigo='73675000';
update catalogos.geo set lat=4.615995, lon=-74.352035 where codigo='25645000';
update catalogos.geo set lat=6.126512, lon=-73.509597 where codigo='68673000';
update catalogos.geo set lat=8.929463, lon=-75.031024 where codigo='70678000';
update catalogos.geo set lat=4.17917, lon=-74.422986 where codigo='25649000';
update catalogos.geo set lat=1.514392, lon=-77.047025 where codigo='52685000';
update catalogos.geo set lat=9.353217, lon=-75.953447 where codigo='23675000';
update catalogos.geo set lat=8.401292, lon=-73.208692 where codigo='54670000';
update catalogos.geo set lat=6.187922, lon=-74.993399 where codigo='05649000';
update catalogos.geo set lat=8.798902, lon=-75.699103 where codigo='23678000';
update catalogos.geo set lat=3.71037, lon=-73.241527 where codigo='50680000';
update catalogos.geo set lat=5.301217, lon=-74.06972 where codigo='25653000';
update catalogos.geo set lat=7.877509, lon=-72.624411 where codigo='54673000';
update catalogos.geo set lat=10.394388, lon=-75.064806 where codigo='13620000';
update catalogos.geo set lat=10.333638, lon=-73.180675 where codigo='20750000';
update catalogos.geo set lat=5.224298, lon=-73.077192 where codigo='15660000';
update catalogos.geo set lat=10.398311, lon=-75.150934 where codigo='13647000';
update catalogos.geo set lat=1.898552, lon=-67.079525 where codigo='94883000';
update catalogos.geo set lat=9.216687, lon=-74.329528 where codigo='13650000';
update catalogos.geo set lat=1.176699, lon=-76.875836 where codigo='86755000';
update catalogos.geo set lat=5.963639, lon=-75.102017 where codigo='05652000';
update catalogos.geo set lat=4.973928, lon=-74.290026 where codigo='25658000';
update catalogos.geo set lat=5.688842, lon=-76.653682 where codigo='27001000';
update catalogos.geo set lat=6.555387, lon=-73.134636 where codigo='68679000';
update catalogos.geo set lat=9.829583, lon=-75.121864 where codigo='13654000';
update catalogos.geo set lat=8.249632, lon=-74.722309 where codigo='13655000';
update catalogos.geo set lat=6.442591, lon=-75.727616 where codigo='05656000';
update catalogos.geo set lat=6.427553, lon=-72.867654 where codigo='68682000';
update catalogos.geo set lat=1.473903, lon=-77.081196 where codigo='52019000';
update catalogos.geo set lat=5.080993, lon=-75.791967 where codigo='17665000';
update catalogos.geo set lat=1.696966, lon=-78.244601 where codigo='52621000';
update catalogos.geo set lat=1.930159, lon=-76.215679 where codigo='41359000';
update catalogos.geo set lat=6.849681, lon=-75.684096 where codigo='05658000';
update catalogos.geo set lat=6.658578, lon=-72.733469 where codigo='68684000';
update catalogos.geo set lat=6.019477, lon=-73.547129 where codigo='15664000';
update catalogos.geo set lat=1.331667, lon=-75.97361 where codigo='18610000';
update catalogos.geo set lat=2.566985, lon=-72.638259 where codigo='95001000';
update catalogos.geo set lat=4.896159, lon=-76.234301 where codigo='27660000';
update catalogos.geo set lat=3.372349, lon=-73.874997 where codigo='50683000';
update catalogos.geo set lat=9.274193, lon=-75.242996 where codigo='70702000';
update catalogos.geo set lat=1.21111, lon=-77.278047 where codigo='52001000';
update catalogos.geo set lat=4.846969, lon=-74.621643 where codigo='25662000';
update catalogos.geo set lat=8.760056, lon=-76.527663 where codigo='05659000';
update catalogos.geo set lat=10.770142, lon=-73.002349 where codigo='44650000';
update catalogos.geo set lat=9.951115, lon=-75.084021 where codigo='13657000';
update catalogos.geo set lat=4.458224, lon=-73.676297 where codigo='50686000';
update catalogos.geo set lat=1.503119, lon=-77.215337 where codigo='52687000';
update catalogos.geo set lat=6.042809, lon=-74.994403 where codigo='05660000';
update catalogos.geo set lat=4.133104, lon=-75.09512 where codigo='73678000';
update catalogos.geo set lat=3.794206, lon=-73.83895 where codigo='50223000';
update catalogos.geo set lat=4.819387, lon=-73.169174 where codigo='15667000';
update catalogos.geo set lat=5.421925, lon=-71.73101 where codigo='85325000';
update catalogos.geo set lat=8.661826, lon=-75.13077 where codigo='70708000';
update catalogos.geo set lat=8.003835, lon=-73.512436 where codigo='20770000';
update catalogos.geo set lat=3.701612, lon=-73.695964 where codigo='50689000';
update catalogos.geo set lat=8.938493, lon=-74.037868 where codigo='13667000';
update catalogos.geo set lat=6.40181, lon=-72.554943 where codigo='15673000';
update catalogos.geo set lat=6.576646, lon=-72.645971 where codigo='68686000';
update catalogos.geo set lat=5.517725, lon=-73.722065 where codigo='15676000';
update catalogos.geo set lat=9.736483, lon=-75.52498 where codigo='70713000';
update catalogos.geo set lat=7.477779, lon=-73.924103 where codigo='13670000';
update catalogos.geo set lat=1.669115, lon=-77.012663 where codigo='52693000';
update catalogos.geo set lat=5.659004, lon=-74.066634 where codigo='15681000';
update catalogos.geo set lat=6.461216, lon=-75.56083 where codigo='05664000';
update catalogos.geo set lat=9.396161, lon=-75.063864 where codigo='70717000';
update catalogos.geo set lat=3.976816, lon=-76.228611 where codigo='76670000';
update catalogos.geo set lat=1.552455, lon=-77.120019 where codigo='52694000';
update catalogos.geo set lat=8.276419, lon=-76.379899 where codigo='05665000';
update catalogos.geo set lat=8.9581, lon=-75.835441 where codigo='23686000';
update catalogos.geo set lat=6.293719, lon=-75.027908 where codigo='05667000';
update catalogos.geo set lat=6.485647, lon=-75.019504 where codigo='05670000';
update catalogos.geo set lat=1.838631, lon=-76.769767 where codigo='19693000';
update catalogos.geo set lat=9.23972, lon=-74.351554 where codigo='47692000';
update catalogos.geo set lat=6.285659, lon=-75.332669 where codigo='05674000';
update catalogos.geo set lat=6.878698, lon=-73.411676 where codigo='68689000';
update catalogos.geo set lat=2.113329, lon=-74.771906 where codigo='18753000';
update catalogos.geo set lat=9.244844, lon=-74.498431 where codigo='47703000';
update catalogos.geo set lat=1.283978, lon=-77.471625 where codigo='52683000';
update catalogos.geo set lat=9.322869, lon=-74.569658 where codigo='47707000';
update catalogos.geo set lat=5.874215, lon=-75.566653 where codigo='05679000';
update catalogos.geo set lat=6.990473, lon=-72.906842 where codigo='68705000';
update catalogos.geo set lat=9.431249, lon=-74.705607 where codigo='47720000';
update catalogos.geo set lat=10.604398, lon=-75.288053 where codigo='13673000';
update catalogos.geo set lat=4.645904, lon=-74.105876 where codigo='11001000';
update catalogos.geo set lat=4.258119, lon=-77.364924 where codigo='27250000';
update catalogos.geo set lat=6.338763, lon=-73.616366 where codigo='68720000';
update catalogos.geo set lat=4.714124, lon=-75.097747 where codigo='73686000';
update catalogos.geo set lat=10.324403, lon=-74.961081 where codigo='08675000';
update catalogos.geo set lat=4.858859, lon=-73.262914 where codigo='15690000';
update catalogos.geo set lat=2.939165, lon=-75.585924 where codigo='41676000';
update catalogos.geo set lat=11.22984, lon=-74.195511 where codigo='47001000';
update catalogos.geo set lat=10.445291, lon=-75.369162 where codigo='13683000';
update catalogos.geo set lat=1.702975, lon=-76.573761 where codigo='19701000';
update catalogos.geo set lat=4.877614, lon=-75.624383 where codigo='66682000';
update catalogos.geo set lat=6.642368, lon=-75.460639 where codigo='05686000';
update catalogos.geo set lat=5.874644, lon=-72.982507 where codigo='15693000';
update catalogos.geo set lat=7.963484, lon=-74.050637 where codigo='13688000';
update catalogos.geo set lat=5.135708, lon=-70.862929 where codigo='99624000';
update catalogos.geo set lat=5.714077, lon=-73.602093 where codigo='15696000';
update catalogos.geo set lat=6.559093, lon=-75.826809 where codigo='05042000';
update catalogos.geo set lat=6.057455, lon=-73.482163 where codigo='15686000';
update catalogos.geo set lat=3.011699, lon=-76.484291 where codigo='19698000';
update catalogos.geo set lat=7.864361, lon=-72.717325 where codigo='54680000';
update catalogos.geo set lat=1.146532, lon=-77.002455 where codigo='86760000';
update catalogos.geo set lat=3.418401, lon=-76.524459 where codigo='76001000';
update catalogos.geo set lat=6.47246, lon=-75.165406 where codigo='05690000';
update catalogos.geo set lat=10.760691, lon=-74.75637 where codigo='08685000';
update catalogos.geo set lat=5.074593, lon=-75.964211 where codigo='66687000';
update catalogos.geo set lat=1.037686, lon=-77.620918 where codigo='52720000';
update catalogos.geo set lat=6.95317, lon=-71.87462 where codigo='81736000';
update catalogos.geo set lat=8.084244, lon=-72.800084 where codigo='54720000';
update catalogos.geo set lat=4.962812, lon=-74.43359 where codigo='25718000';
update catalogos.geo set lat=6.131358, lon=-72.708191 where codigo='15720000';
update catalogos.geo set lat=6.093519, lon=-72.712161 where codigo='15723000';
update catalogos.geo set lat=7.079862, lon=-74.699314 where codigo='05736000';
update catalogos.geo set lat=5.045057, lon=-73.796971 where codigo='25736000';
update catalogos.geo set lat=4.270262, lon=-75.932035 where codigo='76736000';
update catalogos.geo set lat=5.511317, lon=-73.244781 where codigo='15740000';
update catalogos.geo set lat=4.487762, lon=-74.259759 where codigo='25740000';
update catalogos.geo set lat=1.203119, lon=-76.920939 where codigo='86749000';
update catalogos.geo set lat=7.204557, lon=-72.756757 where codigo='54743000';
update catalogos.geo set lat=4.387728, lon=-74.399372 where codigo='25743000';
update catalogos.geo set lat=2.611508, lon=-76.378423 where codigo='19743000';
update catalogos.geo set lat=6.443472, lon=-73.33742 where codigo='68745000';
update catalogos.geo set lat=5.503302, lon=-73.852303 where codigo='25745000';
update catalogos.geo set lat=7.957401, lon=-73.946094 where codigo='13744000';
update catalogos.geo set lat=9.244699, lon=-75.147087 where codigo='70742000';
update catalogos.geo set lat=9.298231, lon=-75.396674 where codigo='70001000';
update catalogos.geo set lat=4.653166, lon=-76.644083 where codigo='27745000';
update catalogos.geo set lat=10.781045, lon=-74.723423 where codigo='47745000';
update catalogos.geo set lat=4.577739, lon=-74.212403 where codigo='25754000';
update catalogos.geo set lat=6.333274, lon=-72.683097 where codigo='15753000';
update catalogos.geo set lat=5.996955, lon=-72.691441 where codigo='15757000';
update catalogos.geo set lat=6.466986, lon=-73.26262 where codigo='68755000';
update catalogos.geo set lat=6.041206, lon=-72.636586 where codigo='15755000';
update catalogos.geo set lat=5.72663, lon=-72.923853 where codigo='15759000';
update catalogos.geo set lat=0.699095, lon=-75.253313 where codigo='18756000';
update catalogos.geo set lat=10.910862, lon=-74.782343 where codigo='08758000';
update catalogos.geo set lat=4.985985, lon=-73.433051 where codigo='15761000';
update catalogos.geo set lat=5.71247, lon=-75.310222 where codigo='05756000';
update catalogos.geo set lat=6.501627, lon=-75.746116 where codigo='05761000';
update catalogos.geo set lat=10.390439, lon=-75.136277 where codigo='13760000';
update catalogos.geo set lat=4.908893, lon=-73.940201 where codigo='25758000';
update catalogos.geo set lat=5.566814, lon=-73.44992 where codigo='15762000';
update catalogos.geo set lat=5.501092, lon=-73.332865 where codigo='15764000';
update catalogos.geo set lat=5.765149, lon=-73.24726 where codigo='15763000';
update catalogos.geo set lat=1.494174, lon=-77.521022 where codigo='52418000';
update catalogos.geo set lat=6.098413, lon=-73.44288 where codigo='68770000';
update catalogos.geo set lat=10.333428, lon=-74.880229 where codigo='08770000';
update catalogos.geo set lat=4.04749, lon=-74.831904 where codigo='73770000';
update catalogos.geo set lat=2.954433, lon=-76.694983 where codigo='19780000';
update catalogos.geo set lat=1.976851, lon=-75.794314 where codigo='41770000';
update catalogos.geo set lat=4.929016, lon=-74.172595 where codigo='25769000';
update catalogos.geo set lat=2.038351, lon=-76.925233 where codigo='19785000';
update catalogos.geo set lat=5.918367, lon=-73.791441 where codigo='68773000';
update catalogos.geo set lat=8.81383, lon=-74.722826 where codigo='70771000';
update catalogos.geo set lat=5.103714, lon=-73.798406 where codigo='25772000';
update catalogos.geo set lat=5.06191, lon=-74.235968 where codigo='25777000';
update catalogos.geo set lat=5.445711, lon=-75.649439 where codigo='17777000';
update catalogos.geo set lat=7.36672, lon=-72.98414 where codigo='68780000';
update catalogos.geo set lat=5.454449, lon=-73.814265 where codigo='25779000';
update catalogos.geo set lat=6.230938, lon=-72.689659 where codigo='15774000';
update catalogos.geo set lat=5.619931, lon=-73.620647 where codigo='15776000';
update catalogos.geo set lat=5.247307, lon=-73.853035 where codigo='25781000';
update catalogos.geo set lat=5.023174, lon=-73.452165 where codigo='15778000';
update catalogos.geo set lat=4.917148, lon=-74.097049 where codigo='25785000';
update catalogos.geo set lat=5.26441, lon=-76.55893 where codigo='27787000';
update catalogos.geo set lat=9.302818, lon=-74.567164 where codigo='13780000';
update catalogos.geo set lat=8.861851, lon=-73.81165 where codigo='20787000';
update catalogos.geo set lat=5.829817, lon=-72.162999 where codigo='85400000';
update catalogos.geo set lat=6.457027, lon=-71.742179 where codigo='81794000';
update catalogos.geo set lat=5.665211, lon=-75.713985 where codigo='05789000';
update catalogos.geo set lat=1.570085, lon=-77.280678 where codigo='52786000';
update catalogos.geo set lat=1.094503, lon=-77.394381 where codigo='52788000';
update catalogos.geo set lat=-0.564677, lon=-69.634022 where codigo='97666000';
update catalogos.geo set lat=-2.891354, lon=-69.7416 where codigo='91798000';
update catalogos.geo set lat=7.582331, lon=-75.399979 where codigo='05790000';
update catalogos.geo set lat=2.111653, lon=-75.823731 where codigo='41791000';
update catalogos.geo set lat=5.865171, lon=-75.822536 where codigo='05792000';
update catalogos.geo set lat=5.909945, lon=-72.781241 where codigo='15790000';
update catalogos.geo set lat=5.013379, lon=-72.750716 where codigo='85410000';
update catalogos.geo set lat=5.19602, lon=-73.886748 where codigo='25793000';
update catalogos.geo set lat=3.067292, lon=-75.138899 where codigo='41799000';
update catalogos.geo set lat=4.655436, lon=-74.389338 where codigo='25797000';
update catalogos.geo set lat=9.898614, lon=-74.858377 where codigo='47798000';
update catalogos.geo set lat=4.871869, lon=-74.14593 where codigo='25799000';
update catalogos.geo set lat=5.077093, lon=-73.421749 where codigo='15798000';
update catalogos.geo set lat=8.437257, lon=-73.28705 where codigo='54800000';
update catalogos.geo set lat=2.741596, lon=-75.568345 where codigo='41801000';
update catalogos.geo set lat=2.485956, lon=-75.727363 where codigo='41797000';
update catalogos.geo set lat=4.347743, lon=-74.45272 where codigo='25805000';
update catalogos.geo set lat=5.316163, lon=-73.396783 where codigo='15804000';
update catalogos.geo set lat=5.747277, lon=-72.999808 where codigo='15806000';
update catalogos.geo set lat=5.052422, lon=-73.504694 where codigo='25807000';
update catalogos.geo set lat=8.639734, lon=-72.73594 where codigo='54810000';
update catalogos.geo set lat=8.171878, lon=-76.06017 where codigo='23807000';
update catalogos.geo set lat=1.974193, lon=-75.932456 where codigo='41807000';
update catalogos.geo set lat=2.350475, lon=-76.683161 where codigo='19807000';
update catalogos.geo set lat=2.777236, lon=-77.668182 where codigo='19809000';
update catalogos.geo set lat=5.579042, lon=-73.647227 where codigo='15808000';
update catalogos.geo set lat=6.419622, lon=-72.692276 where codigo='15810000';
update catalogos.geo set lat=8.555815, lon=-74.265547 where codigo='13810000';
update catalogos.geo set lat=6.063957, lon=-75.789429 where codigo='05809000';
update catalogos.geo set lat=5.565177, lon=-73.184518 where codigo='15814000';
update catalogos.geo set lat=4.460391, lon=-74.636726 where codigo='25815000';
update catalogos.geo set lat=4.965724, lon=-73.912004 where codigo='25817000';
update catalogos.geo set lat=5.937747, lon=-73.513431 where codigo='15816000';
update catalogos.geo set lat=7.010285, lon=-75.69218 where codigo='05819000';
update catalogos.geo set lat=7.307922, lon=-72.482253 where codigo='54820000';
update catalogos.geo set lat=9.525846, lon=-75.581041 where codigo='70820000';
update catalogos.geo set lat=9.45347, lon=-75.439298 where codigo='70823000';
update catalogos.geo set lat=7.202027, lon=-72.966375 where codigo='68820000';
update catalogos.geo set lat=5.768851, lon=-72.832169 where codigo='15820000';
update catalogos.geo set lat=5.335643, lon=-74.301808 where codigo='25823000';
update catalogos.geo set lat=2.954565, lon=-76.270025 where codigo='19821000';
update catalogos.geo set lat=4.608706, lon=-76.077781 where codigo='76823000';
update catalogos.geo set lat=5.560392, lon=-72.986222 where codigo='15822000';
update catalogos.geo set lat=2.510173, lon=-76.40153 where codigo='19824000';
update catalogos.geo set lat=5.407831, lon=-71.661702 where codigo='85430000';
update catalogos.geo set lat=4.21221, lon=-76.318677 where codigo='76828000';
update catalogos.geo set lat=10.874049, lon=-74.977943 where codigo='08832000';
update catalogos.geo set lat=4.086843, lon=-76.196261 where codigo='76834000';
update catalogos.geo set lat=1.790488, lon=-78.774162 where codigo='52835000';
update catalogos.geo set lat=5.542103, lon=-73.356045 where codigo='15001000';
update catalogos.geo set lat=5.730391, lon=-73.933075 where codigo='15832000';
update catalogos.geo set lat=1.086612, lon=-77.617794 where codigo='52838000';
update catalogos.geo set lat=10.332203, lon=-75.412831 where codigo='13836000';
update catalogos.geo set lat=10.273664, lon=-75.441779 where codigo='13838000';
update catalogos.geo set lat=8.089928, lon=-76.731808 where codigo='05837000';
update catalogos.geo set lat=5.323187, lon=-73.491423 where codigo='15835000';
update catalogos.geo set lat=5.690097, lon=-73.2283 where codigo='15837000';
update catalogos.geo set lat=6.032425, lon=-72.856379 where codigo='15839000';
update catalogos.geo set lat=4.747081, lon=-73.531896 where codigo='25839000';
update catalogos.geo set lat=4.483911, lon=-73.934222 where codigo='25841000';
update catalogos.geo set lat=5.308274, lon=-73.815773 where codigo='25843000';
update catalogos.geo set lat=4.702806, lon=-75.738765 where codigo='76845000';
update catalogos.geo set lat=5.217608, lon=-73.456922 where codigo='15842000';
update catalogos.geo set lat=4.402522, lon=-74.025332 where codigo='25845000';
update catalogos.geo set lat=8.045983, lon=-77.094248 where codigo='27800000';
update catalogos.geo set lat=6.898891, lon=-76.173346 where codigo='05842000';
update catalogos.geo set lat=11.715899, lon=-72.264414 where codigo='44847000';
update catalogos.geo set lat=6.313683, lon=-76.132102 where codigo='05847000';
update catalogos.geo set lat=10.559506, lon=-73.013193 where codigo='44855000';
update catalogos.geo set lat=10.742401, lon=-74.976629 where codigo='08849000';
update catalogos.geo set lat=5.187928, lon=-74.481319 where codigo='25851000';
update catalogos.geo set lat=7.163061, lon=-75.439711 where codigo='05854000';
update catalogos.geo set lat=8.257212, lon=-76.149908 where codigo='23855000';
update catalogos.geo set lat=6.44808, lon=-73.143764 where codigo='68855000';
update catalogos.geo set lat=4.197552, lon=-75.115849 where codigo='73854000';
update catalogos.geo set lat=10.465975, lon=-73.255213 where codigo='20001000';
update catalogos.geo set lat=5.615348, lon=-75.624702 where codigo='05856000';
update catalogos.geo set lat=1.196087, lon=-75.705969 where codigo='18860000';
update catalogos.geo set lat=6.771513, lon=-74.797333 where codigo='05858000';
update catalogos.geo set lat=6.008864, lon=-73.672846 where codigo='68861000';
update catalogos.geo set lat=4.717527, lon=-74.92917 where codigo='73861000';
update catalogos.geo set lat=5.964375, lon=-75.735356 where codigo='05861000';
update catalogos.geo set lat=5.368912, lon=-73.520521 where codigo='15861000';
update catalogos.geo set lat=5.118502, lon=-74.345348 where codigo='25862000';
update catalogos.geo set lat=4.575288, lon=-76.199522 where codigo='76863000';
update catalogos.geo set lat=7.309434, lon=-72.870981 where codigo='68867000';
update catalogos.geo set lat=4.875229, lon=-74.559932 where codigo='25867000';
update catalogos.geo set lat=5.31727, lon=-74.911521 where codigo='17867000';
update catalogos.geo set lat=6.588733, lon=-76.896358 where codigo='05873000';
update catalogos.geo set lat=3.699177, lon=-76.441868 where codigo='76869000';
update catalogos.geo set lat=7.914376, lon=-72.972949 where codigo='54871000';
update catalogos.geo set lat=5.636581, lon=-73.526672 where codigo='15407000';
update catalogos.geo set lat=7.841664, lon=-72.470659 where codigo='54874000';
update catalogos.geo set lat=3.175732, lon=-76.461809 where codigo='19845000';
update catalogos.geo set lat=1.029911, lon=-76.616759 where codigo='86885000';
update catalogos.geo set lat=5.273133, lon=-74.195178 where codigo='25871000';
update catalogos.geo set lat=5.030219, lon=-75.117467 where codigo='73870000';
update catalogos.geo set lat=5.039954, lon=-75.503185 where codigo='17873000';
update catalogos.geo set lat=10.44435, lon=-75.275337 where codigo='13873000';
update catalogos.geo set lat=10.607399, lon=-72.978307 where codigo='44874000';
update catalogos.geo set lat=6.668956, lon=-73.174348 where codigo='68872000';
update catalogos.geo set lat=4.611243, lon=-72.927109 where codigo='85440000';
update catalogos.geo set lat=5.214759, lon=-73.596613 where codigo='25873000';
update catalogos.geo set lat=3.936906, lon=-74.60076 where codigo='73873000';
update catalogos.geo set lat=4.13167, lon=-73.62098 where codigo='50001000';
update catalogos.geo set lat=3.21908, lon=-75.217996 where codigo='41872000';
update catalogos.geo set lat=5.008061, lon=-74.473462 where codigo='25875000';
update catalogos.geo set lat=4.438655, lon=-74.523353 where codigo='25878000';
update catalogos.geo set lat=5.43686, lon=-73.296714 where codigo='15879000';
update catalogos.geo set lat=3.127719, lon=-73.751269 where codigo='50711000';
update catalogos.geo set lat=5.063531, lon=-75.870985 where codigo='17877000';
update catalogos.geo set lat=5.459729, lon=-74.338389 where codigo='25885000';
update catalogos.geo set lat=1.115846, lon=-77.401756 where codigo='52885000';
update catalogos.geo set lat=2.664185, lon=-75.517627 where codigo='41885000';
update catalogos.geo set lat=6.668541, lon=-74.841094 where codigo='05885000';
update catalogos.geo set lat=6.964138, lon=-75.418502 where codigo='05887000';
update catalogos.geo set lat=6.59494, lon=-75.014441 where codigo='05890000';
update catalogos.geo set lat=5.333337, lon=-72.394999 where codigo='85001000';
update catalogos.geo set lat=3.860608, lon=-76.383039 where codigo='76890000';
update catalogos.geo set lat=3.539109, lon=-76.497139 where codigo='76892000';
update catalogos.geo set lat=5.530766, lon=-76.636075 where codigo='27050000';
update catalogos.geo set lat=9.746611, lon=-74.818543 where codigo='13894000';
update catalogos.geo set lat=6.813657, lon=-73.271624 where codigo='68895000';
update catalogos.geo set lat=7.48809, lon=-74.867976 where codigo='05895000';
update catalogos.geo set lat=4.390349, lon=-76.071357 where codigo='76895000';
update catalogos.geo set lat=5.283665, lon=-73.171364 where codigo='15897000';
update catalogos.geo set lat=4.759731, lon=-74.379959 where codigo='25898000';
update catalogos.geo set lat=5.023152, lon=-73.993086 where codigo='25899000';





