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
      <a id="pa" href="#"><img id="profile-pic" src="<?php echo e(asset('img/profile_pic.jpg')); ?>"></a>
      <small style="font-size: 11px;">{{ \Auth::user()->email }}</small>
      <ul id="dropdown">
        <li><a href="/new">New Record</a></li>
        <li><a href="#">Reports</a></li>
        <li><a href="#">Settings</a></li>
        <li><hr style="margin: 0; border-top: 1px solid #d9d9d9; margin: 0 5px;"></li>
        <li><a href="/logout">Log Out</a></li>
      </ul>
    </div>
    <h3>Claims System v.0.1</h3>
  </div>

  <div style="text-align: center;">
    <div id="chart_dm" style="display: inline-block;"></div>
    <div id="chart_policy" style="display: inline-block;"></div>
    <div id="chart_stage" style="display: inline-block;"></div>
    <div id="chart_documents" style="display: inline-block;"></div>
    <div id="chart_status" style="display: inline-block;"></div>
    <div id="chart_encoded" style="display: inline-block;"></div>
  </div>

  <div class="search-wrapper">
    <label>Search: </label>
    <div class="search-box">
      <input type="text" name="q" placeholder="claimant...">
      <img src="{{ asset('img/search.png') }}">
    </div>
  </div>

  <?php if( isset($message) ): ?>
    <p class="success">
      <?php echo $message; ?>

    </p>
  <?php endif; ?>

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
    <?php if( count($info) > 0 ): ?>
      <?php foreach( $info as $data ): ?>
        <tr>
          <td>
            <?php echo e($data->name); ?>
          </td>
          <td>
            <?php echo e($data->claimant); ?>
          </td>
          <td>
            <?php echo e($data->coc); ?>
          </td>
          <td>
            <?php echo e($data->documents); ?>
          </td>
          <td>
            <?php echo e(\Carbon\Carbon::parse($data->inception)->format('m/d/Y')); ?>
          </td>
          <td>
            <?php echo e(\Carbon\Carbon::parse($data->encoded)->format('m/d/Y')); ?>
          </td>
          <td>
            <?php echo e($data->amount); ?>
          </td>
          <td>
            <?php echo e($data->stage); ?>
          </td>
          <td>
            <span>
              <?php echo e($data->claim_status); ?>
            </span>
          </td>
          <td class="td-action"><a href="/edit?id=<?php echo e($data->id); ?>" class="button">Update</a></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
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

  });
</script>
@stop
