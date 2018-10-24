@extends('layouts.base')

@section('title','Edit quest')

@section('content')
    @include('tccx.nav')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div id="edit-quest" class="card m-2 mb-4">
                    <h5 class="card-header"><i class="fas fa-edit"></i> Edit Quest</h5>
                    <div class="card-body">
                        @include('tccx.shared.errors')
                        <form id="form-edit-quest" method="post" action="/quest/edit">
                        {{csrf_field()}}
                            <input type="hidden" name="edit" value="1">
                        <!-- Common -->
                        @include('tccx.quest.form')
                        <!-- Submit  -->
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
