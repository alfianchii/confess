<?php

namespace App\Http\Controllers\Dashboards;

use App\Models\{Response, Complaint};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DashboardResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $responses = Response::with(["officer", "complaint"])->where("officer_nik", auth()->user()->nik)->get()->sortByDesc("created_at") ?? [];

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
    public function create(Request $request, Complaint $complaint)
    {
        $previousUrl = $request->headers->get('referer');

        // Short the responses based on new response (date)
        $sortedResponses = $complaint->responses->sortByDesc("created_at");

        return view("dashboard.responses.create", [
            "title" => "Buat Tanggapan",
            "complaint" => $complaint,
            "responses" => $sortedResponses,
            "previousUrl" => $previousUrl,
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
            "status" => ["required", "numeric", "integer"],
        ]);

        $credentials["officer_nik"] = auth()->user()->nik ?? null;

        try {
            // Create response
            $response = Response::create($credentials);
            // Update status
            Complaint::where('id', $response->complaint_id)->update(['status' => $credentials["status"]]);
            // Redirect to response with id
            return redirect('/dashboard/responses/create/' . $response->complaint->slug)->with('success', 'Tanggapan kamu berhasil dibuat!');
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
    public function show(Request $request, Response $response)
    {
        $previousUrl = $request->headers->get('referer');

        // Validate if the response is owned by the user
        if ($response->officer_nik !== auth()->user()->nik) {
            return redirect('/dashboard/responses')->withErrors('Kamu bukan pemilik dari tanggapan tersebut.');
        }

        return view("dashboard.responses.show", [
            "title" => "Tanggapan",
            "response" => $response,
            "previousUrl" => $previousUrl
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Response $response)
    {
        $previousUrl = $request->headers->get('referer');

        // Validate if the response is owned by the user
        if ($response->officer_nik !== auth()->user()->nik) {
            return redirect('/dashboard/responses')->withErrors('Kamu bukan pemilik dari tanggapan tersebut.');
        }

        return view("dashboard.responses.edit", [
            "title" => "Sunting Tanggapan",
            "response" => $response,
            "complaint" => $response->complaint,
            "previousUrl" => $previousUrl,
        ]);
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
        $credentials = $request->validate([
            "complaint_id" => ["required"],
            "body" => ["required"],
            "status" => ["required", "numeric", "integer"],
        ]);

        try {
            // Get the new and old of $response
            $responseOld = $response->fresh();
            $response->update($credentials);
            $responseNew = $response->fresh();

            // Get the old and new versions of the model as arrays
            $oldAttributes = $responseOld->getAttributes();
            $newAttributes = $responseNew->getAttributes();

            // Compare the arrays to see if any attributes have changed
            if (($oldAttributes === $newAttributes) && ($response->complaint->status === $credentials["status"])) {
                // The instance of the $complaint record has not been updated
                return redirect('/dashboard/responses/' . $response->id)->with('info', 'Kamu tidak melakukan editing pada tanggapan.');
            }

            // Update status
            Complaint::where('id', $responseNew->complaint_id)->update(['status' => $credentials["status"]]);

            // The instance of the $complaint record has been updated
            return redirect('/dashboard/responses/' . $response->id)->with('success', 'Tanggapan kamu berhasil di-edit!');
        } catch (\Exception $e) {
            return redirect('/dashboard/responses')->withErrors('Tanggapan kamu gagal di-edit.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function destroy(Response $response)
    {
        // Validate if the response is owned by the user
        if ($response->officer_nik !== auth()->user()->nik) {
            return response()->json([
                "message" => "Kamu bukan pemilik dari tanggapan tersebut.",
            ], 401);
        }

        try {
            if (!Response::destroy($response->id)) {
                throw new \Exception('Error deleting complaint.');
            }
        } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
            return response()->json([
                "message" => "Gagal menghapus tanggapan.",
            ], 422);
        } catch (\Throwable $e) {
            // catch all exceptions here
            return response()->json([
                "message" => "An error occurred: " . $e->getMessage()
            ], 500);
        }

        return response()->json([
            "message" => "Tanggapan kamu telah dihapus!",
        ], 200);
    }
}
