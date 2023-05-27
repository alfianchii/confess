<?php

namespace App\Services\Dashboard;

use App\Models\{Complaint, Officer, Response, Student};
use Illuminate\Database\Eloquent\Collection;

class DashboardService
{
    protected $greetingService;

    public function __construct(GreetingService $greetingService)
    {
        $this->greetingService = $greetingService;
    }

    public function index($user): array
    {
        // Greetings
        $greeting = $this->greetingService->dashboardGreeting();

        $results = [
            "title" => "Dashboard",
            "greeting" => $greeting,
        ];

        if ($user->level === "admin" || $user->level === "officer") {
            // Complaints
            $complaints = Complaint::with(["student", "responses", "category"])->orderByDesc("created_at")->get();
            // Complaints count
            $complaintsCount = $complaints->count();
            // Recent complaints
            $recentComplaints = $complaints->where("status", "!=", '2')->slice(0, 3);

            // Officers
            $officersCount = Officer::all()->count();

            // Students
            $studentsCount = Student::all()->count();

            // Your responses
            $yourResponsesCount = Response::with(["officer", "complaint"])->where('officer_nik', $user->nik)->count();
            // Recent responses
            $recentResponses = Response::with(['officer', "complaint"])->orderByDesc("created_at")->get()->slice(0, 3);

            $results = array_merge($results, [
                "complaints" => $complaints,
                "complaintsCount" => $complaintsCount,
                "recentComplaints" => $recentComplaints,
                "officersCount" => $officersCount,
                "studentsCount" => $studentsCount,
                "yourResponsesCount" => $yourResponsesCount,
                "recentResponses" => $recentResponses,
            ]);
        } else if ($user->level === "student") {
            $complaints = Complaint::with(["student", "responses", "category"])->where("student_nik", $user->nik)->orderByDesc("created_at")->get();

            // Your complaints count
            $yourComplaintsCount = $complaints->count();

            // Recent complaints
            $recentComplaints = $complaints
                ->where("status", "!=", '2')
                ->slice(0, 3);

            // Responses (Student complaint's responses)
            $responsesStudent = new Collection();
            foreach ($complaints as $complaint) {
                if (!empty($complaint->responses)) {
                    foreach ($complaint->responses as $response) {
                        $responsesStudent->push($response);
                    }
                }
            }
            $responsesStudent = $responsesStudent->sortByDesc("created_at");

            // Responses student count
            $responsesStudentCount = $responsesStudent->count();

            $results = array_merge($results, [
                "recentComplaints" => $recentComplaints,
                "yourComplaintsCount" => $yourComplaintsCount,
                "recentResponsesStudent" => $responsesStudent->slice(0, 3),
                "responsesStudentCount" => $responsesStudentCount,
            ]);
        }

        return $results;
    }
}
