<?php

namespace App\Http\Controllers;

use App\Info;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
	protected $request;

    public function __construct(Request $request){
    	$this->request = $request;
        $this->middleware('auth');
    }

    public function getDeadLine(Info $i)
    {
        return $i->getDeadLine();
    }

    public function index(Info $i, $column = 'id', $type = null) {

        $infos = Info::all();

    	$total = $infos->count();

        $chart_inc = array_fill_keys(array('dm', 'policy', 'documents'), 0);

        foreach($infos as $info){
            if($info->dm == '') $chart_inc['dm'] += 1;
            if($info->policy == '') $chart_inc['policy'] += 1;
            if($info->documents == 'incomplete') $chart_inc['documents'] += 1;
        }

    	$chart_complete = array_fill_keys(array('documents'), 0);

        foreach($infos as $info){
            if($info->documents == 'complete') $chart_complete['documents'] += 1;
        }

    	$chart_complete['dm'] = $total - $chart_inc['dm'];
    	$chart_complete['policy'] = $total - $chart_inc['policy'];

    	$stages = [];
    	$stages['stage_1'] = Info::where('stage', '=', 1)->get()->count();
    	$stages['stage_2'] = Info::where('stage', '=', 2)->get()->count();
    	$stages['stage_3'] = Info::where('stage', '=', 3)->get()->count();
    	$stages['stage_4'] = Info::where('stage', '=', 4)->get()->count();

    	$stats = [];
    	$stats['denied'] = Info::where('claim_status', '=', 'denied')->get()->count();
    	$stats['approved'] = Info::where('claim_status', '=', 'approved')->get()->count();
    	$stats['closed'] = Info::where('claim_status', '=', 'closed')->get()->count();
    	$stats['pending'] = Info::where('claim_status', '=', 'pending')->get()->count();

    	$months = array_fill_keys(
            array(
                'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul',
                'aug', 'sep', 'oct', 'nov', 'dec',
            ),
            0
        );

        foreach($infos as $m){
            if($m->encoded->month == '1') $months['jan'] += 1;
            if($m->encoded->month == '2') $months['feb'] += 1;
            if($m->encoded->month == '3') $months['mar'] += 1;
            if($m->encoded->month == '4') $months['apr'] += 1;
            if($m->encoded->month == '5') $months['may'] += 1;
            if($m->encoded->month == '6') $months['jun'] += 1;
            if($m->encoded->month == '7') $months['jul'] += 1;
            if($m->encoded->month == '8') $months['aug'] += 1;
            if($m->encoded->month == '9') $months['sep'] += 1;
            if($m->encoded->month == '10') $months['oct'] += 1;
            if($m->encoded->month == '11') $months['nov'] += 1;
            if($m->encoded->month == '12') $months['dec'] += 1;
        }

        $claims_amount = $i->claimsAmount();

        $column = $i->getColumn($column);
        $type = $i->getType($type);
    	
    	return view('home')
    		->with('chart_inc', $chart_inc)
    		->with('chart_complete', $chart_complete)
    		->with('stages', $stages)
    		->with('stats', $stats)
    		->with('months', $months)
    		->with('info', Info::orderBy($column, $type)->get())
            ->with('claims_amount', $claims_amount)
            ->with('message', session('message'))
            ->with('type', $type)
            ->with('column', $column)
            ->with('symbol', $i->getSymbol($type));
    }

    public function new_record() {
        return view('new_record');
    }

    public function post_new_record() {

        $this->validate($this->request,[
            'name' => 'required',
            'claimant' => 'required',
            'coc' => 'required',
            'inception' => 'required',
        ]);

        $info = new Info;
        $info->name = $this->request->input('name');
        $info->claimant = $this->request->input('claimant');
        $info->coc = $this->request->input('coc');
        $info->inception = \Carbon\Carbon::parse($this->request->input('inception'));
        $info->dm = $this->request->input('dm');
        $info->policy = $this->request->input('policy');
        $info->documents = $this->request->input('docs');
        $info->documents_comments = $this->request->input('docs_comments');
        $info->encoded = \Carbon\Carbon::now();
        $info->amount = $this->request->input('amount');
        $info->stage = 1;
        $info->claim_status = 'pending';
        $info->scanned = 'no';
        $info->transmitted = 'no';
        $info->followed_up = 'no';
        $info->check_released = 'no';
        $info->dead_line = $info->getDeadLine();

        if( $info->save() ) {
            return view('new_record')->with('message', 'New item has been recorded.');
        }else {
            return 'Something went wrong recording, please contact master Jim from GIBX';
        }
    }

    public function update_record() {

        $info = Info::find($this->request->input('id'));

        if( count($info) == 0 ) {
            return view('update_record');
        }

        return view('update_record')->withInfo($info);
    }

    public function post_update_record(Info $i) {

        $stage = $this->request->input('stage');

        if($stage == 1) {

            $this->validate($this->request,[
                'name' => 'required',
                'claimant' => 'required',
                'coc' => 'required',
                'inception' => 'required',
            ]);

            return $i->processStage1($this->request);
        }else if($stage == 2) {
            return $i->processStage2($this->request);
        }else if($stage == 3) {
            return $i->processStage3($this->request);
        }else if($stage == 4) {
            return $i->processStage4($this->request);
        }else {
            return redirect()->route('home');
        }
    }

    public function getLogout() {
        \Auth::logout();
        return redirect()->route('home');
    }
}
