-- Salida
select id_exilio, id_entrevista, codigo_entrevista, 'salida' as movimiento, salida_fecha, llegada_fecha
from analitica.exilio_salida
where salida_anio > llegada_anio


union

select id_exilio, id_entrevista, codigo_entrevista, 'salida' as movimiento,  salida_fecha, llegada_fecha
from analitica.exilio_salida
where substr(llegada_fecha,1,7) < substr(salida_fecha,1,7) and length(llegada_fecha)>=7
union

select id_exilio, id_entrevista, codigo_entrevista, 'salida' as movimiento, salida_fecha, llegada_fecha
from analitica.exilio_salida
where llegada_fecha < salida_fecha and length(llegada_fecha)>= length(salida_fecha)

union

-- Reasentamiento
select id_exilio, id_entrevista, codigo_entrevista, 'reasentamiento' as movimiento, salida_fecha, llegada_fecha
from analitica.exilio_reasentamiento
where salida_anio > llegada_anio


union

select id_exilio, id_entrevista, codigo_entrevista, 'reasentamiento' as movimiento, salida_fecha, llegada_fecha
from analitica.exilio_reasentamiento
where substr(llegada_fecha,1,7) < substr(salida_fecha,1,7) and length(llegada_fecha)>=7
union

select id_exilio, id_entrevista, codigo_entrevista, 'reasentamiento' as movimiento, salida_fecha, llegada_fecha
from analitica.exilio_reasentamiento
where llegada_fecha < salida_fecha and length(llegada_fecha)>= length(salida_fecha)

union


-- Retorno
select id_exilio, id_entrevista, codigo_entrevista, 'retorno' as movimiento, salida_fecha, llegada_fecha
from analitica.exilio_retorno
where salida_anio > llegada_anio


union

select id_exilio, id_entrevista, codigo_entrevista, 'retorno' as movimiento, salida_fecha, llegada_fecha
from analitica.exilio_retorno
where substr(llegada_fecha,1,7) < substr(salida_fecha,1,7) and length(llegada_fecha)>=7
union

select id_exilio, id_entrevista, codigo_entrevista, 'retorno' as movimiento, salida_fecha, llegada_fecha
from analitica.exilio_retorno
where llegada_fecha < salida_fecha and length(llegada_fecha)>= length(salida_fecha)

order by codigo_entrevista;