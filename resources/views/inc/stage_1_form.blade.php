		<div class="stage-head">
			<h3><strong>Stage 1</strong></h3>
		</div>
		
		<form id="stage-1" action="/edit" method="post">
			<input type="text" name="name" placeholder="enter principal name..." value="{{ $info->name }}" />
			<input type="text" name="claimant" placeholder="enter claimant name..." value="{{ $info->claimant }}" />
			<input type="text" name="coc" placeholder="enter coc name..." value="{{ $info->coc }}" />

			<input type="text" name="inception" placeholder="enter inception date..." id="datepicker" value="{{ \Carbon\Carbon::parse($info->inception)->format('m/d/Y') }}">
			<input type="text" name="dm" placeholder="enter dm name..." value="{{ $info->dm }}" />
			<input type="text" name="policy" placeholder="enter policy name..." value="{{ $info->policy }}" />

			<label>Documents Status: </label>
			<select name="docs">
				<option value="incomplete" {{ ($info->documents == 'incomplete') ? 'selected' : '' }}>Incomplete</option>
				<option value="complete" {{ ($info->documents == 'complete') ? 'selected' : '' }}>Complete</option>
			</select>

			<textarea name="docs_comments" placeholder="your documents' comments">{{ $info->documents_comments }}</textarea>

			<span>Encoded: <small>{{ \Carbon\Carbon::parse($info->encoded)->format('m/d/Y') }} </small></span>
			
			<input type="text" name="amount" placeholder="enter claim amount"  value="{{ $info->amount }}"/>
			<span><small>*please double check fields before submitting</small></span><br/>
			<input type="hidden" name="id" value="{{ $info->id }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="submit" value="Update" class="button" />
			<a href="/">cancel</a>
		</form>