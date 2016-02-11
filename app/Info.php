<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Info extends Model
{
    protected $fillable = array('name', 'claimant', 'coc');

    protected $dates = ['encoded', 'inception'];

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

        if( $info->save() ) {
            return redirect()->route('home')->with('message', 'Record has been updated.');
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

		if( $info->save() ) {
            return redirect()->route('home')->with('message', 'Stage 2 record has been updated.');
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

    	if( $info->save() ) {
            return redirect()->route('home')->with('message', 'Stage 3 record has been updated.');
        }else {
            return 'Something went wrong recording, please contact master Jim from GIBX';
        }
    }

    public function processStage4(Request $request) {

    	$info = Info::find($request->input('id'));

    	$check_released = is_null($request->input('released')) ? 'no' : 'yes';

    	$info->check_released = $check_released;

    	if( $info->save() ) {
            return redirect()->route('home')->with('message', 'Stage 4 record has been updated.');
        }else {
            return 'Something went wrong recording, please contact master Jim from GIBX';
        }
    }
}
