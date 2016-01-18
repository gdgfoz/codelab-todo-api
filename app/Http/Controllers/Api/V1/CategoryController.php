<?php

namespace App\Http\Controllers\Api\V1;

use GDGFoz\Todo\Category\CategoryRepository;
use GDGFoz\Todo\Category\CategoryTransformer;
use GDGFoz\Todo\Category\CategoryRequest;
use App\Http\Controllers\Controller;

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
        $this->middleware('oauth:categories_read',  ['only' => ['index', 'show']]);
        $this->middleware('oauth:categories_write', ['only' => ['store', 'update', 'destroy']]);
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
     *          @SWG\Schema(ref="#/definitions/Category"),
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Categoria não encontrada.",
     *     ),
     *     security={
     *         {
     *             "api_oauth": {"read:categories"}
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


    public function store(CategoryRequest $requests)
    {
        $category = $requests->save();
        return \ResponseFractal::respondCreateItemSucess($category, new CategoryTransformer());
    }

    public function update(CategoryRequest $requests, $categorId)
    {
        $category = $this->categoryRepository->find($categorId);
        $category = $requests->update($category);
        return \ResponseFractal::respondUpdateItemSucess($category, new CategoryTransformer());
    }

}
