		<div class="stage-head">
			<h3><strong>Stage 3</strong></h3>
		</div>

		<p class="info tips">
			Log here your follow-ups to Malayan. It is suggested to jot down the person you talked to, the status, and the date and time the follow-up initiated.
		</p>

		<form id="stage-3" action="/edit" method="post">
			<textarea name="followup_comments" placeholder="follow up status here...">{{ $info->followup_comments }}</textarea>
			<label style="cursor: pointer;"><input type="checkbox" name="followed_up" value="yes" {{ $info->followed_up == 'yes' ? 'checked' : ''}}>Followed Up</label><br/>
			<select name="stage_3_status">
				<option value="pending" @if($info->stage_3_status == 'pending') selected @endif>Pending</option>
				<option value="allowed" @if($info->stage_3_status == 'allowed') selected @endif>Allowed</option>
				<option value="denied" @if($info->stage_3_status == 'denied') selected @endif>Denied</option>
				<option value="closed"  @if($info->stage_3_status == 'closed') selected @endif>Closed</option>
			</select><br/>
			{{--<span>{{ $info->stage_3_status }}</span>--}}
			<label style="font-size: 12px; cursor: pointer; margin-top: 10px; display: inline-block;" for="datepicker2">Date:</label><br/>
			<input type="text" name="stage_3_date" placeholder="enter a date..." id="datepicker2" value="{{ \Carbon\Carbon::parse($info->stage_3_date)->format('m/d/Y') }}"><br/>
			{{--<label style="font-size: 12px; cursor: pointer; margin-top: 10px; display: inline-block;" for="datepicker3">MICO Released:</label><br/>--}}
			{{--<input type="text" placeholder="date released..." id="datepicker3" name="mico_released"><br/>--}}
			<span><small>*please double check fields before submitting</small></span><br/>
			<input type="hidden" name="id" value="{{ $info->id }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="stage" value="3">
			<input type="submit" value="Update" class="button" />
			<a href="/">cancel</a>
		</form>