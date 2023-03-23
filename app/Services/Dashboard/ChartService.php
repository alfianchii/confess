<?php

namespace App\Services\Dashboard;

use App\Models\{Response, Complaint};

class ChartService
{
    public function yourResponseAxises()
    {
        return Response::yourResponseAxises();
    }

    public function allResponseAxises()
    {
        return Response::allResponseAxises();
    }

    public function yourComplaintAxises()
    {
        return Complaint::yourComplaintAxises();
    }

    public function allComplaintAxises()
    {
        return Complaint::allComplaintAxises();
    }

    public function responses($user)
    {
        // Response
        $responseAxises = $this->yourResponseAxises();
        $allResponseAxises = $this->allResponseAxises();

        // Complaint
        $complaintAxises = $this->yourComplaintAxises();
        $allComplaintAxises = $this->allComplaintAxises();

        // JSON response
        $results = [
            'chart' => [
                "data" => [],
            ],
            "authentication" => [
                "data" => [
                    "level" => auth()->user()->level,
                ],
            ],
        ];

        // Check level
        if ($user->level === "admin") {
            // All complaints
            $results['chart']["data"]["allComplaints"] = $allComplaintAxises;
            // All responses
            $results['chart']["data"]["allResponses"] = $allResponseAxises;
            // Your responses
            $results['chart']["data"]["responses"] = $responseAxises;
        } else if ($user->level === "officer") {
            $results['chart']["data"]["allResponses"] = $allResponseAxises;
            $results['chart']["data"]["responses"] = $responseAxises;
        } else if ($user->level === "student") {
            $results['chart']["data"]["allComplaints"] = $allComplaintAxises;
            $results['chart']["data"]["complaints"] = $complaintAxises;
        }

        return response()->json($results);
    }
}
