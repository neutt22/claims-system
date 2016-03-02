		<div class="stage-head">
			<h3><strong>Stage 1</strong></h3>
		</div>

		<p class="info tips">
			Entry point for the claimant's documents journey! Make sure to fillin the details that are mandatory.
		</p>

		
		<form id="stage-1" action="/edit" method="post">
			<input type="text" name="name" placeholder="enter principal name..." value="{{ $info->name }}" />
			<input type="text" name="claimant" placeholder="enter claimant name..." value="{{ $info->claimant }}" />
			<select name="dependent">
				<option value="principal" {{ ($info->dependent == 'principal') ? 'selected' : '' }}>Principal</option>
				<option value="secondary" {{ ($info->dependent == 'secondary') ? 'selected' : '' }}>Secondary</option>
				<option value="tertiary" {{ ($info->dependent == 'tertiary') ? 'selected' : '' }}>Tertiary</option>
			</select>
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

			<span>Encoded: <small>{{ \Carbon\Carbon::parse($info->encoded)->format('m/d/Y h:i A') }} </small></span>

			<input type="text" name="nature_of_claim" placeholder="nature of claim" value="{{ $info->nature_of_claim }}"/>
			<input type="text" name="type_of_sickness" placeholder="type of sickness" value="{{ $info->type_of_sickness }}"/>
			<input type="text" name="hospital" placeholder="hospital" value="{{ $info->hospital }}"/>
			<input type="text" name="contact" placeholder="contact no." value="{{ $info->contact }}"/>
			<input type="text" name="area" placeholder="area" value="{{ $info->area }}"/>
			<input type="text" name="tag" placeholder="enter tag or company name" value="{{ $info->tag }}"/>
			<input type="text" name="amount" placeholder="enter claim amount"  value="{{ $info->amount }}"/>
			<span><small>*please double check fields before submitting</small></span><br/>
			<input type="hidden" name="id" value="{{ $info->id }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="stage" value="1">
			{{--<input type="submit" value="Update" class="button" />--}}
			<input type="submit" value="Update" class="button" />
			<a href="/">cancel</a>
		</form>