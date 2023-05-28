<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("categories.index", [
            "title" => "Kategori Keluhan",
            "categories" => Category::all()->sortBy("name"),
        ]);
    }
}
