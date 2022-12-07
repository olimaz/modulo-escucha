<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createcat_catRequest;
use App\Http\Requests\Updatecat_catRequest;
use App\Models\persona;
use App\Repositories\cat_catRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class cat_catController extends AppBaseController
{
    /** @var  cat_catRepository */
    private $catCatRepository;

    public function __construct(cat_catRepository $catCatRepo)
    {
        $this->catCatRepository = $catCatRepo;
    }

    /**
     * Display a listing of the cat_cat.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->catCatRepository->pushCriteria(new RequestCriteria($request));
        $catCats = $this->catCatRepository->all();

        return view('cat_cats.index')
            ->with('catCats', $catCats);
    }

    /**
     * Show the form for creating a new cat_cat.
     *
     * @return Response
     */
    public function create()
    {
        return view('cat_cats.create');
    }

    /**
     * Store a newly created cat_cat in storage.
     *
     * @param Createcat_catRequest $request
     *
     * @return Response
     */
    public function store(Createcat_catRequest $request)
    {
        $input = $request->all();

        $catCat = $this->catCatRepository->create($input);

        Flash::success('Cat Cat saved successfully.');

        return redirect(route('catCats.index'));
    }

    /**
     * Display the specified cat_cat.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $catCat = $this->catCatRepository->findWithoutFail($id);

        if (empty($catCat)) {
            Flash::error('Cat Cat not found');

            return redirect(route('catCats.index'));
        }

        return view('cat_cats.show')->with('catCat', $catCat);
    }

    /**
     * Show the form for editing the specified cat_cat.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $catCat = $this->catCatRepository->findWithoutFail($id);

        if (empty($catCat)) {
            Flash::error('Cat Cat not found');

            return redirect(route('catCats.index'));
        }

        return view('cat_cats.edit')->with('catCat', $catCat);
    }

    /**
     * Update the specified cat_cat in storage.
     *
     * @param  int              $id
     * @param Updatecat_catRequest $request
     *
     * @return Response
     */
    public function update($id, Updatecat_catRequest $request)
    {
        $catCat = $this->catCatRepository->findWithoutFail($id);

        if (empty($catCat)) {
            Flash::error('Cat Cat not found');

            return redirect(route('catCats.index'));
        }

        $catCat = $this->catCatRepository->update($request->all(), $id);

        Flash::success('Cat Cat updated successfully.');

        return redirect(route('catCats.index'));
    }

    /**
     * Remove the specified cat_cat from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $catCat = $this->catCatRepository->findWithoutFail($id);

        if (empty($catCat)) {
            Flash::error('Cat Cat not found');

            return redirect(route('catCats.index'));
        }

        $this->catCatRepository->delete($id);

        Flash::success('Cat Cat deleted successfully.');

        return redirect(route('catCats.index'));
    }

    //Homologar preguntas abiertas
    public function homologar_index(Request  $request) {
        $id_campo = isset($request->id_campo) ? $request->id_campo : 1;
        $fecha = isset($request->fecha_submit) ? $request->fecha_submit : "2020-10-01";
        $listado= persona::listado_respuestas($id_campo,$fecha);
        if(!$listado) {
            $id_campo=1;
            $listado= persona::listado_respuestas($id_campo,$fecha);
        }
        $ruta_ajax = persona::listar_rutas_ajax_homologar($id_campo);
        //dd($ruta_ajax);


        return view('cat_items.homologador',compact('id_campo','listado','ruta_ajax','fecha'));
    }
    public function homologar_update($id, Request  $request) {
        $this->validate($request, [
            'antiguo' => 'required',
            'nuevo' => 'required',
        ]);

        $exito = persona::aplicar_homologacion($id,$request);
        Flash::success("$exito filas actualizadas");
        return redirect()->back();
    }
}
