<?php

namespace App\Http\Middleware;

use Closure;
use App\Config;
use Carbon\Carbon;

class SendReportForToday
{

    public function handle($request, Closure $next)
    {
        $today = Carbon::now('Asia/Manila');

        $report_date = Config::find(1);

        // Send a report if today is not set to our config table
        if
        (
            $report_date->report_date->day != $today->day
         || $report_date->report_date->month != $today->month
         || $report_date->report_date->year != $today->year
        )
        {
            $report_date->report_date = $today;
            $report_date->save();

            // TODO: Send an email for reporting here...
        }

        return $next($request);
    }
}
