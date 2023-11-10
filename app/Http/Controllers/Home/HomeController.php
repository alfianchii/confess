<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\RecConfession;

class HomeController extends Controller
{
    // ---------------------------------
    // PROPERTIES


    // ---------------------------------
    // CORES
    public function index()
    {
        $title = "Selamat Datang";
        
        $confessionsCount = RecConfession::count();
        
        return view('pages.landing-page.home.index', [
            "title" => $title,
            "confessionsCount" => $confessionsCount,
        ]);
    }


    // ---------------------------------
    // UTILITIES
}
