create or replace view public.vista_audio_transcripcion
as

select e.id_e_ind_fvt, e.entrevista_codigo, adjunto.ubicacion as audio_ubicacion, adjunto.nombre_original as audio_nombre, adjunto2.ubicacion as transcripcion_ubicacion
        , m.descripcion as macroterritorio, cev.descripcion as territorio
from esclarecimiento.e_ind_fvt e
    join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt=a.id_e_ind_fvt and a.id_tipo=2)
    join public.transcribir_asignacion t on (e.id_e_ind_fvt=t.id_e_ind_fvt and t.id_situacion=2)
    join esclarecimiento.adjunto on (a.id_adjunto=adjunto.id_adjunto)
    join esclarecimiento.e_ind_fvt_adjunto a2 on (e.id_e_ind_fvt=a2.id_e_ind_fvt and a2.id_tipo=6)
    join esclarecimiento.adjunto adjunto2 on (a2.id_adjunto=adjunto2.id_adjunto)

    join catalogos.cev m on (e.id_macroterritorio = m.id_geo)
    join catalogos.cev on (e.id_territorio=cev.id_geo)

where adjunto2.ubicacion ilike '%html'

order by e.entrevista_codigo,adjunto2.nombre_original


GRANT SELECT ON public.vista_audio_transcripcion TO solo_lectura;
