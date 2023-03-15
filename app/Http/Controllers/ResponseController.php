<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $responses = Response::where("officer_nik", auth()->user()->nik)->get() ?? [];

        return view("dashboard.responses.index", [
            "title" => "Tanggapan",
            "responses" => $responses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.responses.create", [
            "title" => "Buat Tanggapan",
            "complaints" => Complaint::all(),
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
            "complaint_id" => ["required"],
            "body" => ["required"],
        ]);

        // Convert slug into id
        $credentials["complaint_id"] = Complaint::where('slug', $credentials["complaint_id"])->first()->id;
        $credentials["officer_nik"] = $credentials["student_nik"] = auth()->user()->nik ?? null;

        try {
            $response = Response::create($credentials);
            return redirect('/dashboard/responses/' . $response->id)->with('success', 'Tanggapan kamu berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect('/dashboard/responses')->withErrors('Tanggapan kamu gagal dibuat.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function show(Response $response)
    {
        return view("dashboard.responses.show", [
            "title" => "Tanggapan",
            "response" => $response,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function edit(Response $response)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Response $response)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function destroy(Response $response)
    {
        //
    }
}
