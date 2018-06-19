@extends('layouts.base')

@section('title','Quests')

@section('content')
    @include('tccx.nav')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="quest-list" class="card m-2">
                    <h5 class="card-header"><i class="fas fa-list-alt"></i> Quest List</h5>
                    <div class="card-body">
                        <a class="btn btn-primary d-print-none" href="/quest/create" role="button">
                            <i class="fas fa-plus"></i> Create
                        </a>
                        <table class="mt-3 table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Code</th>
                                <th scope="col">Difficulty</th>
                                <th scope="col">Location</th>
                                <th scope="col">Instruction</th>
                                <th scope="col">Reward</th>
                                <th class="text-nowrap" scope="col">Assign to</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php /**@var App\TCCX\Quest\Quest $quest */?>
                            @inject('qc','App\TCCX\Quest\QuestCode')
                            @foreach($quests as $quest)
                                <tr>
                                    <th scope="row">{{$quest->id}}</th>
                                    <td>{{$quest->name}}</td>
                                    <td>{{$qc->generate($quest)}}</td>
                                    <td>{{ucfirst($quest->difficulty)}}</td>
                                    <td>{{$quest->quest_location->name}}</td>
                                    <td>{{str_limit($quest->how_to,50)}}</td>
                                    <td>{{$quest->reward}}</td>
                                    <td class="text-muted">None</td>
                                    <td>&#x22EF</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row d-print-none">
                            <div class="col-md-6 offset-md-3 py-3">
                                {{ $quests->appends($_GET)->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection