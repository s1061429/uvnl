@extends('layouts.app')

@section('body');

    <center><h1>Stand</h1></center>
    <table class="table table-striped table-hover ">
        <thead>
            <tr>
                <th>Plaats</th>
                <th>Team</th>
                <th>Gespeeld</th>
                <th>Punten</th>
                <th>Saldo</th>
                <th>Voor</th>
                <th>Tegen</th>
                <th>Tegen</th>
            </tr>
        </thead>
        <tbody>

            <?php $teller = 1;?>
            @foreach($teams as $team => $results)
            <tr>
                <td>{{$teller}}</td>
                <td>{{$team}}</td>
                <td>{{$results['played']}}</td>
                <td>{{$results['points']}}</td>
                <td>{{$results['goaldifference']}}</td>
                <td>{{$results['goalsscored']}}</td>
                <td>{{$results['goalsconceded']}}</td>
                <td>{{$results['meanpoints']}}</td>
            </tr>
            <?php $teller++;?>
            @endforeach
        </tbody>
    </table> 

    @endsection