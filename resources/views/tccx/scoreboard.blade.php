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
                                <th class="sorting" scope="col">
                                    <a href="{{ route('tccx.scoreboard',
                                    ['sort' => $sorting->inv('name')])}}">
                                        Team Name <span class="float-right">
                                            <i class="fas fa-{{$sorting->dir('name',['sort-up','sort-down','sort'])}}">
                                            </i></span></a>
                                </th>
                                <th class="sorting" scope="col"><a href="{{ route('tccx.scoreboard',
                                    ['sort' => $sorting->inv('score')])}}">
                                        Score <span class="float-right">
                                            <i class="fas fa-{{$sorting->dir('score',['sort-up','sort-down','sort'])}}">
                                            </i></span></a>
                                </th>
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
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li style="font-size: 0.9em">{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form id="form-score-change" action="scoreboard/change" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Team</label>
                                <select id="input-team" name="team" class="custom-select form-control-sm">
                                    @foreach($teams->sortBy('score') as $team)
                                        <option @if(old('team',-1) == $team->id)
                                                selected
                                                @endif
                                                value="{{$team->id}}">{{$team->name}} ({{$team->score}})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="input-team-checkbox"
                                       name="all-team" value="1">
                                <label class="custom-control-label" for="input-team-checkbox">Apply change to all
                                    team</label>
                            </div>
                            <div class="form-group">
                                <label for="input-score">Amount</label>
                                <input type="number" class="form-control form-control-sm" name="score" id="input-score"
                                       placeholder="Score" value="{{old('score')}}">
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

@push('scripts')
    @if (session()->has('scroll-to'))
        <script>
            setTimeout(window.PageUtil.scrollToElement('{{session("scroll-to",'')}}'), 100);
        </script>
    @endif
@endpush