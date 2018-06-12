@extends('layouts.base')

@section('title','Scoreboard')

@section('content')
    {{-- TODO: Navigation bar --}}
    <!-- Main container -->
    <div class="container">
        <!-- Table -->
        <table class="table table-dark table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Team Name</th>
                <th scope="col">Score</th>
                <th scope="col">Last Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($teams as $team)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$team->name}}</td>
                    <td>{{$team->score}}</td>
                    <td>...</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection