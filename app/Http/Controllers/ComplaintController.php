<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $complaints = Complaint::latest()->filter(request(["search", "category", "status", "privacy"]))->paginate(7)->withQueryString();
        $complaints = Complaint::latest()->paginate(7)->withQueryString();

        return view("complaints", [
            "title" => "Keluhan",
            "complaints" => $complaints,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function show(Complaint $complaint)
    {
        //
    }
}
