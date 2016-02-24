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

            $deadline_names = [];

            $i = new \App\Info;

            foreach(\App\Info::all() as $info){
                $deadline = $i->isDeadLineToday($info->dead_line);

                if($deadline == 'deadline' && $info->claim_status != 'approved'){
                    $deadline_names[$info->name] = $info;
                }
            }

            $data = array(
                'data' =>   $deadline_names,
            );

            \Log::info('Sending mail....');

            \Mail::send('email.email', $data, function ($message) {

                $message->from('ovejera.jimpaulo@gmail.com', 'GIBX Internal System');

                $date = \Carbon\Carbon::today('Asia/Manila')->format('d/m/Y');

                $recipients = [
                    'f360.jovejera@gmail.com',
                    'ddcruz@gibco.guevent.com',
                    'fvgazzingan@f360.guevent.com',
                    'foalcazar@f360.guevent.com',
                    'mlsantos@gibco.guevent.com',
                    'llcustodio@gibco.guevent.com',
                    'echavarria@guevent.com',
                    'ethel_chavarria@yahoo.com',
                    'paodelro@gmail.com',
                    'psdelrosario@gibco.guevent.com',
                    'domcruzged.am@gmail.com',
                    'ag@guevent.com'
                ];
                $message->to($recipients)->subject('GIBX Claims System Daily Report ' . $date);

            });

            // TODO: Send an email for reporting here...
        }

        return $next($request);
    }
}
