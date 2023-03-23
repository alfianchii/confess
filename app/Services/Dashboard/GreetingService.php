<?php

namespace App\Services\Dashboard;

use Carbon\Carbon;

class GreetingService
{
    public function dashboardGreeting()
    {
        // Timezone
        $currentTime = Carbon::now();
        $hour = $currentTime->hour;

        if ($hour >= 5 && $hour <= 13) {
            $greeting = 'Selamat pagi';
        } elseif ($hour >= 14 && $hour <= 17) {
            $greeting = 'Selamat sore';
        } else {
            $greeting = 'Selamat malam';
        }

        return $greeting;
    }
}
