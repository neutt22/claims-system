<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Info extends Model
{
    protected $fillable = array('name', 'claimant', 'coc');

    protected $dates = ['encoded', 'inception'];

    public function getColumn($column)
    {
        if( \Schema::hasColumn('infos', $column)){
            return $column;
        }
        return 'column';
    }

    public function getType($type)
    {
        if($type == 'asc') return 'asc';
        if($type == 'desc') return 'desc';

        return 'desc';
    }

    public function getSymbol($type)
    {
        if($type == 'asc') return '&#x25B2;';
        if($type == 'desc') return '&#x25BC;';

        return '&#x25BC;';
    }

    public function claimsAmount() {
        $claims_amount = [];
        $total = 0;
        $pending = 0;
        $approved = 0;

        // Fetch amounts
        $totalO = Info::all(['amount']);
        $pending0 = Info::where('claim_status', '=', 'pending')->get(['amount']);
        $approved0 = Info::where('claim_status', '=', 'approved')->get(['amount']);

        // Calculate total claims
        foreach($totalO as $t ) {
            $total += $t->amount;
        }

        // Calculate total pending claims
        foreach($pending0 as $p) {
            $pending += $p->amount;
        }

        // Calculate total approved claims
        foreach($approved0 as $a) {
            $approved += $a->amount;
        }

        $claims_amount['pending'] = $pending;
        $claims_amount['total'] = $total;
        $claims_amount['approved'] = $approved;

        return $claims_amount;
    }

    public function processStage1(Request $request) {

        $info = Info::find($request->input('id'));
        $info->name = $request->input('name');
        $info->claimant = $request->input('claimant');
        $info->coc = $request->input('coc');
        $info->inception = \Carbon\Carbon::parse($request->input('inception'));
        $info->dm = $request->input('dm');
        $info->policy = $request->input('policy');
        $info->documents = $request->input('docs');
        $info->documents_comments = $request->input('docs_comments');
        $info->amount = $request->input('amount');

        $message = 'Record has been updated.';

        if($request->input('docs') == 'complete' && $info->stage == 1){
            $info->stage = 2;
            $message = "Record has been updated. Congrats! The claimant is on <strong>stage 2</strong>.";
        }

        if( $info->save() ) {
            return redirect()->to('/encoded/desc')->with('message', $message);
        }else {
            return 'Something went wrong recording, please contact master Jim from GIBX';
        }
    }

    public function processStage2(Request $request) {

    	$info = Info::find($request->input('id'));

		$scanned = is_null($request->input('scanned')) ? 'no' : 'yes';    	
		$transmitted = is_null($request->input('trans_mico')) ? 'no' : 'yes';

		$info->scanned = $scanned;
		$info->transmitted = $transmitted;

        $message = 'Record has been updated.';

        if($scanned == 'yes' && $transmitted == 'yes' && $info->stage == 2) {
            $info->stage = 3;
            $message = "Record has been updated. Congrats! The claimant is on <strong>stage 3</strong>.";
        }

		if( $info->save() ) {
            return redirect()->to('/encoded/desc')->with('message', $message);
        }else {
            return 'Something went wrong recording, please contact master Jim from GIBX';
        }
    }

    public function processStage3(Request $request) {

    	$info = Info::find($request->input('id'));

    	$followup_comments = $request->input('followup_comments');
    	$followed_up = is_null($request->input('followed_up')) ? 'no' : 'yes';

    	$info->followup_comments = $followup_comments;
    	$info->followed_up = $followed_up;

        $message = 'Record has been updated.';

        if($followed_up == 'yes' && $info->stage == 3) {
            $info->stage = 4;
            $message = "Record has been updated. Congrats! The claimant is on <strong>stage 4</strong>.";
        }

    	if( $info->save() ) {
            return redirect()->to('/encoded/desc')->with('message', $message);
        }else {
            return 'Something went wrong recording, please contact master Jim from GIBX';
        }
    }

    public function processStage4(Request $request) {

    	$info = Info::find($request->input('id'));

    	$check_released = is_null($request->input('released')) ? 'no' : 'yes';

    	$info->check_released = $check_released;

        $message = 'Record has been updated.';

        if($check_released == 'yes' && $info->stage == 4) {
            $info->stage = 0;
            $info->claim_status = 'approved';
            $message = "Record has been updated. Congrats! The claimant has finished the new GIBX claim process.";
        }

        if( $info->save() ) {
            return redirect()->to('/encoded/desc')->with('message', $message);
        }else {
            return 'Something went wrong recording, please contact master Jim from GIBX';
        }
    }
}
