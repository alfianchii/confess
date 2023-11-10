<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    // ---------------------------------
    // PROPERTIES


    // ---------------------------------
    // CORES
    public function index()
    {
        return view('pages.landing-page.about.index', ["title" => "Tentang"]);
    }


    // ---------------------------------
    // UTILITIES
}
