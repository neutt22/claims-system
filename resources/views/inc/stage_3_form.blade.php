		<h3 style="text-decoration: underline;"><strong>Stage 3</strong></h3>

		<form id="stage-2" action="/edit" method="post">
			<label style="cursor: pointer;"><input type="checkbox" name="scanned" value="yes">Documents are scanned</label><br>
			<label style="cursor: pointer;"><input type="checkbox" name="trans_mico" value="yes">Transmitted to MICO</label><br/>
			<span><small>*please double check fields before submitting</small></span><br/>
			<input type="hidden" name="id" value="{{ $info->id }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="submit" value="Update" class="button" />
			<a href="/">cancel</a>
		</form>