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
        // $complaints = Complaint::latest()->paginate(7)->withQueryString();

        $category = Category::firstWhere("slug", request("category"))->name ?? '';
        $username = User::firstWhere("username", request("user"))->name ?? "";
        $title = request("category") ? "in " . $category : '';
        $title = request("user") ? "by " . $username : $title;

        return view("complaints.index", [
            "title" => "Complaints $title",
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
