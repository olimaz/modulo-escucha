<?php

namespace App\Models;

use App\Imports\codigosImport;
use Carbon\Carbon;
use Eloquent as Model;
use Flash;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class excel_listados
 * @package App\Models
 * @version May 6, 2021, 2:50 pm -05
 *
 * @property \App\Models\Esclarecimiento.adjunto idAdjunto
 * @property integer id_excel_listados
 * @property integer id_entrevistador
 * @property integer id_activo
 * @property integer id_adjunto
 * @property integer id_acceso_publico
 * @property string descripcion
 * @property integer cantidad_codigos_si
 * @property integer cantidad_codigos_no
 * @property string|\Carbon\Carbon created_at
 */
class excel_listados extends Model
{

    public $table = 'sim.excel_listados';
    protected $primaryKey = 'id_excel_listados';
    
    public $timestamps = false;




    public $fillable = [
        'id_entrevistador',
        'id_activo',
        'id_adjunto',
        'id_acceso_publico',
        'descripcion',
        'cantidad_codigos_si',
        'cantidad_codigos_no',
        'created_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_excel_listados' => 'integer',
        'id_entrevistador' => 'integer',
        'id_activo' => 'integer',
        'id_adjunto' => 'integer',
        'id_acceso_publico' => 'integer',
        'descripcion' => 'string',
        'cantidad_codigos_si' => 'integer',
        'cantidad_codigos_no' => 'integer',
        //'created_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //Valores por defecto
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['id_acceso_publico']=1;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_adjunto()
    {
        return $this->belongsTo(adjunto::class, 'id_adjunto','id_adjunto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_entrevistador()
    {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador','id_entrevistador');
    }

    public function rel_codigos() {
        return $this->hasMany(excel_listados_codigos::class,'id_excel_listados','id_excel_listados')->orderby('id_excel_listados_codigos');
    }

    public function getFmtIdEntrevistadorAttribute() {
        $quien=$this->rel_id_entrevistador;
        if($quien) {
            return "# ".str_pad($quien->numero_entrevistador,3,"0",STR_PAD_LEFT);
        }
    }
    public function getFmtIdAccesoPublicoAttribute() {
        return $this->id_acceso_publico==1 ? "Público: todos pueden utilizarlo" : "Privado: solo el usuario que lo creó";
    }
    public function getFmtCreatedAtAttribute() {
        $hora = Carbon::createFromFormat("Y-m-d H:i:s.u", $this->created_at);
        return $hora->formatLocalized("%a %d-%b-%y %H:%M");
    }
    //Para editar el control de carga de archivo
    public function getNombrearchivoAttribute() {
        $existe=$this->rel_id_adjunto;
        if($existe) {
            return $existe->ubicacion;
        }
        else {
            return null;
        }
    }
    //Link a ver detalles
    public function getLinkAttribute() {
        $url = action("excel_listadosController@show",$this->id_excel_listados);
        return "<a href='$url' target='_blank'>$this->descripcion</a>";
    }

    //Para mostrar el select en los filtros
    public static function arreglo_opciones($vacio=null) {
        $listado = excel_listados::disponibles()->ordenar()->get();
        $arreglo=array();
        foreach($listado as $fila) {
            $arreglo[$fila->id_excel_listados] = "($fila->cantidad_codigos_si) $fila->descripcion";
        }
        if(strlen($vacio)>0) {
            $arreglo = [-1=>$vacio] + $arreglo;
        }
        return $arreglo;
    }
    //Para los filtros
    public static function arreglo_codigos($id_listado){
        return excel_listados_codigos::where('id_excel_listados',$id_listado)->where('valido',1)->distinct()->pluck('codigo')->toArray();

    }


    //Carga el adjunto y lo procesa.
    public function cargar_adjunto($request) {
        //Cargar adjunto
        if($request->hasFile('archivo_30')) {
            $nombre_original=$request->file('archivo_30')->getClientOriginalName();
            $this->id_adjunto = adjunto::crear_adjunto($request->archivo_30_filename, $nombre_original);
            $this->save();
            $res = $this->importar_adjunto();
            $res = $this->verificar_codigos();
            return true;
        }
        else {
            return false;
        }
    }
    //Carga el adjunto y lo procesa.
    public function actualizar_adjunto($request) {
        //Cargar adjunto
        if($request->hasFile('archivo_30')) {
            //Verificar que no exista

            $cargado = $request->archivo_30_filename;
            $cargado= substr($cargado,8); //Quitar "/storage";
            $existe = adjunto::where('ubicacion',$cargado)->first();

            if($existe) {
                Flash::success("Información actualizada. Sin cambios en el archivo cargado");
            }
            else {
                $nombre_original=$request->file('archivo_30')->getClientOriginalName();
                Flash::success("Información actualizada. Se detectó un nuevo archivo cargado que sustituye al anterior");
                $this->id_adjunto = adjunto::crear_adjunto($request->archivo_30_filename, $nombre_original);
                $this->save();
            }
        }
        else {
            Flash::success("Información actualizada. Sin cambios en el archivo cargado");
        }
        $res = $this->importar_adjunto();
        $res = $this->verificar_codigos();
        return true;
    }
    public function importar_adjunto() {
        //Vaciar tabla con detalle
        excel_listados_codigos::where('id_excel_listados',$this->id_excel_listados)->delete();
        $adjunto = adjunto::find($this->id_adjunto);
        $ubicacion = storage_path('app/public'.$adjunto->ubicacion);

        $import = new codigosImport($this->id_excel_listados);
        $import->onlySheets('0');
        Excel::import($import, $ubicacion);

        return true;
    }
    public function verificar_codigos() {
        $si=0;
        $no=0;

        foreach($this->rel_codigos as $fila ) {
            $codigo=trim(mb_strtoupper($fila->codigo));
            if(strlen($codigo)>=12) {

                $tipo = substr($codigo,-8,2);
                $e=false;

                if($tipo=="VI" || $tipo=="AA" || $tipo=="TC" ) {

                    //if($codigo=="015-VI-00003") echo "buscando $codigo";
                    $e=entrevista_individual::where('entrevista_codigo',$codigo)->where('id_activo',1)->first();
                    //if($codigo=="015-VI-00003") dd("Buscado");

                }
                elseif($tipo=="CO") {
                    $e=entrevista_colectiva::where('entrevista_codigo',$codigo)->where('id_activo',1)->first();
                }
                elseif($tipo=="EE") {
                    $e=entrevista_etnica::where('entrevista_codigo',$codigo)->where('id_activo',1)->first();
                }
                elseif($tipo=="PR") {
                    $e=entrevista_profundidad::where('entrevista_codigo',$codigo)->where('id_activo',1)->first();
                }
                elseif($tipo=="DC") {
                    $e=diagnostico_comunitario::where('entrevista_codigo',$codigo)->where('id_activo',1)->first();
                }
                elseif($tipo=="HV") {
                    $e=historia_vida::where('entrevista_codigo',$codigo)->where('id_activo',1)->first();
                }

                if($e) {
                    $fila->valido=1;
                    $fila->save();
                    $si++;
                }
                else {
                    $fila->valido=2;
                    $fila->save();
                    $no++;
                }

            }
            elseif(is_null($codigo)) {
                $fila->delete();
                //$fila->valido=0;
                //$fila->save();
            }
            elseif(strlen($codigo)==0) {
                $fila->delete();
                //$fila->valido=0;
                //$fila->save();
            }
            else {
                $fila->valido=2;
                $no++;
            }
        }
        $res= new \stdClass();
        $res->si=$si;
        $res->no=$no;
        $this->cantidad_codigos_no = $res->no;
        $this->cantidad_codigos_si = $res->si;
        $this->save();
        return $res;

    }

    //Para mostrar los públicos y los del propio usuario
    public static function scopeDisponibles($query) {
        $id_entrevistador = \Auth::check() ? \Auth::user()->id_entrevistador : -1;
        $query->where('id_activo',1);
        $query->whereraw(\DB::raw("( id_acceso_publico=1 or id_entrevistador = $id_entrevistador)"));
    }
    public static function scopeOrdenar($query) {
        $query->orderby('descripcion')->orderby('created_at');
    }

}
