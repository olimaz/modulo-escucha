select e_ind_fvt.entrevista_codigo, persona.nombre, persona.apellido, edad, entrevista_fecha
from fichas.persona_entrevistada
         join fichas.persona on persona_entrevistada.id_persona = persona.id_persona
         join esclarecimiento.e_ind_fvt on persona_entrevistada.id_e_ind_fvt = e_ind_fvt.id_e_ind_fvt
where edad < 18 and edad > 0