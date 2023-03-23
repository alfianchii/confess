<?php

namespace App\Services\Dashboard;

use App\Models\{Complaint, Officer, Response, Student};

class DashboardService
{
    protected $greetingService;

    public function __construct(GreetingService $greetingService)
    {
        $this->greetingService = $greetingService;
    }

    public function index(): array
    {
        // Greetings
        $greeting = $this->greetingService->dashboardGreeting();

        // Complaints
        $complaints = Complaint::orderByDesc("created_at")->get();

        // Officers
        $officers = Officer::all();

        // Students
        $students = Student::all();

        // Responses
        $responses = Response::orderByDesc("created_at")->get();

        $results = [
            "title" => "Dashboard",
            "greeting" => $greeting,
            "complaints" => $complaints,
            "officers" => $officers,
            "students" => $students,
            "responses" => $responses,
        ];

        return $results;
    }
}