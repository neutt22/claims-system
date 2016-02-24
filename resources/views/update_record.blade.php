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

		@include('inc.stage_1_form')

		<hr>

		@include('inc.stage_2_form')

		<hr>

		@include('inc.stage_3_form')

		<hr>

		@include('inc.stage_4_form')

		<hr>
	@else
		<p class="error">
			If you got here accidentally, please go back <a href="/">home</a>.
		</p>
	@endif

</div>

@stop

@section('footer')
	@include('inc.footer')
@endsection

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