@extends('layouts.base')

@section('title','Team')

@section('content')
    @include('tccx.nav')
    <div class="container">
        @inject('faker','Faker\Generator')
        <div id="team-grid" class="row">
            @foreach($teams as $team)
                <div class="col-md-4 col-sm-6 col-12 mb-4 d-flex align-items-stretch">
                    <div id="team-{{$team->id}}" class="card">
                        <h5 class="card-header">Team #{{$team->id}}</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5 col-sm-12">
                                    <img class="img-fluid rounded-circle p-3" src="{{$faker->imageUrl(480,480)}}"
                                         alt="...">
                                </div>
                                <div class="col-md-7 col-sm-12">
                                    <p class="card-text">{{str_limit($faker->paragraph())}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="m-3">
                            <div class="row">
                                <div class="col">
                                    <a href="#" class="btn btn-primary">Members</a>
                                    <a href="#" class="btn btn-secondary">Edit</a>
                                </div>
                            </div>
                        </div>
                        <!-- todo: image aspect ratio -->
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection