-- movimientos en los que la cantidad de personas es cero o negativa
select id_entrevista, id_exilio, id_exilio_movimiento, 1 as tipo, codigo_entrevista,  'Salida' as movimiento, cantidad_personas_salieron, cantidad_personas_nucleo_salieron, salida_lugar_n1_txt, salida_lugar_n2_txt, llegada_lugar_n1_txt, llegada_lugar_n2_txt
from analitica.exilio_salida
where cantidad_personas_salieron<=0

union

select id_entrevista, id_exilio, id_exilio_movimiento,  2 as tipo, codigo_entrevista,'Reasentamiento' as movimiento, cantidad_personas_salieron, cantidad_personas_nucleo_salieron, salida_lugar_n1_txt, salida_lugar_n2_txt, llegada_lugar_n1_txt, llegada_lugar_n2_txt
from analitica.exilio_reasentamiento
where cantidad_personas_salieron<=0

union

select id_entrevista, id_exilio, id_exilio_movimiento,  3 as tipo, codigo_entrevista, 'Retorno' as movimiento, cantidad_personas_salieron, cantidad_personas_nucleo_salieron, salida_lugar_n1_txt, salida_lugar_n2_txt, llegada_lugar_n1_txt, llegada_lugar_n2_txt
from analitica.exilio_retorno
where cantidad_personas_salieron<=0

order by codigo_entrevista, tipo;
