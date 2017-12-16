@extends('layouts.app')

@section('body');


    <center><h1>Fixtures</h1></center>
    <table class="table table-striped table-hover ">
        <thead>
            <tr>

                <th width="500px">Datum</th>
                <th>Thuis</th>
                <th>Uit</th>
                <th>Uitslag</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

            @foreach($fixtures as $fixture)

            <tr>

                <td>{{$fixture['date']}}</td>
                <td>{{$fixture['homeTeamName']}}</td>
                <td>{{$fixture['awayTeamName']}}</td>
                <td>{{$fixture['result']['goalsHomeTeam']}}-{{$fixture['result']['goalsAwayTeam']}}</td>
                <td>{{$fixture['status']}}</td>

            </tr>

            @endforeach

        </tbody>
    </table> 



    @endsection