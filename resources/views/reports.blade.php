@extends('app')

@section('content')

    <div class="report-container">

        <a href="/"><img src="{{ asset('img/logo.png') }}" class="logo" ></a>

        <div class="report-head">
            <h3><strong>GIBX Claims System Reports</strong></h3>
        </div>

        <div class="report-item">
            <h2>Total Claims Filed: </h2>
            <span>{{ $total_claims }}</span>
            <hr>
        </div>
        <div class="report-item">
            <h2>Total COC: </h2>
            <span>{{ $total_coc }}/{{ $total_claims }}</span>
            <hr>
        </div>
        <div class="report-item">
            <h2>Total DM: </h2>
            <span>{{ $total_dm }}/{{ $total_claims }}</span>
            <hr>
        </div>
        <div class="report-item">
            <h2>Total Policy: </h2>
            <span>{{ $total_dm }}/{{ $total_claims }}</span>
            <hr>
        </div>
        <div class="report-item">
            <h2>Incomplete Documents: </h2>
            <span>{{ $incomplete_docs }}/{{ $total_claims }}</span>
            <hr>
        </div>
        <div class="report-item">
            <h2>Pending Claims Amount: </h2>
            <span>{{ number_format($claims_amount['pending'], 2, '.', ',') }}</span>
            <hr>
        </div>
        <div class="report-item">
            <h2>Approved Claims Amount: </h2>
            <span class="good">{{ number_format($claims_amount['approved'], 2, '.', ',') }}</span>
            <hr>
        </div>
        <div class="report-item">
            <h2>Total Claims Amount: </h2>
            <span>{{ number_format($claims_amount['total'], 2, '.', ',') }}</span>
            <hr>
        </div>
        <div class="report-item">
            <h2>Total Pending Status: </h2>
            <span>{{ $stats['pending'] }}</span>
            <hr>
        </div>
        <div class="report-item">
            <h2>Total Denied Status: </h2>
            <span>{{ $stats['denied'] }}</span>
            <hr>
        </div>
        <div class="report-item">
            <h2>Total Closed Status: </h2>
            <span>{{ $stats['closed'] }}</span>
            <hr>
        </div>
        <div class="report-item">
            <h2>Total Approved Status: </h2>
            <span class="good">{{ $stats['approved'] }}</span>
            <hr>
        </div>
        <div class="report-item">
            <h2>Total Check Released: </h2>
            <span>{{ $total_check_released }}</span>
            <hr>
        </div>

    </div>

@endsection

@section('footer')
    @include('inc.footer')
@endsection