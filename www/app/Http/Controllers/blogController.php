<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateblogRequest;
use App\Http\Requests\UpdateblogRequest;
use App\Models\blog;
use App\Models\mis_casos;
use App\Models\mis_casos_blog;
use App\Models\traza_actividad;
use App\Repositories\blogRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class blogController extends AppBaseController
{
    /** @var  blogRepository */
    private $blogRepository;

    public function __construct(blogRepository $blogRepo)
    {
        $this->blogRepository = $blogRepo;
    }

    /**
     * Display a listing of the blog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->authorize('nivel-1');
        $this->blogRepository->pushCriteria(new RequestCriteria($request));
        $blogs = $this->blogRepository->all();

        return view('blogs.index')
            ->with('blogs', $blogs);
    }

    /**
     * Show the form for creating a new blog.
     *
     * @return Response
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * Store a newly created blog in storage.
     *
     * @param CreateblogRequest $request
     *
     * @return Response
     */
    public function store(CreateblogRequest $request)
    {
        //dd($request);
        $input = $request->all();
        //$input['html']=blog::limpiar_html($request->html);
        $input['id_entrevistador']=\Auth::user()->id_entrevistador;
        $input['texto']=blog::extraer_texto($input['html']);
        //dd($input);
        $blog = new blog();
        $blog->fill($input);
        $blog->save();
        if(isset($request->id_mis_casos)) {
            $enlace = new mis_casos_blog();
            $enlace->id_mis_casos = $request->id_mis_casos;
            $enlace->id_blog = $blog->id_blog;
            try {
                $enlace->save();
            }
            catch (\Exception $e) {
                //No pasa nada, es por un save doble
            }
            //Registrar traza
            $entrevista = mis_casos::find($enlace->id_mis_casos);
            traza_actividad::create(['id_objeto'=>19, 'id_accion'=>3, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$enlace->id_mis_casos_blog]);
            $url = action('mis_casosController@show',$enlace->id_mis_casos);
            return redirect($url."?activar=b");
        }

        Flash::success('Blog saved successfully.');

        //return redirect(route('blogs.index'));
    }

    /**
     * Display the specified blog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $blog = $this->blogRepository->findWithoutFail($id);

        if (empty($blog)) {
            Flash::error('Blog not found');

            return redirect(route('blogs.index'));
        }

        return view('blogs.show')->with('blog', $blog);
    }

    /**
     * Show the form for editing the specified blog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $blog = $this->blogRepository->findWithoutFail($id);

        if (empty($blog)) {
            Flash::error('Blog not existe');
            return redirect()->back();
        }
        $id_mis_casos = isset($request->id_mis_casos) ? $request->id_mis_casos : 0;

        return view('blogs.edit')->with('blog', $blog)->with('id_mis_casos', $id_mis_casos);
    }

    /**
     * Update the specified blog in storage.
     *
     * @param  int              $id
     * @param UpdateblogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateblogRequest $request)
    {
        $blog = $this->blogRepository->findWithoutFail($id);

        if (empty($blog)) {
            Flash::error('Blog no existe');
            return redirect()->back();
        }

        $blog->titulo = $request->titulo;
        $blog->html = $request->html;
        $blog->texto=$blog->extraer_texto($blog->html);
        $blog->fh_update = Carbon::now();
        $blog->save();
        //Registrar traza
        $entrevista = mis_casos::find(mis_casos_blog::where('id_blog',$id)->first()->id_mis_casos);
        traza_actividad::create(['id_objeto'=>19, 'id_accion'=>4, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$id]);

        if(isset($request->id_mis_casos)) {
            if($request->id_mis_casos > 0) {
                $url=action("mis_casosController@show",$request->id_mis_casos)."?activar=b";
                return redirect($url);
            }
        }

        return redirect()->back();
    }

    public function anular($id, Request $request)
    {
        $blog = $this->blogRepository->findWithoutFail($id);

        if (empty($blog)) {
            Flash::error('Blog no existe');
            return redirect()->back();
        }


        $blog->id_activo = 2;
        $blog->save();
        //Registrar traza
        $entrevista = mis_casos::find(mis_casos_blog::where('id_blog',$id)->first()->id_mis_casos);
        traza_actividad::create(['id_objeto'=>19, 'id_accion'=>10, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$id]);

        //Flash::success('Blog eliminado.');
        if(isset($request->id_mis_casos)) {
            if($request->id_mis_casos > 0) {
                $url=action("mis_casosController@show",$request->id_mis_casos)."?activar=b";
                return redirect($url);
            }
        }

        return redirect()->back();
    }

    /**
     * Remove the specified blog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->authorize('nivel-yyz');
        $blog = $this->blogRepository->findWithoutFail($id);

        if (empty($blog)) {
            Flash::error('Blog not found');

            return redirect()->back();
        }

        $this->blogRepository->delete($id);

        Flash::success('Blog deleted successfully.');

        return redirect()->back();
    }
}
