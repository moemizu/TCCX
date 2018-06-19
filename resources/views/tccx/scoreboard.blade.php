@extends('layouts.base')

@section('title','Scoreboard')

@section('content')
    @include('tccx.nav')
    <!-- Main container -->
    <div class="container">
        <div class="row"><!-- Table -->
            <div class="col-md-8">
                <!-- Main Scoreboard Display -->
                <div id="scoreboard" class="card my-2">
                    <h5 class="card-header"><i class="fas fa-star"></i> Scoreboard</h5>
                    <div class="card-body">
                        <table class="mt-3 table table-hover table-sm">
                            <thead class="w-100">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Team Name</th>
                                <th scope="col">Score</th>
                                <th scope="col">Last Action</th>
                            </tr>
                            </thead>
                            <tbody class="w-100">
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
                </div>
            </div>
            <div class="col-md-4">
                <!-- Scoreboard Admin -->
                <div id="scoreboard-admin" class="card my-2">
                    <h5 class="card-header"><i class="fas fa-wrench"></i> Manage Score</h5>
                    <div class="card-body">
                        <h6><i class="fas fa-plus"></i> Increase/Decrease</h6>
                        <form id="form-score-change" action="scoreboard/change" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Team</label>
                                <select id="input-team" name="team" class="custom-select form-control-sm">
                                    @foreach($teams->sortBy('score') as $team)
                                        <option value="{{$team->id}}">{{$team->name}} ({{$team->score}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="input-score">Amount</label>
                                <input type="number" class="form-control form-control-sm" name="score" id="input-score"
                                       placeholder="Score">
                                <small id="scoreHelp" class="form-text text-muted">Enter negative value to decrease
                                    score
                                </small>
                            </div>
                            <button id="score-change-submit" type="submit" class="btn btn-primary btn-sm">Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection