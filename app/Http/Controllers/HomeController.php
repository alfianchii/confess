<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complaintsCount = Complaint::count();

        return view('home', [
            "title" => "Selamat Datang",
            "complaintsCount" => $complaintsCount,
        ]);
    }
}
