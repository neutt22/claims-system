		<div class="stage-head">
			<h3><strong>Stage 2</strong></h3>
		</div>

		<p class="info tips">
			Stage 2 is where you have to scan all the necessary documents. Eventually, will be sent to Malayan for further processing.
		</p>

		<form id="stage-2" action="/edit" method="post">
			<label style="cursor: pointer;"><input type="checkbox" name="scanned" value="yes" {{ $info->scanned == 'yes' ? 'checked' : ''}}>Documents are scanned</label><br>
			<label style="cursor: pointer;"><input type="checkbox" name="trans_mico" value="yes" {{ $info->transmitted == 'yes' ? 'checked' : ''}}>Transmitted to MICO</label><br/>
			<span><small>*please double check fields before submitting</small></span><br/>
			<input type="hidden" name="id" value="{{ $info->id }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="stage" value="2">
			<input type="submit" value="Update" class="button"{{ $info->stage != 2 ? 'disabled' : '' }}/>
			<a href="/">cancel</a>
		</form>