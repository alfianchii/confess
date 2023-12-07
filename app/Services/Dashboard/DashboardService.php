<?php

namespace App\Services\Dashboard;

use App\Services\Service;
use App\Models\{User, DTOfficer, DTStudent, RecConfession, HistoryConfessionResponse, HistoryLogin, MasterRole, RecConfessionComment};
use App\Models\Traits\{Daily};

class DashboardService extends Service
{
    // ---------------------------------
    // TRAITS
    use Daily;


    // ---------------------------------
    // CORES
    public function index(User $user, MasterRole $userRole)
    {
        $roleName = $userRole->role_name;
        if ($roleName === "admin") return $this->adminIndex($user);
        if ($roleName === "officer") return $this->officerIndex($user);
        if ($roleName === "student") return $this->studentIndex($user);

        return view("errors.403");
    }


    // ---------------------------------
    // UTILITIES
    // ADMIN
    private function adminIndex(User $user)
    {
        $confessionsCount = RecConfession::recentConfessions(null)->count();
        $recentConfessions = RecConfession::recentConfessions(6)->get();

        $usersCount = User::count();
        $inactiveUsersCount = User::where("flag_active", "N")->count();

        $officersCount = DTOfficer::officerRoles()
            ->where("role_name", "officer")
            ->count();
        $studentsCount = DTStudent::count();

        $responsesCount = HistoryConfessionResponse::recentResponses(null)->count();
        $recentResponses = HistoryConfessionResponse::recentResponses(10, $user)->paginateResponsesFromConfession(self::PER_PAGE);

        $commentsCount = RecConfessionComment::count();

        $historyLoginsCount = HistoryLogin::recentHistoryLogins(null)->count();

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
    private function officerIndex(User $user)
    {
        $confessionsCount = RecConfession::count();
        $recentConfessions = RecConfession::recentConfessions(4)->get();

        $officersCount = DTOfficer::officerRoles()
            ->where("role_name", "officer")
            ->count();
        $studentsCount = DTStudent::count();

        $responsesCount = HistoryConfessionResponse::where("system_response", "N")->count();
        $recentResponses = HistoryConfessionResponse::recentResponses(15, $user)->paginateResponsesFromConfession(self::PER_PAGE);

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
    private function studentIndex(User $user)
    {
        $yourConfessionsCount = RecConfession::where("id_user", $user->id_user)->count();
        $yourRecentConfessions = RecConfession::recentConfessions(4, $user)->get();

        $responsesFromYourConfessionCount = HistoryConfessionResponse::yourRecentResponsesFromConfession(null, $user)->count();
        $recentResponsesFromYourConfession = HistoryConfessionResponse::yourRecentResponsesFromConfession(10, $user)->paginateResponsesFromConfession(self::PER_PAGE);

        $yourCommentsCount = RecConfessionComment::where("id_user", $user->id_user)->count();

        $yourHistoryLoginsCount = HistoryLogin::recentHistoryLogins(null, $user)->count();

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
