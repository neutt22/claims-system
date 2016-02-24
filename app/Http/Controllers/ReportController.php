<?php

namespace App\Http\Controllers;

use App\Info;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{

    public function getReport()
    {
        $infos = Info::all();

        $total_claims = count($infos);

        $total_coc = 0;
        foreach($infos as $info){
            if($info->coc != null){
                $total_coc += 1;
            }
        }

        $total_dm = 0;
        foreach($infos as $info){
            if($info->dm != null){
                $total_dm += 1;
            }
        }

        $total_policy = 0;
        foreach($infos as $info){
            if($info->policy != null){
                $total_policy += 1;
            }
        }

        $incomplete_docs = 0;
        foreach($infos as $info){
            if($info->documents == 'incomplete'){
                $incomplete_docs += 1;
            }
        }

        $claims_amount = [];
        $total = 0;
        $pending = 0;
        $approved = 0;
        foreach($infos as $info){
            $total += $info->amount;

            if($info->claim_status == 'pending'){
                $pending += $info->amount;
            }

            if($info->claim_status == 'approved'){
                $approved += $info->amount;
            }
        }
        $claims_amount['pending'] = $pending;
        $claims_amount['total'] = $total;
        $claims_amount['approved'] = $approved;

        $stats = array_fill_keys(array('denied', 'approved', 'closed', 'pending'), 0);
        foreach($infos as $info){
            if($info->claim_status == 'denied') $stats['denied'] += 1;
            if($info->claim_status == 'approved') $stats['approved'] += 1;
            if($info->claim_status == 'closed') $stats['closed'] += 1;
            if($info->claim_status == 'pending') $stats['pending'] += 1;
        }

        $total_check_released = 0;
        foreach($infos as $info){
            if($info->check_released == 'yes'){
                $total_check_released += 1;
            }
        }

        return view('reports')
            ->with('total_claims', $total_claims)
            ->with('total_coc', $total_coc)
            ->with('total_dm', $total_dm)
            ->with('total_policy', $total_policy)
            ->with('incomplete_docs', $incomplete_docs)
            ->with('claims_amount', $claims_amount)
            ->with('stats', $stats)
            ->with('total_check_released', $total_check_released)
            ->with('infos', $infos);
    }

    public function getQuickReport(){

        $date = \Carbon\Carbon::today('Asia/Manila');
        $excelName = 'Claims System Report ' . $date->format('d/m/Y');

        \Excel::create($excelName, function($excel) {

            $excel->sheet('Quick Report', function($sheet) {

                // Change font style
                $sheet->setStyle(array(
                    'font' => array(
                        'name' => 'Arial',
                        'size' => 10,
                    )
                ));

                // Change cells background color
                $sheet->cells('A1:X1', function($cells){
                    $cells->setFontColor('#D0CBCB');
                    $cells->setBackground('#404040');
                    $cells->setFontWeight('bold');
                });

                // Populate data from model
                $sheet->fromModel(\App\Info::all());

            });

        })->export('xlsx');
    }
}
