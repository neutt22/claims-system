@extends('app')

@section('custom-css')
  <link href="{{ asset('css/pickaday.css') }}" rel="stylesheet">
@stop

@section('content')

<div class="wrapper">

	<a href="/"><img src="{{ asset('img/logo.png') }}" class="logo" ></a>
	<h3>New Record - <strong><i>Stage 1</i></strong></h3>
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

	<form id="stage-1" action="/new" method="post">
		<input type="text" name="name" placeholder="enter principal name..." class="req" />
		<input type="text" name="claimant" placeholder="enter claimant name..." class="req" />
		<input type="text" name="coc" placeholder="enter coc name..." class="req" />
		<input type="text" name="inception" placeholder="enter inception date..." id="datepicker" class="req">
		<input type="text" name="dm" placeholder="enter dm name..." />
		<input type="text" name="policy" placeholder="enter policy name..." />

		<label>Documents Status: </label>
		<select name="docs">
			<option value="incomplete">Incomplete</option>
			<option value="complete">Complete</option>
		</select>

		<textarea name="docs_comments" placeholder="your documents' comments"></textarea>

		<span>Encoded: <small>{{ \Carbon\Carbon::now('Asia/Manila')->format('m/d/Y h:i A') }} </small></span>
		<input type="text" name="tag" placeholder="enter tag or company name" />
		<input type="text" name="amount" placeholder="enter claim amount" />
		<span><small>*please double check fields before submitting</small></span><br/>
		<input type="hidden" name="encoded" value="{{ \Carbon\Carbon::now()->toDayDateTimeString() }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="submit" value="Save" class="button" />
		<a href="/">cancel</a>
		
	</form>

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