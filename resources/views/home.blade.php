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
        <a id="pa" href="#"><img id="profile-pic" src="{{ $picture }}"></a>
        <small style="font-size: 11px;">{{ \Auth::user()->email }}</small>
        <ul id="dropdown">
          <li><a class="hint--left" data-hint="Another claimant?! No problem." href="/new">New Record</a></li>
          <li><a class="hint--left" data-hint="So your boss are asking for reports?" href="/reports">Reports</a></li>
          <li><a class="hint--left" data-hint="Settings for my lovely app!" href="#">Settings</a></li>
          <li><hr style="margin: 0; border-top: 1px solid #d9d9d9; margin: 0 5px;"></li>
          <li><a class="hint--left" data-hint="I hate to see you go." href="/logout">Log Out</a></li>
        </ul>
      </div>
      <h3>Claims System v.1.1</h3>
    </div>

    @if( count($deadline_names) > 0)
      <div class="deadline-notif-container">
        <div class="counter">
          <span class="title">Deadline Notification</span> <span class="deadline-badge"> {!! sprintf('%02d', count($deadline_names)) !!}</span>
        </div>
        <hr>
        <div>
            @foreach( $deadline_names as $deadline_name)
              @if( $deadline_name->stage == 1)
                <span class="claimant-notif-orange"><a href="/edit?id={{ $deadline_name->id }}">{{ $deadline_name->claimant }} -
                  @if( $deadline_name->contact == null)
                    {!! '<i>No contact</i>' !!}</a>
                  @else
                    {{ $deadline_name->contact }}</a>
                  @endif
                </span>
              @else
                <span class="claimant-notif"><a href="/edit?id={{ $deadline_name->id }}">{{ $deadline_name->claimant }}</a></span>
              @endif
            @endforeach
        </div>
      </div>
    @endif

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
        <form action="/encoded/desc" method="GET">
          <input type="text" name="q" placeholder="claimant...">
          <img src="{{ asset('img/search.png') }}">
        </form>
      </div>
      <div>
        <button id="adv-btn">advanced</button>
        <div class="assm">
          <h2>Advanced Search Options</h2>
          <hr>
          <form action="/encoded/desc" method="GET">
            <div class="adv-element">
              <div class="adv-1st-col">
                <label for="chk-principal"><input id="chk-principal" type="checkbox" name="chk-principal"> Has Principal: </label>
              </div>
              <div class="adv-2nd-col">
                <input type="text" name="txt-principal" placeholder="principal name...">
              </div>
            </div>
            <div class="adv-element">
              <div class="adv-1st-col">
                <label for="chk-claimant"><input id="chk-claimant" type="checkbox" name="chk-claimant"> Has Claimant: </label>
              </div>
              <div class="adv-2nd-col">
                <input type="text" name="txt-claimant" placeholder="claimant name...">
              </div>
            </div>
            <div class="adv-element">
              <div class="adv-1st-col">
                <label for="chk-coc"><input id="chk-coc" type="checkbox" name="chk-coc"> Has COC: </label>
              </div>
              <div class="adv-2nd-col">
                <input type="text" name="txt-coc" placeholder="coc number...">
              </div>
            </div>
            <div class="adv-element">
              <div class="adv-1st-col">
                <label for="chk-dm"><input id="chk-check" type="checkbox" name="chk-dm"> Has DM: </label>
              </div>
              <div class="adv-2nd-col">
                <input type="text" name="txt-dm" placeholder="dm number...">
              </div>
            </div>
            <div class="adv-element">
              <div class="adv-1st-col">
                <label for="chk-policy"><input id="chk-policy" type="checkbox" name="chk-policy"> Has Policy: </label>
              </div>
              <div class="adv-2nd-col">
                <input type="text" name="txt-policy" placeholder="policy number...">
              </div>
            </div>
            <div class="adv-element">
              <div class="adv-1st-col">
                <label for="chk-status"><input id="chk-status" type="checkbox" name="chk-status"> Has Status: </label>
              </div>
              <div class="adv-2nd-col">
                <select name="txt-status" id="status-select">
                  <option value="pending">Pending</option>
                  <option value="approved">Approved</option>
                  <option value="closed">Closed</option>
                  <option value="denied">Denied</option>
                </select>
              </div>
            </div>
            <div class="adv-element">
              <div class="adv-1st-col">
                <label for="chk-tag"><input id="chk-tag" type="checkbox" name="chk-tag"> Has Tag: </label>
              </div>
              <div class="adv-2nd-col">
                <input type="text" name="txt-tag" placeholder="tag name...">
              </div>
            </div>
            <div class="adv-element">
              <div class="adv-1st-col">
                <label for="chk-released"><input id="chk-released" type="checkbox" name="chk-released"> Date Released: </label>
              </div>
              <div class="adv-2nd-col" style="text-align: left; background: none;">
                <span>Month:</span>
                <select name="txt-released-month" id="status-released-month" style="width: 30%;">
                  @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}">{{ $m }}</option>
                  @endfor
                </select>
                <span>Year:</span>
                <select name="txt-released-year" id="status-released-year" style="width: 30%;">
                  @for($m = 2013; $m <= \Carbon\Carbon::today('Asia/Manila')->year; $m++)
                    <option value="{{ $m }}">{{ $m }}</option>
                  @endfor
                </select>
              </div>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="adv" value="advanced">
            <input type="submit" value="Search" class="button">
          </form>
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

    @if( isset($q) )
      <h2 class="q-result">Showing {{ count($info) }} results for '{{ $q }}'</h2>
    @endif

    @if( isset($adv) )
      <h2 class="q-result">Showing {{ count($info) }} results for your advanced query</h2>
    @endif

    <div>
      <button class="qr button hint--right qeb" data-hint="Quick export. Go to Profile > Reports for more options.">quick export <img src="{{ asset('img/download.png') }}" style="width: 10px;"></button>
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
      <th>Deadline {{ $column == 'dead_line' ? $symbol : '' }}</th>
      <th>Status {{ $column == 'status' ? $symbol : '' }}</th>
      <th>Tag {{ $column == 'company' ? $symbol : '' }}</th>
      <th>MICO Released</th>
      <th>Update</th>
      </thead>
      <tbody>
      @if( count($info) > 0 )
        @foreach( $info as $data)
          @if($data->claim_status == 'approved')
            <tr class="tr-claim-approved">
          @elseif($data->deadline_today == 'deadline')
            <tr class="tr-claim-error">
          @else
            <tr>
          @endif
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
                {{ $data->dead_line->format('m/d/Y h:i A') }}
              </td>
              <td>
                <span>
                  {{ $data->claim_status }}
                </span>
              </td>
              <td>
                {{ $data->tag }}
              </td>
              <td>
                {{ $data->stage_3_date->format('m/d/Y') }}
              </td>
              @if( $data->claim_status == 'pending')
                <td class="td-action">
                  <a href="/edit?id={{ $data->id }}" class="upd-button">Update</a>
                </td>
              @else
                <td class="td-action">
                  <a href="/edit?id={{ $data->id }}" class="upd-button">Details</a>
                </td>
              @endif
            </tr>
            @endforeach
          @endif
      </tbody>
    </table>

    <div class="total-row">
      <span>Total: {{ count($info) }}</span>
    </div>

    <div>
      <button class="qr button hint--right qeb" data-hint="Quick export. Go to Profile > Reports for more options.">quick export <img src="{{ asset('img/download.png') }}" style="width: 10px;"></button>
    </div>

  </div>
@stop

@section('footer')
  @include('inc.footer')
@endsection

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

      $('#sort:checkbox').change(function(){
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

      $('.qr').click(function(){
        window.location.href = '/qr';
      });

    });
  </script>
@stop
