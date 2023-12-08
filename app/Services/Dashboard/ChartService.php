<?php

namespace App\Services\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\Service;
use App\Models\{HistoryConfessionLike, User, RecConfession, HistoryConfessionResponse, HistoryLogin, MasterRole, RecConfessionComment};

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

    public function isAuthorize(int $userSession, $session)
    {
        if ($userSession !== $session) return response()->json([
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
        $userSession = session("issued_time");
        $this->isAuthorize($userSession, $credentials["session"]);

        $roleName = $userRole->role_name;

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
    // ADMIN
    private function adminChart(User $user, array $results)
    {
        $confessionAxises = RecConfession::confessionAxises();

        $responseAxises = HistoryConfessionResponse::responseAxises();

        $yourCommentAxises = RecConfessionComment::yourCommentAxises($user);
        $commentAxises = RecConfessionComment::commentAxises();

        $yourConfessionLikeAxises = HistoryConfessionLike::yourConfessionLikeAxises($user);
        $confessionLikeAxises = HistoryConfessionLike::confessionLikeAxises();

        $yourHistoryLoginAxises = HistoryLogin::yourHistoryLoginAxises($user);
        $historyLoginAxises = HistoryLogin::historyLoginAxises();

        $results['chart']["data"]["allConfessions"] = $confessionAxises;
        $results['chart']["data"]["allResponses"] = $responseAxises;
        $results['chart']["data"]["allComments"] = $commentAxises;
        $results['chart']["data"]["yourComments"] = $yourCommentAxises;
        $results['chart']["data"]["allLikes"] = $confessionLikeAxises;
        $results['chart']["data"]["yourLikes"] = $yourConfessionLikeAxises;
        $results['chart']["data"]["allHistoryLogins"] = $historyLoginAxises;
        $results['chart']["data"]["yourHistoryLogins"] = $yourHistoryLoginAxises;

        return response()->json($results);
    }


    // OFFICER
    private function officerChart(User $user, array $results)
    {
        $confessionGenderAxises = RecConfession::confessionAxises()["genders"];

        $yourResponseAxises = HistoryConfessionResponse::yourResponseAxises($user);

        $yourCommentAxises = RecConfessionComment::yourCommentAxises($user);

        $yourConfessionLikeAxises = HistoryConfessionLike::yourConfessionLikeAxises($user);

        $yourHistoryLoginAxises = HistoryLogin::yourHistoryLoginAxises($user);

        $results['chart']["data"]["confessionGenders"] = $confessionGenderAxises;
        $results['chart']["data"]["yourResponses"] = $yourResponseAxises;
        $results['chart']["data"]["yourComments"] = $yourCommentAxises;
        $results['chart']["data"]["yourLikes"] = $yourConfessionLikeAxises;
        $results['chart']["data"]["yourHistoryLogins"] = $yourHistoryLoginAxises;

        return response()->json($results);
    }


    // STUDENT
    private function studentChart(User $user, array $results)
    {
        $yourConfessionAxises = RecConfession::yourConfessionAxises($user);

        $yourResponseAxises = HistoryConfessionResponse::yourResponseAxises($user);

        $yourCommentAxises = RecConfessionComment::yourCommentAxises($user);

        $yourConfessionLikeAxises = HistoryConfessionLike::yourConfessionLikeAxises($user);

        $yourHistoryLoginAxises = HistoryLogin::yourHistoryLoginAxises($user);

        $results['chart']["data"]["yourConfessions"] = $yourConfessionAxises;
        $results['chart']["data"]["yourResponses"] = $yourResponseAxises;
        $results['chart']["data"]["yourComments"] = $yourCommentAxises;
        $results['chart']["data"]["yourLikes"] = $yourConfessionLikeAxises;
        $results['chart']["data"]["yourHistoryLogins"] = $yourHistoryLoginAxises;

        return response()->json($results);
    }
}
