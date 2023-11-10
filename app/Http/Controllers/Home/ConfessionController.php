<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\{User, MasterConfessionCategory, RecConfession};
use Illuminate\Http\Request;

class ConfessionController extends Controller
{
    // ---------------------------------
    // PROPERTIES

    // ---------------------------------
    // CORES
    public function index()
    {
        $title = '';

        $confessions = RecConfession::latest()->filter(request(["user", "search", "category", "status", "privacy"]))->paginate(7)->withQueryString();

        $category = MasterConfessionCategory::firstWhere("slug", request("category"))->name ?? '';
        $username = User::firstWhere("username", request("user"))->name ?? "";

        $title = request("category") ? "dengan " . $category : '';
        $title = request("user") ? "oleh " . $username : $title;
        $title = request("status") ? "dengan " . request("status") : $title;
        $title = request("privacy") ? "dengan " . request("privacy") : $title;

        return view("pages.landing-page.confessions.index", [
            "title" => "Pengakuan $title",
            "confessions" => $confessions,
        ]);
    }

    public function show(RecConfession $confession)
    {
        return view("complaints.show", [
            "title" => $confession->title,
            "confession" => $confession,
        ]);
    }


    // ---------------------------------
    // UTILITIES
}
