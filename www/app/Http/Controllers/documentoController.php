<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedocumentoRequest;
use App\Http\Requests\UpdatedocumentoRequest;
use App\Models\adjunto;
use App\Models\documento;
use App\Models\traza_actividad;
use App\Repositories\documentoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class documentoController extends AppBaseController
{
    /** @var  documentoRepository */
    private $documentoRepository;

    public function __construct(documentoRepository $documentoRepo)
    {
        $this->documentoRepository = $documentoRepo;
    }

    /**
     * Display a listing of the documento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->documentoRepository->pushCriteria(new RequestCriteria($request));
        $filtros = documento::filtros_default($request);
        $documentos = documento::filtrar($filtros)->ordenar()->get();

        return view('documentos.index')
            ->with('documentos', $documentos);
    }

    /**
     * Show the form for creating a new documento.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('nivel-1-2');

        $documento = new documento();
        $documento->orden=10;
        return view('documentos.create',compact('documento'));
    }

    /**
     * Store a newly created documento in storage.
     *
     * @param CreatedocumentoRequest $request
     *
     * @return Response
     */
    public function store(CreatedocumentoRequest $request)
    {
        $input = $request->all();
        $input['id_adjunto'] = adjunto::crear_adjunto($request->archivo_7_filename);
        $documento = $this->documentoRepository->create($input);
        Flash::success('Documento cargado.');
        //Registrar traza
        traza_actividad::create(['id_objeto'=>6, 'id_accion'=>3 , 'id_primaria'=>$documento->id_documento]);
        return redirect(route('documentos.index'));
    }

    /**
     * Display the specified documento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $documento = $this->documentoRepository->findWithoutFail($id);

        if (empty($documento)) {
            Flash::error('Documento no existe: '.$id);
            return redirect(route('documentos.index'));
        }



        return view('documentos.show')->with('documento', $documento);
    }


    /**
     * Show the form for editing the specified documento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $this->authorize('nivel-1-2');
        $documento = $this->documentoRepository->findWithoutFail($id);

        if (empty($documento)) {
            Flash::error('Documento no existe: '.$id);
            return redirect(route('documentos.index'));
        }

        return view('documentos.edit')->with('documento', $documento);
    }

    /**
     * Update the specified documento in storage.
     *
     * @param  int              $id
     * @param UpdatedocumentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedocumentoRequest $request)
    {
        $documento = $this->documentoRepository->findWithoutFail($id);

        if (empty($documento)) {
            Flash::error('Documento no existe: '.$id);
            return redirect(route('documentos.index'));
        }

        $input = $request->all();
        $archivo = str_replace("/storage/","/",$request->archivo_7_filename);  //Quitar /storage/ al inicio que pone el contro
        $existe = adjunto::where('ubicacion',$archivo)->first();
        if(!$existe) {
            $input['id_adjunto'] = adjunto::crear_adjunto($request->archivo_7_filename);
        }
        $documento = $this->documentoRepository->update($input, $id);

        Flash::success('Documento actualizado.');
        //Registrar traza
        traza_actividad::create(['id_objeto'=>6, 'id_accion'=>4 , 'id_primaria'=>$documento->id_documento]);

        return redirect(route('documentos.index'));
    }

    /**
     * Remove the specified documento from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->authorize('nivel-1-2');
        $documento = $this->documentoRepository->findWithoutFail($id);

        if (empty($documento)) {
            Flash::error('Documento no existe: '.$id);
            return redirect(route('documentos.index'));
        }

        $id_adjunto=$documento->id_adjunto;

        $this->documentoRepository->delete($id);
        Flash::success('Documento eliminado.');
        traza_actividad::create(['id_objeto'=>6, 'id_accion'=>10 , 'id_primaria'=>$id,'referencia'=>"id_adjunto: $id_adjunto "]);
        return redirect(route('documentos.index'));
    }
}
