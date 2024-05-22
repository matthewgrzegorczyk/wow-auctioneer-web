@extends('layout')

@section('head_data')
    <script>
        var data = {{ Illuminate\Support\Js::from($serverStats) }};
    </script>
@endsection

@section('content')
    <canvas id="acquisitions"></canvas>
@endsection
