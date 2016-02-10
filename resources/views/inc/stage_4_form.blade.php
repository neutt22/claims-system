		<h3 style="text-decoration: underline;"><strong>Stage 4</strong></h3>

		<form id="stage-3" action="/edit" method="post">
			<textarea name="followup_comments" placeholder="follow up status here..."></textarea>
			<span><small>*please double check fields before submitting</small></span><br/>
			<input type="hidden" name="id" value="{{ $info->id }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="submit" value="Update" class="button" />
			<a href="/">cancel</a>
		</form>