<?php

namespace GDGFoz\Http\Controllers\Dashboard;

use GDGFoz\Http\Controllers\Controller;
use GDGFoz\Http\Requests\Request;

class DashboardController extends Controller
{

    public function index()
    {
        return view('dashboard.home');
    }

}