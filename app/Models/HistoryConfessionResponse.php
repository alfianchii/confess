<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use App\Models\Traits\{Daily, Setable};
use App\Models\Traits\Helpers\{Responsible};

class HistoryConfessionResponse extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory, SoftDeletes, Daily, Responsible, Setable;


    // ---------------------------------
    // PROPERTIES
    protected $table = "history_confession_responses";
    protected $primaryKey = "id_confession_response";
    protected $guarded = [
        'id_confession_response',
    ];


    // ---------------------------------
    // RELATIONSHIPS
    public function confession()
    {
        return $this->belongsTo(RecConfession::class, "id_confession", "id_confession");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "id_user", "id_user");
    }

    public function student()
    {
        return $this->belongsTo(DTStudent::class, "id_user", "id_user");
    }

    public function officer()
    {
        return $this->belongsTo(DTOfficer::class, "id_user", "id_user");
    }


    // ---------------------------------
    // HELPERS
    public static function yourResponseAxises(User $user)
    {
        $axises = [
            'xAxis' => [],
            'yAxis' => [],
        ];

        $responses = HistoryConfessionResponse::where("id_user", $user->id_user)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->groupBy('date', "created_at")
            ->oldest("date")
            ->get();

        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $date) {
            $counts = 0;

            foreach ($responses as $response) {
                if ($date->format("Y-m-d") == $response->date) $counts += $response->count;
            }

            $axises['yAxis'][] = $counts;
            $axises['xAxis'][] = $date->format("Y-m-d");
        }

        return $axises;
    }

    public static function responseAxises()
    {
        $axises = [
            "data" => [
                'xAxis' => [],
                'yAxis' => [],
            ],
            "genders" => [
                'male' => 0,
                'female' => 0,
            ],
        ];

        $responses = HistoryConfessionResponse::whereBetween("history_confession_responses.created_at", [now()->startOfMonth(), now()->endOfMonth()])
            ->selectRaw("DATE(history_confession_responses.created_at) as date, COUNT(*) as count")
            ->groupBy("date")
            ->oldest("date")
            ->get();

        $genders = HistoryConfessionResponse::leftJoin("dt_officers", "history_confession_responses.id_user", "=", "dt_officers.id_user")
            ->leftJoin("mst_users", "dt_officers.id_user", "=", "mst_users.id_user")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'L' THEN 1 ELSE 0 END) as male")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'P' THEN 1 ELSE 0 END) as female")
            ->first()->attributes;

        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $date) {
            $counts = 0;

            foreach ($responses as $response) {
                if ($date->format("Y-m-d") == $response->date) $counts += $response->count;
            }

            $axises["data"]['yAxis'][] = $counts;
            $axises["data"]['xAxis'][] = $date->format("Y-m-d");
        }

        foreach ($genders as $key => $value) {
            $axises['genders'][$key] = (int) $value;
        }

        return $axises;
    }

    public function scopeRecentResponses($query, int $limit = null, User $user = null)
    {
        $query->with(['confession', "user.userRole.role"])
            ->select("history_confession_responses.*")
            ->leftJoin("mst_users", "history_confession_responses.id_user", "=", "mst_users.id_user")
            ->leftJoin("rec_confessions", "history_confession_responses.id_confession", "=", "rec_confessions.id_confession")
            ->latest();

        if ($user) $query->where("history_confession_responses.id_user", "!=", $user->id_user);

        if (!$limit) return $query;

        return $query
            ->where("history_confession_responses.system_response", "N")
            ->limit($limit);
    }

    public function scopeYourRecentResponsesFromConfession($query, int $limit = null, User $user)
    {
        $query->with(['confession.responses', 'user.userRole.role'])
            ->select("history_confession_responses.*")
            ->leftJoin("mst_users", "history_confession_responses.id_user", "=", "mst_users.id_user")
            ->leftJoin("mst_users_role", "mst_users_role.id_user", "=", "mst_users.id_user")
            ->leftJoin("mst_roles", "mst_roles.id_role", "=", "mst_users_role.id_role")
            ->leftJoin("rec_confessions", "history_confession_responses.id_confession", "=", "rec_confessions.id_confession")
            ->where("history_confession_responses.id_user", "!=", $user->id_user)
            ->where("rec_confessions.id_user", $user->id_user)
            ->where("mst_roles.role_name", "officer")
            ->latest();

        if (!$limit) return $query;

        return $query->limit($limit);
    }

    public static function setResponse(User $user, RecConfession $confession, $response = null, $status = null, $system = "N", $params = [])
    {
        if (!$response) $response = self::setResponseSystem($user, $status);
        $fields = self::getResponseFields($user, $confession, $response, $status, $system);
        if (!empty($params)) $fields = self::setOtherFields($fields, $params);
        $confession->update(["updated_at" => now()]);
        return HistoryConfessionResponse::create($fields);
    }

    public function scopePaginateResponsesFromConfession($query, int $perPage)
    {
        return $query
            ->with(["confession.responses"])
            ->get()
            ->each(function ($response) use ($perPage) {
                $confessionResponses = $response->confession->responses;
                $total = $confessionResponses->count();
                $pageNumbers = (int) ceil($total / $perPage);

                $pagedResponses = $this->getPagedConfessionResponses($total, $perPage, $pageNumbers, $confessionResponses);
                $response->page = $this->setResponsePage($pagedResponses, $response);
            });
    }
}
