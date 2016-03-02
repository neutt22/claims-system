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

	<div class="update-container">
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

	<div class="update-container rb">
		<div class="stage-head">
			<h3><strong>Details</strong></h3>
		</div>
		<div class="info">
			<h2>Principal</h2>
			<span>{{ $info->name }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>Claimant</h2>
			<span>{{ $info->claimant }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>Dependent</h2>
			<span>{{ $info->dependent }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>COC</h2>
			<span>{{ $info->coc }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>DM</h2>
			<span>{{ $info->dm }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>POLICY</h2>
			<span>{{ $info->policy }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>DOCUMENTS</h2>
			<span>{{ $info->documents }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>COMMENTS</h2>
			<span>{{ $info->documents_comments }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>ENCODED</h2>
			<span>{{ $info->encoded->format('m/d/Y') }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>AMOUNT</h2>
			<span>{{ number_format($info->amount, 2, '.', ',') }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>INCEPTION</h2>
			<span>{{ $info->inception->format('m/d/Y') }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>Stage</h2>
			<span>{{ $info->stage }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>Claim Status</h2>
			<span>{{ $info->claim_status }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>Deadline</h2>
			<span>{{ $info->dead_line->format('m/d/Y') }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>1st Deadline</h2>
			<span>{{ $info->f_deadline->format('m/d/Y') }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>Last Deadline</h2>
			<span>{{ $info->l_deadline->format('m/d/Y') }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>Days Accomplished</h2>
			<span>{{ $info->days_accomplished }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>Nature Of Claim</h2>
			<span>{{ $info->nature_of_claim }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>Type Of Sickness</h2>
			<span>{{ $info->type_of_sickness }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>Hospital</h2>
			<span>{{ $info->hospital }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>Contact</h2>
			<span>{{ $info->contact }}</span>
			<hr>
		</div>
		<div class="info">
			<h2>Area</h2>
			<span>{{ $info->area }}</span>
			<hr>
		</div>

	</div>

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
		var picker2 = new Pikaday(
				{
					field: document.getElementById('datepicker2'),
					format: 'MM/DD/YYYY',
					firstDay: 1,
					minDate: new Date(2000, 0, 1),
					maxDate: new Date(2020, 12, 31),
					yearRange: [2000,2020]
		});
		var picker3 = new Pikaday(
				{
					field: document.getElementById('datepicker3'),
					format: 'MM/DD/YYYY',
					firstDay: 1,
					minDate: new Date(2000, 0, 1),
					maxDate: new Date(2020, 12, 31),
					yearRange: [2000,2020]
		});
    </script>
@stop