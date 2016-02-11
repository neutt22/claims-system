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
    <h3>Claims System v.0.2</h3>
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

  @if( isset($message) )
    <p class="success">
      {{ $message }}
    </p>
  @endif

  <div class="qebcH">
    <button class="button hint--right" data-hint="Quick export. Go to Profile > Reports for more options." id="qebH">quick export <img src="{{ asset('img/download.png') }}" style="width: 10px;"></button>
  </div>

  <table style="width:100%">
    <tr>
      <th>Principal</th>
      <th>Claimant</th>
      <th>COC</th>
      <th>Documents</th>
      <th>Inception</th>
      <th>Encoded</th>
      <th>Amount</th>
      <th>Stage</th>
      <th>Status</th>
    </tr>
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
          <td class="td-action"><a href="/edit?id={{ $data->id }}" class="button">Update</a></td>
        </tr>
      @endforeach
    @endif
  </table>

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

  });
</script>
@stop
