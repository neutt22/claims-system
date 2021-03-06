<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Info extends Model
{
    protected $fillable = array('name', 'claimant', 'coc');

    protected $dates = ['encoded', 'inception', 'dead_line', 'f_deadline', 'l_deadline', 'stage_3_date', 'mico_released'];

    public function getAdvancedSearchModel(Request $request)
    {
        $query = Info::class;

        $query = $query::orderBy('encoded', 'desc');

        if($request->input('chk-principal')){
            $query = $query->where('name', 'like', '%' . $request->input('txt-principal') . '%');
        }

        if($request->input('chk-claimant')){
            $query = $query->where('claimant', 'like', '%' . $request->input('txt-claimant') . '%');
        }

        if($request->input('chk-coc')){
            $query->where('coc', 'like', '%' . $request->input('txt-coc') . '%');
        }

        if($request->input('chk-dm')){
            $query->where('dm', 'like', '%' . $request->input('txt-dm') . '%');
        }

        if($request->input('chk-policy')){
            $query->where('policy', 'like', '%' . $request->input('txt-policy') . '%');
        }

        if($request->input('chk-status')){
            $query->where('claim_status', 'like', '%' . $request->input('txt-status') . '%');
        }

        if($request->input('chk-tag')){
            $query->where('tag', 'like', '%' . $request->input('txt-tag') . '%');
        }

        if($request->input('chk-released')){
            $query->whereMonth('stage_3_date', '=', $request->input('txt-released-month'));
            $query->whereYear('stage_3_date', '=', $request->input('txt-released-year'));
        }

//        dd($query->get());

        return $query->get();
    }

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
        $info->dependent = $request->input('dependent');
        $info->inception = \Carbon\Carbon::parse($request->input('inception'));
        $info->dm = $request->input('dm');
        $info->policy = $request->input('policy');
        $info->documents = $request->input('docs');
        $info->documents_comments = $request->input('docs_comments');
        $info->nature_of_claim = $request->input('nature_of_claim');
        $info->type_of_sickness = $request->input('type_of_sickness');
        $info->hospital = $request->input('hospital');
        $info->contact = $request->input('contact');
        $info->area = $request->input('area');
        $info->tag = $request->input('tag');
        $info->insurer = $request->input('insurer');
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
        $info->stage_3_status = $request->input('stage_3_status');
        $info->claim_status = $request->input('stage_3_status');
        $info->stage_3_date = \Carbon\Carbon::parse($request->input('stage_3_date'));
        $info->mico_released = \Carbon\Carbon::parse($request->input('mico_released'));

        $message = 'Record has been updated.';

        // Move to stage 4
        // Add deadline of 3 days for stage 4
        if($info->stage_3_status == 'allowed' && $info->stage == 3) {
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
        $info->track_no = $request->input('track_no');

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
//        return $deadline->diffInDays($today); // Determines whether its on deadline or warning (1 day prior)

        // If today is greater than or equal to its deadline, then its his/her deadline
        if($today->gte($deadline)){
            return 'deadline';
        }

        // Issue a warning if today's days difference is 0 with the deadline
        // TODO: Implement the warning feature later
//        if($today->diffInDays($deadline) == 0){
//            return 'warning';
//        }

        return 'pending';
    }
}
