<?php

namespace App\Models;

use App\Models\Traits\Daily;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use function PHPUnit\Framework\isEmpty;

class HistoryConfessionResponse extends Model
{
    // ---------------------------------
    // TRAITS
    use HasFactory, SoftDeletes, Daily;


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
    /*
        Data Scheme:
            xAxis
            yAxis
    */
    public static function yourResponseAxises(User $user)
    {
        // Your responses
        $responses = HistoryConfessionResponse::where("id_user", $user->id_user)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            // Select the date of creation and count of responses for each day
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            // Group the results by the date of creation
            ->groupBy('date', "created_at")
            // Order the results by date in ascending order
            ->oldest("date")
            // Execute the query and retrieve the results
            ->get();

        // Create an array to store the response counts for each day
        $axises = [
            'xAxis' => [],
            'yAxis' => [],
        ];

        // Loop through the date range and populate the counts array with the responses counts
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

    /*
        Data Scheme:
            data
                xAxis
                yAxis
            genders
                male
                female
    */
    public static function responseAxises()
    {
        // All Responses
        $responses = HistoryConfessionResponse::whereBetween("history_confession_responses.created_at", [now()->startOfMonth(), now()->endOfMonth()])
            // Select the date of creation and count of responses for each day
            ->selectRaw("DATE(history_confession_responses.created_at) as date, COUNT(*) as count")
            // Group the results by the date of creation
            ->groupBy("date")
            // Order the results by date in ascending order
            ->oldest("date")
            // Execute the query and retrieve the results
            ->get();

        // All responses' genders
        $genders = HistoryConfessionResponse::leftJoin("dt_officers", "history_confession_responses.id_user", "=", "dt_officers.id_user")
            ->leftJoin("mst_users", "dt_officers.id_user", "=", "mst_users.id_user")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'L' THEN 1 ELSE 0 END) as male")
            ->selectRaw("SUM(CASE WHEN mst_users.gender = 'P' THEN 1 ELSE 0 END) as female")
            ->first()->attributes;

        // Create an array to store the all responses' data
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

        // Loop through the date range and populate the counts array with the all response counts
        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $date) {
            $counts = 0;

            foreach ($responses as $response) {
                if ($date->format("Y-m-d") == $response->date) $counts += $response->count;
            }

            $axises["data"]['yAxis'][] = $counts;
            $axises["data"]['xAxis'][] = $date->format("Y-m-d");
        }

        // Convert string to int
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

        // Filter by user
        if ($user) $query->where("history_confession_responses.id_user", "!=", $user->id_user);

        // Return the filtered results
        if (!$limit) return $query;

        // Return limited results
        return $query
            ->where("history_confession_responses.system_response", "N")
            ->limit($limit);
    }

    public function scopeYourRecentResponsesFromConfession($query, int $limit = null, User $user)
    {
        // Eager load the relationships and retrieve all records
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

        // Return the filtered results
        if (!$limit) return $query;

        // Return limited results
        return $query->limit($limit);
    }

    public static function setResponse(User $user, RecConfession $confession, $response = null, $status = null, $bySystem = "N", $params = [])
    {
        // System's response
        if (!$response) {
            $response = '<p>' . $user['full_name'];
            if ($status === "process") $response .= " picked this confession." . '</p>';
            if ($status === "release") $response .= " was released the confession." . '</p>';
            if ($status === "close") $response .= " closed this confession immediately. Thank you!" . '</p>';
        }

        // Response
        $responseFields = [
            "id_confession" => $confession->id_confession,
            "id_user" => $user["id_user"],
            "response" => $response ?? $confession->body,
            "confession_status" => $status ?? $confession->status,
            "created_by" => $user["full_name"],
            "system_response" => $bySystem,
        ];

        // Set another field
        if (isEmpty($params)) {
            foreach ($params as $key => $value) {
                $responseFields[$key] = $value;
            }
        };

        return HistoryConfessionResponse::create($responseFields);
    }

    // Populate the data based on the per page
    public function scopePaginateResponsesFromConfession($query, int $perPage)
    {
        return $query
            ->with(["confession.responses"])
            ->get()
            ->each(function ($response) use ($perPage) {
                // Get the confession's responses
                $responsesFromConfession = $response->confession->responses;

                // Take the sum of confession's responses
                $total = $responsesFromConfession->count();
                // Take the page numbers for the pagination's number
                $pageNumbers = (int) ceil($total / $perPage);

                // Slice the responses based on the $perPage
                $confessionResponses = [];
                // If more than $perPage (more than 1 page)
                if ($total >= $perPage)
                    for ($index = 0; $index < $pageNumbers; $index++)
                        $confessionResponses[] = $responsesFromConfession
                            ->skip($index * $perPage)
                            ->take($perPage)
                            ->all();
                // If less than $perPage (1 page)
                else
                    $confessionResponses[] = $responsesFromConfession->all();

                foreach ($confessionResponses as $items_index => $items) {
                    // Set the page
                    $page = $items_index + 1;

                    foreach ($items as $item)
                        // Regist the response's page to each response
                        if ($item->id_confession_response === $response->id_confession_response)
                            $response->page = $page;
                }
            });
    }


    // ---------------------------------
    // UTILITIES
}