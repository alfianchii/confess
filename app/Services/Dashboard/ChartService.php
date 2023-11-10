<?php

namespace App\Services\Dashboard;

use App\Models\{User, RecConfession, HistoryConfessionResponse, HistoryLogin, MasterRole, RecConfessionComment};
use App\Services\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ChartService extends Service
{
    // ---------------------------------
    // PROPERTIES
    protected array $rules = [
        "session" => ["required", "integer"]
    ];


    // ---------------------------------
    // HELPERS
    public function isValidate($validator)
    {
        if ($validator->fails()) return response()->json([
            "message" => "Some credentials were missing!",
            "error" => "Unprocessable Entity",
        ], 422);
    }

    public function isAuthorize(int $user_session, $session)
    {
        if ($user_session !== $session) return response()->json([
            "message" => "You are unauthorized!",
            "error" => "Forbidden",
        ], 403);
    }


    // ---------------------------------
    // CORES
    public function init(Request $request, User $user, MasterRole $userRole)
    {
        $data = $request->json()->all();
        $validator = Validator::make($data, $this->rules);
        $this->isValidate($validator);

        $credentials = $validator->validate();
        $user_session = session("issued_time");
        $this->isAuthorize($user_session, $credentials["session"]);

        // User's role
        $roleName = $userRole->role_name;

        // JSON response
        $results = [
            'chart' => [
                "data" => [],
            ],
            "authentication" => [
                "data" => [
                    "role" => $roleName,
                ],
            ],
        ];

        return $this->chart($user, $roleName, $results);
    }

    private function chart(User $user, string $roleName, array $results)
    {
        // Roles checking
        if ($roleName === "admin") return $this->adminChart($user, $results);
        if ($roleName === "officer") return $this->officerChart($user, $results);
        if ($roleName === "student") return $this->studentChart($user, $results);
    }

    public function index(Request $request, User $user, MasterRole $userRole)
    {
        return $this->init($request, $user, $userRole);
    }


    // ---------------------------------
    // UTILITIES
    private function adminChart(User $user, array $results)
    {
        // Confession
        $confessionAxises = RecConfession::confessionAxises();

        // Response
        $responseAxises = HistoryConfessionResponse::responseAxises();

        // Comment
        $yourCommentAxises = RecConfessionComment::yourCommentAxises($user);
        $commentAxises = RecConfessionComment::commentAxises();

        // Login History
        $yourHistoryLoginAxises = HistoryLogin::yourHistoryLoginAxises($user);
        $historyLoginAxises = HistoryLogin::historyLoginAxises();

        // Fill out
        $results['chart']["data"]["allConfessions"] = $confessionAxises;
        $results['chart']["data"]["allResponses"] = $responseAxises;
        $results['chart']["data"]["allComments"] = $commentAxises;
        $results['chart']["data"]["yourComments"] = $yourCommentAxises;
        $results['chart']["data"]["allHistoryLogins"] = $historyLoginAxises;
        $results['chart']["data"]["yourHistoryLogins"] = $yourHistoryLoginAxises;

        // Return as JSON format
        return response()->json($results);
    }

    private function officerChart(User $user, array $results)
    {
        // Confession
        $confessionGenderAxises = RecConfession::confessionAxises()["genders"];

        // Response
        $yourResponseAxises = HistoryConfessionResponse::yourResponseAxises($user);

        // Comment
        $yourCommentAxises = RecConfessionComment::yourCommentAxises($user);

        // Login History
        $yourHistoryLoginAxises = HistoryLogin::yourHistoryLoginAxises($user);

        // Fill out
        $results['chart']["data"]["confessionGenders"] = $confessionGenderAxises;
        $results['chart']["data"]["yourResponses"] = $yourResponseAxises;
        $results['chart']["data"]["yourComments"] = $yourCommentAxises;
        $results['chart']["data"]["yourHistoryLogins"] = $yourHistoryLoginAxises;

        // Return as JSON format
        return response()->json($results);
    }

    private function studentChart(User $user, array $results)
    {
        // Confession
        $yourConfessionAxises = RecConfession::yourConfessionAxises($user);

        // Response
        $yourResponseAxises = HistoryConfessionResponse::yourResponseAxises($user);

        // Comment
        $yourCommentAxises = RecConfessionComment::yourCommentAxises($user);

        // Login History
        $yourHistoryLoginAxises = HistoryLogin::yourHistoryLoginAxises($user);

        // Fill out
        $results['chart']["data"]["yourConfessions"] = $yourConfessionAxises;
        $results['chart']["data"]["yourResponses"] = $yourResponseAxises;
        $results['chart']["data"]["yourComments"] = $yourCommentAxises;
        $results['chart']["data"]["yourHistoryLogins"] = $yourHistoryLoginAxises;

        // Return as JSON format
        return response()->json($results);
    }
}
