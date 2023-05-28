<?php

namespace App\Http\Controllers;

use App\Models\{Complaint, User, Category};
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
        $title = '';

        $complaints = Complaint::latest()->filter(request(["user", "search", "category", "status", "privacy"]))->paginate(7)->withQueryString();

        $category = Category::firstWhere("slug", request("category"))->name ?? '';
        $username = User::firstWhere("username", request("user"))->name ?? "";

        $title = request("category") ? "dengan " . $category : '';
        $title = request("user") ? "oleh " . $username : $title;
        $title = request("status") ? "dengan " . request("status") : $title;
        $title = request("privacy") ? "dengan " . request("privacy") : $title;

        return view("complaints.index", [
            "title" => "Keluhan $title",
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
        return view("complaints.show", [
            "title" => $complaint->title,
            "complaint" => $complaint,
        ]);
    }
}
