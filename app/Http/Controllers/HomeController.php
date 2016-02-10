<?php

namespace App\Http\Controllers;

use App\Info;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	protected $request;

    public function __construct(Request $request){
    	$this->request = $request;
        $this->middleware('auth');
    }

    public function index() {
    	
    	$total = Info::all()->count();

    	$chart_inc = [];
    	$chart_inc['dm'] = Info::where('dm', '=', '')->get()->count();
    	$chart_inc['policy'] = Info::where('policy', '=', '')->get()->count();
    	$chart_inc['documents'] = Info::where('documents', '=', 'incomplete')->get()->count();

    	$chart_complete = [];
    	$chart_complete['dm'] = $total - $chart_inc['dm'];
    	$chart_complete['policy'] = $total - $chart_inc['policy'];
    	$chart_complete['documents'] = Info::where('documents', '=', 'complete')->get()->count();

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

    	$months = [];
    	$months['jan'] = Info::whereMonth('encoded', '=', '01')->get()->count();
    	$months['feb'] = Info::whereMonth('encoded', '=', '02')->get()->count();
    	$months['mar'] = Info::whereMonth('encoded', '=', '03')->get()->count();
    	$months['apr'] = Info::whereMonth('encoded', '=', '04')->get()->count();
    	$months['may'] = Info::whereMonth('encoded', '=', '05')->get()->count();
    	$months['jun'] = Info::whereMonth('encoded', '=', '06')->get()->count();
    	$months['jul'] = Info::whereMonth('encoded', '=', '07')->get()->count();
    	$months['aug'] = Info::whereMonth('encoded', '=', '08')->get()->count();
    	$months['sep'] = Info::whereMonth('encoded', '=', '09')->get()->count();
    	$months['oct'] = Info::whereMonth('encoded', '=', '10')->get()->count();
    	$months['nov'] = Info::whereMonth('encoded', '=', '11')->get()->count();
    	$months['dec'] = Info::whereMonth('encoded', '=', '12')->get()->count();
    	
    	return view('home')
    		->with('chart_inc', $chart_inc)
    		->with('chart_complete', $chart_complete)
    		->with('stages', $stages)
    		->with('stats', $stats)
    		->with('months', $months)
    		->with('info', Info::orderBy('id', 'DESC')->get())
            ->with('message', session('message'));
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

    public function post_update_record() {

        $this->validate($this->request,[
            'name' => 'required',
            'claimant' => 'required',
            'coc' => 'required',
            'inception' => 'required',
        ]);

        $info = Info::find($this->request->input('id'));
        $info->name = $this->request->input('name');
        $info->claimant = $this->request->input('claimant');
        $info->coc = $this->request->input('coc');
        $info->inception = \Carbon\Carbon::parse($this->request->input('inception'));
        $info->dm = $this->request->input('dm');
        $info->policy = $this->request->input('policy');
        $info->documents = $this->request->input('docs');
        $info->documents_comments = $this->request->input('docs_comments');
        $info->amount = $this->request->input('amount');

        if( $info->save() ) {
            return redirect()->route('home')->with('message', 'Record has been updated.');
        }else {
            return 'Something went wrong recording, please contact master Jim from GIBX';
        }
    }

    public function getLogout() {
        \Auth::logout();
        return redirect()->route('home');
    }
}
