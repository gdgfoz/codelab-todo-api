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
     */
    public function show($id)
    {
        $categories = $this->categoryRepository->find($id);
        return \ResponseFractal::respondItem($categories, new CategoryTransformer());
    }


}
