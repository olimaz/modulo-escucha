
-- Caso: salidas que no son de Colombia: [Internacional]
select salida_lugar_n1_txt, count(1) from
    analitica.exilio_salida
group by 1
order by 2 desc;
-- Reporte:
select codigo_entrevista, macroterritorio_txt, territorio_txt, salida_lugar_n1_txt
from analitica.exilio_salida
where salida_lugar_n1_txt='[Internacional]';

-- Caso: arribos que no son  afuera  Colombia: [Internacional]
select llegada_lugar_n1_txt, count(1) from
    analitica.exilio_salida
group by 1
order by 2 desc;
-- Reporte:
select codigo_entrevista, macroterritorio_txt, territorio_txt, llegada_lugar_n1_txt
from analitica.exilio_salida
where llegada_lugar_n1_txt<>'[Internacional]';

-- REASENTAMIENTO

-- Caso: salidas  de  Colombia:
select salida_lugar_n1_txt, count(1) from
    analitica.exilio_reasentamiento
group by 1
order by 2 desc;
-- Reporte:
select codigo_entrevista, macroterritorio_txt, territorio_txt, salida_lugar_n1_txt
from analitica.exilio_reasentamiento
where salida_lugar_n1_txt<>'[Internacional]';

-- Caso: arribos de  Colombia: [Internacional]
select llegada_lugar_n1_txt, count(1) from
    analitica.exilio_reasentamiento
group by 1
order by 2 desc;
-- Reporte:
select codigo_entrevista, macroterritorio_txt, territorio_txt, llegada_lugar_n1_txt
from analitica.exilio_salida
where llegada_lugar_n1_txt<>'[Internacional]';


-- RETORNOS -----------------------


-- Caso: retornos que salió  de  Colombia:
select salida_lugar_n1_txt, count(1) from
    analitica.exilio_retorno
group by 1
order by 2 desc;
-- Reporte:
select codigo_entrevista, macroterritorio_txt, territorio_txt, salida_lugar_n1_txt
from analitica.exilio_retorno
where salida_lugar_n1_txt<>'[Internacional]';

-- Caso: retorno que no arribó a  Colombia: [Internacional]
select llegada_lugar_n1_txt, count(1) from
    analitica.exilio_retorno
group by 1
order by 2 desc;
-- Reporte:
select codigo_entrevista, macroterritorio_txt, territorio_txt, llegada_lugar_n1_txt
from analitica.exilio_retorno
where llegada_lugar_n1_txt='[Internacional]';

-- Afganistan
select distinct salida_lugar_n2_txt
from analitica.exilio_reasentamiento
order by 1;

select codigo_entrevista, macroterritorio_txt, territorio_txt, 'retorno' as tipo ,salida_lugar_n1_txt, salida_lugar_n2_txt, llegada_lugar_n1_txt, llegada_lugar_n2_txt, '' as asentamiento_lugar_n1_txt, '' as asentamiento_lugar_n2_txt
from analitica.exilio_retorno
where salida_lugar_n1_txt ilike 'afganis%' or salida_lugar_n2_txt ilike 'afganis%'
   or llegada_lugar_n1_txt ilike 'afganis%' or llegada_lugar_n2_txt ilike 'afganis%'


union

select codigo_entrevista, macroterritorio_txt, territorio_txt, 'salida' as tipo, salida_lugar_n1_txt, salida_lugar_n2_txt, llegada_lugar_n1_txt, llegada_lugar_n2_txt,  asentamiento_lugar_n1_txt,  asentamiento_lugar_n2_txt
from analitica.exilio_salida
where salida_lugar_n1_txt ilike 'afganis%' or salida_lugar_n2_txt ilike 'afganis%'
   or llegada_lugar_n1_txt ilike 'afganis%' or llegada_lugar_n2_txt ilike 'afganis%'
   or asentamiento_lugar_n1_txt ilike 'afganis%' or asentamiento_lugar_n2_txt ilike 'afganis%'

union

select codigo_entrevista, macroterritorio_txt, territorio_txt, 'reasentamiento' as tipo, salida_lugar_n1_txt, salida_lugar_n2_txt, llegada_lugar_n1_txt, llegada_lugar_n2_txt,  asentamiento_lugar_n1_txt,  asentamiento_lugar_n2_txt
from analitica.exilio_reasentamiento
where salida_lugar_n1_txt ilike 'afganis%' or salida_lugar_n2_txt ilike 'afganis%'
   or llegada_lugar_n1_txt ilike 'afganis%' or llegada_lugar_n2_txt ilike 'afganis%'
   or asentamiento_lugar_n1_txt ilike 'afganis%' or asentamiento_lugar_n2_txt ilike 'afganis%'
order by codigo_entrevista, tipo;




