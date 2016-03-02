		<div class="stage-head">
			<h3><strong>Stage 4</strong></h3>
		</div>

		<p class="info tips">
			<img src="{{ asset('img/Elegant-bank-cheque/13252-NP012T.jpg') }}">
			<strong>Seriously? You got down here?!</strong>
			Ayee, congrats! Now all you have to do is send the precios check to the claimant!
			Note that the timer is still ticking so we gotta see some hastle out of ya.
		</p>

		<form id="stage-3" action="/edit" method="post">
			<label style="cursor: pointer;"><input type="checkbox" name="released" value="yes" {{ $info->check_released == 'yes' ? 'checked' : ''}}>Check Released</label><br>
			<input type="text" name="track_no" value="{{ $info->track_no }}" placeholder="track no."><br>
			<span><small>*please double check fields before submitting</small></span><br/>
			<input type="hidden" name="id" value="{{ $info->id }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="stage" value="4">
			<input type="submit" value="Update" class="button" />
			<a href="/">cancel</a>
		</form>