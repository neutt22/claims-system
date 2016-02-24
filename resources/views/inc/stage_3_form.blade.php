		<div class="stage-head">
			<h3><strong>Stage 3</strong></h3>
		</div>

		<p class="info tips">
			Log here your follow-ups to Malayan. It is suggested to jot down the person you talked to, the status, and the date and time the follow-up initiated.
		</p>

		<form id="stage-3" action="/edit" method="post">
			<textarea name="followup_comments" placeholder="follow up status here...">{{ $info->followup_comments }}</textarea>
			<label style="cursor: pointer;"><input type="checkbox" name="followed_up" value="yes" {{ $info->followed_up == 'yes' ? 'checked' : ''}}>Followed Up</label><br/>
			<span><small>*please double check fields before submitting</small></span><br/>
			<input type="hidden" name="id" value="{{ $info->id }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="stage" value="3">
			<input type="submit" value="Update" class="button" />
			<a href="/">cancel</a>
		</form>