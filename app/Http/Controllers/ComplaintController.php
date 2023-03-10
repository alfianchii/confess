<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Complaint;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complaints = Complaint::where('student_nik', auth()->user()->nik)->get();

        return view("dashboard.complaints.index", [
            "title" => "Complaints",
            "complaints" => $complaints,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.complaints.create", [
            "title" => "Buat Keluhan",
            "categories" => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            "title" => ["required", "max:255"],
            "slug" => ["required", "unique:complaints"],
            "date" => ["required", "date", "date_format:Y-m-d"],
            "category_id" => ["required"],
            "place" => ["required"],
            "image" => ["image", "file", "max:1024"],
            "body" => ["required"],
        ]);

        // Convert slug into id
        $credentials["category_id"] = Category::where('slug', $credentials["category_id"])->first()->id;

        if ($request->file("image")) {
            $credentials["image"] = $request->file("image")->store('complaint-images');
        }

        $credentials["student_nik"] = auth()->user()->nik ?? null;
        $credentials["excerpt"] = Str::limit(strip_tags($request->body), 200, ' ...');

        try {
            $complaint = Complaint::create($credentials);
            return redirect('/dashboard/complaints/' . $complaint->slug)->with('success', 'Keluhan kamu berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect('/dashboard/complaints')->withErrors('Keluhan kamu gagal dibuat.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function show(Complaint $complaint)
    {
        return view("dashboard.complaints.show", [
            "title" => ucwords($complaint->title),
            "complaint" => $complaint,
            "responses" => $complaint->responses,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function edit(Complaint $complaint)
    {
        return view("dashboard.complaints.edit", [
            "title" => "Edit",
            "complaint" => $complaint,
            "categories" => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Complaint $complaint)
    {
        $rules = [
            "title" => ["required", "max:255"],
            "category_id" => ["required"],
            "image" => ["image", "file", "max:1024"],
            "date" => ["required", "date", "date_format:Y-m-d"],
            "body" => ["required"],
            "place" => ["required"],
        ];

        if ($request->slug != $complaint->slug) {
            $rules["slug"] = ["required", "unique:complaints"];
        }

        $credentials = $request->validate($rules);

        // Convert slug into id
        $credentials["category_id"] = Category::where('slug', $credentials["category_id"])->first()->id;

        if ($request->file("image")) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }

            $credentials["image"] = $request->file("image")->store('complaint-images');
        }

        $credentials["student_nik"] = auth()->user()->nik ?? null;
        $credentials["excerpt"] = Str::limit(strip_tags($request->body), 200, ' ...');

        try {
            // $complaint = Complaint::where("id", $complaint->id)->update($credentials);
            // Get the new and old of $complaint
            $complaintOld = $complaint->fresh();
            $complaint->update($credentials);
            $complaintNew = $complaint->fresh();

            // Get the old and new versions of the model as arrays
            $oldAttributes = $complaintOld->getAttributes();
            $newAttributes = $complaintNew->getAttributes();

            // Compare the arrays to see if any attributes have changed
            if ($oldAttributes === $newAttributes) {
                // The instance of the $complaint record has not been updated
                return redirect('/dashboard/complaints/' . $complaint->slug)->with('info', 'Kamu tidak melakukan editing pada keluhan.');
            }

            // The instance of the $complaint record has been updated
            return redirect('/dashboard/complaints/' . $complaint->slug)->with('success', 'Keluhan kamu berhasil di-edit!');
        } catch (\Exception $e) {
            // If something was wrong ...
            return redirect('/dashboard/complaints')->withErrors('Keluhan kamu gagal di-edit.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complaint $complaint)
    {
        if ($complaint->image) {
            Storage::delete($complaint->image);
        }

        try {
            Complaint::destroy($complaint->id);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Gagal untuk menghapus keluhan."
            ], 422);
        }

        return response()->json([
            "message" => "Keluhan kamu telah dihapus!"
        ], 200);
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Complaint::class, "slug", $request->title);

        return response()->json(["slug" => $slug]);
    }
}