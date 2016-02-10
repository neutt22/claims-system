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

    }

    public function processStage3(Request $request) {

    }

    public function processStage4(Request $request) {

    }
}
