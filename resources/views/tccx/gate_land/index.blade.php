@extends('layouts.base')

@section('title','GATE Land')

@section('content')
    @include('tccx.nav')
    <div class="container">
    @include('tccx.shared.status')
    @include('tccx.shared.errors')
    <!-- Score/Money -->
        <div class="row">
            @foreach($teams as $team)
                <div class="col-md-4 col-sm-6 my-2">
                    <div class="card">
                        <h5 class="card-header">#{{$loop->iteration}} {{$team->name}}</h5>
                        <div class="card-body">
                            <!-- Money -->
                            <div class="row">
                                <div class="col-md-8 col-sm-8 col-6"><h4 class="card-title">Money: <span
                                                class="text-primary">{{$team->money->money}}</span></h4>
                                </div>
                                <div class="col-md-4 col-sm-4 col-6 text-left">
                                    @if(Auth::check() && Auth::user()->can('manage_gate_land_money'))
                                        <div class="btn-group" role="group" aria-label="Add or subtract a money">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#set-money" data-team="{{$team->id}}"
                                                    data-money="{{$team->money->money}}"
                                                    data-team-name="{{$team->name}}"
                                                    data-subtract="0" data-text-money="Add">+
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                    data-target="#set-money" data-team="{{$team->id}}"
                                                    data-money="{{$team->money->money}}"
                                                    data-team-name="{{$team->name}}"
                                                    data-subtract="1" data-text-money="Subtract">-
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- Score -->
                        <!--<div class="row">
                                <div class="col-md-8 col-sm-8 col-6"><h4 class="card-title">Score: <span
                                                class="text-info">{{$team->money->score}}</span></h4>
                                </div>
                                <div class="col-md-4 col-sm-4 col-6 text-left">
                                    @if(Auth::check() && Auth::user()->can('manage_gate_land_score'))
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                data-target="#set-score" data-team="{{$team->id}}"
                                                data-score="{{$team->money->score}}" data-team-name="{{$team->name}}">
                                            Set
                                        </button>
                                    @endif
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @if(Auth::check() && Auth::user()->can('manage_gate_land_score'))
        <!-- Set score -->
            <div class="modal fade" id="set-score" tabindex="-1" role="dialog" aria-labelledby="setScoreTitle"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="setScoreTitle"><i class="fas fa-wrench"></i> Set score (<span
                                        id="team-name" class="text-info"></span>)</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form-set-score" method="post" action="/gate-land/set-score">
                                {{csrf_field()}}
                                <input id="input-team" type="hidden" name="team" value="">
                                <div class="form-group row mb-2">
                                    <label for="input-score" class="col-sm-2 col-form-label">Score</label>
                                    <div class="col-sm-10">
                                        <input name="score" type="number" class="form-control" id="input-score"
                                               value="0">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-info" onclick="$('#form-set-score').submit()">Save
                                changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    @endif
    @if(Auth::check() && Auth::user()->can('manage_gate_land_money'))
        <!-- Set money -->
            <div class="modal fade" id="set-money" tabindex="-1" role="dialog" aria-labelledby="setMoneyTitle"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="setMoneyTitle"><i class="fas fa-wrench"></i> <span
                                        id="text-money"></span> money (<span
                                        id="team-name-money" class="text-primary"></span>)</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form-set-money" method="post" action="/gate-land/set-money">
                                {{csrf_field()}}
                                <input id="input-team-money" type="hidden" name="team" value="">
                                <input id="input-subtract" type="hidden" name="subtract" value="">
                                <div class="form-group row mb-2">
                                    <label for="input-money" class="col-sm-2 col-form-label">Current</label>
                                    <div class="col-sm-10">
                                        <input type="number" readonly class="form-control " id="input-money"
                                               value="0">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="input-money" class="col-sm-2 col-form-label">Change</label>
                                    <div class="col-sm-10">
                                        <input name="money" type="number" class="form-control" id="input-money-change"
                                               value="0">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="$('#form-set-money').submit()">Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection