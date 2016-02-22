<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{

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
