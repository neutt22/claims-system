<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Info extends Model
{
    protected $fillable = array('name', 'claimant', 'coc');

    protected $dates = ['encoded', 'inception', 'dead_line', 'f_deadline', 'l_deadline'];

    public function getColumn($column)
    {
        if( \Schema::hasColumn('infos', $column)){
            return $column;
        }
        return 'encoded';
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

    public function claimsAmount(Collection $infos) {
        $claims_amount = [];
        $total = 0;
        $pending = 0;
        $approved = 0;

        // Calculate total claims
        foreach($infos as $info ) {
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

        return $claims_amount;
    }

    public function processStage1(Info $i, Request $request) {

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

        // Move to stage 2
        // Add deadline of 3 days for stage 2
        // Mark the fist deadline to now/today to recognize 15 working days
        if($request->input('docs') == 'complete' && $info->stage == 1){
            $info->stage = 2;
            $info->dead_line = $i->getDeadLine(3);
            $info->f_deadline = \Carbon\Carbon::now('Asia/Manila');
            $message = "Record has been updated. Congrats! The claimant is on <strong>stage 2</strong>.";
        }

        if( $info->save() ) {
            return redirect()->to('/encoded/desc')->with('message', $message);
        }else {
            return 'Something went wrong recording, please contact master Jim from GIBX';
        }
    }

    public function processStage2(Info $i, Request $request) {

    	$info = Info::find($request->input('id'));

		$scanned = is_null($request->input('scanned')) ? 'no' : 'yes';    	
		$transmitted = is_null($request->input('trans_mico')) ? 'no' : 'yes';

		$info->scanned = $scanned;
		$info->transmitted = $transmitted;

        $message = 'Record has been updated.';

        // Move to stage 3
        // Add deadline of 9 days for stage 3
        if($scanned == 'yes' && $transmitted == 'yes' && $info->stage == 2) {
            $info->stage = 3;
            $info->dead_line = $i->getDeadLine(9);
            $message = "Record has been updated. Congrats! The claimant is on <strong>stage 3</strong>.";
        }

		if( $info->save() ) {
            return redirect()->to('/encoded/desc')->with('message', $message);
        }else {
            return 'Something went wrong recording, please contact master Jim from GIBX';
        }
    }

    public function processStage3(Info $i, Request $request) {

    	$info = Info::find($request->input('id'));

    	$followup_comments = $request->input('followup_comments');
    	$followed_up = is_null($request->input('followed_up')) ? 'no' : 'yes';

    	$info->followup_comments = $followup_comments;
    	$info->followed_up = $followed_up;

        $message = 'Record has been updated.';

        // Move to stage 4
        // Add deadline of 3 days for stage 4
        if($followed_up == 'yes' && $info->stage == 3) {
            $info->stage = 4;
            $info->dead_line = $i->getDeadLine(3);
            $message = "Record has been updated. Congrats! The claimant is on <strong>stage 4</strong>.";
        }

    	if( $info->save() ) {
            return redirect()->to('/encoded/desc')->with('message', $message);
        }else {
            return 'Something went wrong recording, please contact master Jim from GIBX';
        }
    }

    public function processStage4(Info $i, Request $request) {

    	$info = Info::find($request->input('id'));

    	$check_released = is_null($request->input('released')) ? 'no' : 'yes';

    	$info->check_released = $check_released;

        $message = 'Record has been updated.';

        // Move to stage 0
        // Mark the last deadline to now/today to recognize 15 working days
        // Calculate difference from first to last deadline dates
        if($check_released == 'yes' && $info->stage == 4) {
            $info->stage = 0;
            $info->claim_status = 'approved';
            $info->l_deadline = \Carbon\Carbon::now('Asia/Manila');
            $info->days_accomplished = $i->getDeadLineDifference($i, $info->f_deadline, $info->l_deadline);
            $message = "Record has been updated. Congrats! The claimant has finished the new GIBX claim process.";
        }

        if( $info->save() ) {
            return redirect()->to('/encoded/desc')->with('message', $message);
        }else {
            return 'Something went wrong recording, please contact master Jim from GIBX';
        }
    }

    public function getDeadLine($deadline)
    {
        // Stage has been triggered. Get date/time now.
        $today = Carbon::now('Asia/Manila');

        $c = 0;

        while(true){

            // Add one(1) day starting now.
            $today = $today->addDay(1);

            // Check if the day is either Sat or Sun, if yes, adjust the day by one(1).
            if($today->dayOfWeek == Carbon::SATURDAY || $today->dayOfWeek == Carbon::SUNDAY) {
                $c -= 1;
            }

            $c += 1;

            if($c == $deadline) break;
        }

        return $today;
    }

    public function getDeadLineDifference(Info $info, Carbon $f_deadline, Carbon $l_deadline)
    {
        // Get first and last deadlines difference in days
        $days = $f_deadline->diffInDays($l_deadline);
        $c = 0;

        for($m = 0; $m < $days; $m++){
            $current = $f_deadline->addDay(1);

            // If the day after first deadline is not Saturday or Sunday, count as 1 working day
            if($current->dayOfWeek != Carbon::SATURDAY && $current->dayOfWeek != Carbon::SUNDAY){
                $c += 1;
            }
        }

        return $c;
    }

    public function isDeadLineToday(Carbon $deadline)
    {
        $today = Carbon::now('Asia/Manila');
        if($deadline->diffInDays($today) == 0){
            return true;
        }else{
            return false;
        }
    }
}
