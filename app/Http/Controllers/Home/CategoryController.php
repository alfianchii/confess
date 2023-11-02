<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\MasterConfessionCategory;

class CategoryController extends Controller
{
    // ---------------------------------
    // PROPERTIES


    // ---------------------------------
    // CORES
    public function index()
    {
        return view("categories.index", [
            "title" => "Kategori Pengakuan",
            "confession_categories" => MasterConfessionCategory::all()->sortBy("name"),
        ]);
    }


    // ---------------------------------
    // UTILITIES
}
