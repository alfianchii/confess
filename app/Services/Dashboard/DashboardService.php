<?php

namespace App\Services\Dashboard;

use App\Models\{User, DTOfficer, DTStudent, RecConfession, HistoryConfessionResponse, HistoryLogin, MasterRole, RecConfessionComment};
use App\Models\Traits\Daily;
use App\Services\Service;

class DashboardService extends Service
{
    // ---------------------------------
    // TRAITS
    use Daily;


    // ---------------------------------
    // CORES
    public function index(User $user, MasterRole $userRole)
    {
        // Roles checking
        $roleName = $userRole->role_name;
        if ($roleName === "admin") return $this->adminIndex($user);
        if ($roleName === "officer") return $this->officerIndex($user);
        if ($roleName === "student") return $this->studentIndex($user);

        // Redirect to unauthorized page
        return view("errors.403");
    }


    // ---------------------------------
    // UTILITIES
    // ADMIN
    // Index
    private function adminIndex(User $user)
    {
        // Confessions count
        $confessionsCount = RecConfession::recentConfessions(null)->count();
        // Recent confessions
        $recentConfessions = RecConfession::recentConfessions(6)->get();

        // Users
        $usersCount = User::count();
        // Inactive users
        $inactiveUsersCount = User::where("flag_active", "N")->count();

        // Officers
        $officersCount = DTOfficer::officerRoles()
            ->where("role_name", "officer")
            ->count();
        // Students
        $studentsCount = DTStudent::count();

        // Responses
        $responsesCount = HistoryConfessionResponse::recentResponses(null)->count();
        // Recent responses
        $recentResponses = HistoryConfessionResponse::recentResponses(10, $user)->paginateResponsesFromConfession(self::PER_PAGE);

        // Comments
        $commentsCount = RecConfessionComment::count();

        // History logins
        $historyLoginsCount = HistoryLogin::recentHistoryLogins(null)->count();

        // Passing out a view
        $viewVariables = [
            "title" => "Dashboard",
            "greeting" => $this->greeting(),
            "confessionsCount" => $confessionsCount,
            "recentConfessions" => $recentConfessions,
            "usersCount" => $usersCount,
            "inactiveUsersCount" => $inactiveUsersCount,
            "officersCount" => $officersCount,
            "studentsCount" => $studentsCount,
            "responsesCount" => $responsesCount,
            "commentsCount" => $commentsCount,
            "historyLoginsCount" => $historyLoginsCount,
            "recentResponses" => $recentResponses,
        ];
        return view("pages.dashboard.actors.admin.dashboard.index", $viewVariables);
    }

    // OFFICER
    // Index
    private function officerIndex(User $user)
    {
        // Confessions count
        $confessionsCount = RecConfession::count();
        // Recent confessions
        $recentConfessions = RecConfession::recentConfessions(4)->get();

        // Officers
        $officersCount = DTOfficer::officerRoles()
            ->where("role_name", "officer")
            ->count();
        // Students
        $studentsCount = DTStudent::count();

        // Responses
        $responsesCount = HistoryConfessionResponse::where("system_response", "N")->count();
        // Recent responses
        $recentResponses = HistoryConfessionResponse::recentResponses(15, $user)->paginateResponsesFromConfession(self::PER_PAGE);

        // Passing out a view
        $viewVariables = [
            "title" => "Dashboard",
            "greeting" => $this->greeting(),
            "confessionsCount" => $confessionsCount,
            "recentConfessions" => $recentConfessions,
            "officersCount" => $officersCount,
            "studentsCount" => $studentsCount,
            "responsesCount" => $responsesCount,
            "recentResponses" => $recentResponses,
        ];
        return view("pages.dashboard.actors.officer.dashboard.index", $viewVariables);
    }

    // STUDENT
    // Index
    private function studentIndex(User $user)
    {
        // Your confessions count
        $yourConfessionsCount = RecConfession::where("id_user", $user->id_user)->count();
        // Your recent confessions
        $yourRecentConfessions = RecConfession::recentConfessions(4, $user)->get();

        // Your responses count
        $responsesFromYourConfessionCount = HistoryConfessionResponse::yourRecentResponsesFromConfession(null, $user)->count();
        // Your recent responses (based on your confessions)
        $recentResponsesFromYourConfession = HistoryConfessionResponse::yourRecentResponsesFromConfession(10, $user)->paginateResponsesFromConfession(self::PER_PAGE);

        // Your comments count
        $yourCommentsCount = RecConfessionComment::where("id_user", $user->id_user)->count();

        // Your history logins
        $yourHistoryLoginsCount = HistoryLogin::recentHistoryLogins(null, $user)->count();

        // Passing out a view
        $viewVariables = [
            "title" => "Dashboard",
            "greeting" => $this->greeting(),
            "yourConfessionsCount" => $yourConfessionsCount,
            "yourRecentConfessions" => $yourRecentConfessions,
            "responsesFromYourConfessionCount" => $responsesFromYourConfessionCount,
            "recentResponsesFromYourConfession" => $recentResponsesFromYourConfession,
            "yourCommentsCount" => $yourCommentsCount,
            "yourHistoryLoginsCount" => $yourHistoryLoginsCount,
        ];
        return view("pages.dashboard.actors.student.dashboard.index", $viewVariables);
    }
}
