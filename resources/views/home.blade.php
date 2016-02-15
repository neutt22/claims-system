@extends('app')

@section('custom-css')
  @include('inc.google-chart')
@endsection

@section('content')

<div style="width:1340px; margin: 0 auto;">

  <div class="dashboard">
    <a href="/"><img class="logo" src="/img/logo.png" style="position: absolute; left: 5px; top: -15px;"></a>
    <div id="profile">
      <small style="font-size: 11px;">{{ \Auth::user()->level }}</small>
      <a id="pa" href="#"><img id="profile-pic" src="{{ asset('img/profile_pic.jpg') }}"></a>
      <small style="font-size: 11px;">{{ \Auth::user()->email }}</small>
      <ul id="dropdown">
        <li><a class="hint--left" data-hint="Another claimant?! No problem." href="/new">New Record</a></li>
        <li><a class="hint--left" data-hint="So your boss are asking for reports?" href="#">Reports</a></li>
        <li><a class="hint--left" data-hint="Settings for my lovely app!" href="#">Settings</a></li>
        <li><hr style="margin: 0; border-top: 1px solid #d9d9d9; margin: 0 5px;"></li>
        <li><a class="hint--left" data-hint="I hate to see you go." href="/logout">Log Out</a></li>
      </ul>
    </div>
    <h3>Claims System v.0.4</h3>
  </div>

  <div style="text-align: center;">
    <div id="chart_dm" style="display: inline-block;"></div>
    <div id="chart_policy" style="display: inline-block;"></div>
    <div id="chart_stage" style="display: inline-block;"></div>
    <div id="chart_documents" style="display: inline-block;"></div>
    <div id="chart_status" style="display: inline-block;"></div>
    <div id="chart_encoded" style="display: inline-block;"></div>
  </div>

  <div class="search-wrapper hint--top-right" data-hint="Search here. Click the advanced settings for more search options.">
    <label>Search: </label>
    <div class="search-box">
      <input type="text" name="q" placeholder="claimant...">
      <img src="{{ asset('img/search.png') }}">
    </div>
    <div>
      <button id="adv-btn">advanced</button>
      <div class="assm">
        <h3><strong>Advanced Search Options</strong></h3>
      </div>
    </div>
  </div>

  <div class="claims-stat">
    <div class="total-claims-pending">
      <h4>Pending Claims</h4>
      <span>Php</span><span class="count-pending"></span>
    </div>
    <div class="total-claims">
      <h4>Total Claims</h4>
      <span>Php</span><span class="count-total"></span>
    </div>
    <div class="total-claims-approved">
      <h4>Claims Approved</h4>
      <span>Php</span><span class="count-approved"></span>
    </div>
  </div>

  @if( isset($message) )
    <p class="success">
      {!! $message !!}
    </p>
  @endif

  <div class="qebcH">
    <button class="button hint--right" data-hint="Quick export. Go to Profile > Reports for more options." id="qebH">quick export <img src="{{ asset('img/download.png') }}" style="width: 10px;"></button>
    @include('inc.sort_by')
  </div>

  <table style="width:100%">
    <thead>
      <th>Principal {{ $column == 'name' ? $symbol : '' }}</th>
      <th>Claimant {{ $column == 'claimant' ? $symbol : '' }}</th>
      <th>COC {{ $column == 'coc' ? $symbol : '' }}</th>
      <th>Documents {{ $column == 'documents' ? $symbol : '' }}</th>
      <th>Inception {{ $column == 'inception' ? $symbol : '' }}</th>
      <th>Encoded {{ $column == 'encoded' ? $symbol : '' }}</th>
      <th>Amount {{ $column == 'amount' ? $symbol : '' }}</th>
      <th>Stage {{ $column == 'stage' ? $symbol : '' }}</th>
      <th>Status {{ $column == 'status' ? $symbol : '' }}</th>
      <th>Update</th>
    </thead>
    <tbody>
    @if( count($info) > 0 )
      @foreach( $info as $data)
        <tr>
          <td>
            {{ $data->name }}
          </td>
          <td>
            {{ $data->claimant }}
          </td>
          <td>
            {{ $data->coc }}
          </td>
          <td>
            {{ $data->documents }}
          </td>
          <td>
            {{ \Carbon\Carbon::parse($data->inception)->format('m/d/Y') }}
          </td>
          <td>
            {{ \Carbon\Carbon::parse($data->encoded)->format('m/d/Y') }}
          </td>
          <td>
            {{ $data->amount }}
          </td>
          <td>
            {{ $data->stage }}
          </td>
          <td>
            <span>
              {{ $data->claim_status }}
            </span>
          </td>
          <td class="td-action"><a href="/edit?id={{ $data->id }}" class="upd-button">Update</a></td>
        </tr>
      @endforeach
    @endif
    </tbody>
  </table>

  <div class="qebcH">
    <button class="button hint--right" data-hint="Quick export. Go to Profile > Reports for more options." id="qebH">quick export <img src="{{ asset('img/download.png') }}" style="width: 10px;"></button>
  </div>

</div>
@stop

@section('custom-js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

    $('#pa').click(function(){
      $('#dropdown').toggle();
    });

    $('#adv-btn').click(function(){
      $('.assm').toggle();
    });

    $('input:checkbox').change(function(){
      if( $(this).is(':checked')){
        $(window).attr('location', '/{{ $column }}/asc');
      }else{
        $(window).attr('location', '/{{ $column }}/desc');
      }
    });

    $({countNum: $('.count-pending').text()}).animate({
      countNum: {{ $claims_amount['pending'] }}
    }, {
      duration: 4000,
      easing:'swing',
      step: function() {
        $('.count-pending').text(Math.floor(this.countNum));
      },
      complete: function() {
        $('.count-pending').text( '{{ number_format($claims_amount['pending'], 2) }}');
      }
    });

    $({countNum: $('.count-total').text()}).animate({
      countNum: {{ $claims_amount['total'] }}
    }, {
      duration: 4000,
      easing:'swing',
      step: function() {
        $('.count-total').text(Math.floor(this.countNum));
      },
      complete: function() {
        $('.count-total').text( '{{ number_format($claims_amount['total'], 2) }}');
      }
    });

    $({countNum: $('.count-approved').text()}).animate({
      countNum: {{ $claims_amount['approved'] }}
    }, {
      duration: 4000,
      easing:'swing',
      step: function() {
        $('.count-approved').text(Math.floor(this.countNum));
      },
      complete: function() {
        $('.count-approved').text( '{{ number_format($claims_amount['approved'], 2) }}');
      }
    });



  });
</script>
@stop
