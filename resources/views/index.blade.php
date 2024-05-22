@extends('layout')

@section('content')
    <h2>Players</h2>
    <ul>
        @foreach ($players as $player)
            <li>
                <a href="https://logs.stormforge.gg/en/character/netherwing/{{ strtolower($player) }}" target="_blank">{{ $player }}</a>
            </li>
        @endforeach
    </ul>
@endsection
