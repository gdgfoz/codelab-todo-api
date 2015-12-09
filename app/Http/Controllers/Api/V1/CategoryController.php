<?php

namespace GDGFoz\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use GDGFoz\Http\Requests;
use GDGFoz\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \ResponseFractal::respondENotFound();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


}
