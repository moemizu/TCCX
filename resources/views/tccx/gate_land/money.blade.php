@extends('layouts.base')

@section('title','GATE Land Money')

@section('content')
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
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection