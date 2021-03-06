@extends('layouts.base')

@section('title','Create a new quest')

@section('content')
    @include('tccx.nav')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div id="create-quest" class="card m-2 mb-4">
                    <h5 class="card-header"><i class="fas fa-edit"></i> Create a New Quest</h5>
                    <div class="card-body">
                        @include('tccx.shared.errors')
                        <form id="form-add-quest" method="post" action="/quest/create">
                        {{csrf_field()}}
                        <!-- Common -->
                        @include('tccx.quest.form')
                        <!-- Submit  -->
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection