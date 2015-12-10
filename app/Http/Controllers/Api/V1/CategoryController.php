<?php

namespace GDGFoz\Http\Controllers\Api\V1;

use GDGFoz\Repositories\CategoryRepository;
use GDGFoz\Transformers\CategoryTransformer;
use Illuminate\Http\Request;

use GDGFoz\Http\Requests;
use GDGFoz\Http\Controllers\Controller;

class CategoryController extends Controller
{

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     *  @SWG\Get(
     *     path="/categories",
     *     description="Lista todas as categories",
     *     operationId="api.categories.index",
     *     tags={"dashboard"},
     *     @SWG\Response(
     *          response=200,
     *          description="Lista todas as categorias",
     *          @SWG\Schema(type="array", @SWG\Items(ref="#/definitions/Category") ),
     *     )
     * )
     *
     */
    public function index()
    {
        $categories = $this->categoryRepository->listCategories()->all();
        return \ResponseFractal::respondCollection($categories, new CategoryTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     *   @SWG\Get(
     *     path="/categories/{id}",
     *     description="Detalhe de uma categoria",
     *     operationId="api.categories.show",
     *     tags={"dashboard"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id da categoria",
     *          required=true,
     *          type="integer"
     *      ),
     *     @SWG\Response(
     *          response=200,
     *          description="Detalhe da categoria",
     *          @SWG\Schema(@SWG\Items(ref="#/definitions/Category") ),
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Categoria não encontrada.",
     *     ),
     *     security={
     *         {
     *             "api_oauth": {"read:tasks"}
     *         }
     *     }
     * )
     *
     */
    public function show($id)
    {
        $categories = $this->categoryRepository->find($id);
        return \ResponseFractal::respondItem($categories, new CategoryTransformer());
    }


}
