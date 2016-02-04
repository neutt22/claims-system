@extends('app')

@section('custom-css')
  <link href="{{ asset('css/pickaday.css') }}" rel="stylesheet">
@stop

@section('content')

<div class="wrapper">

	<a href="/"><img src="{{ asset('img/logo.png') }}" class="logo" ></a>
	<h3>Update Record</h3>
	<hr>

	@if( $errors->has() )
		<ul class="error">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	@endif

	@if( isset($message) )
		<p class="success"> {{ $message }}</p>
	@endif

	@if( isset($info) )

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
	@else
		<p class="error">
			If you got here accidentally, please go back <a href="/">home</a>.
		</p>
	@endif

</div>

@stop

@section('custom-js')
	<script src="{{ asset('js/moment.js')}}"></script>
	<script src="{{ asset('js/pickaday.js')}}"></script>
	<script>
	    var picker = new Pikaday(
	    {
	        field: document.getElementById('datepicker'),
	        format: 'MM/DD/YYYY',
	        firstDay: 1,
	        minDate: new Date(2000, 0, 1),
	        maxDate: new Date(2020, 12, 31),
	        yearRange: [2000,2020]
	    });
    </script>
@stop