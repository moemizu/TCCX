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
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php /**@var App\TCCX\Quest\Quest $quest */?>
                            @inject('qc','App\TCCX\Quest\QuestCode')
                            @inject('pd','Parsedown')
                            @foreach($quests as $quest)
                                <tr>
                                    <th scope="row">{{$quest->id}}</th>
                                    <td>{{$quest->name}}</td>
                                    <td>{{$qc->generate($quest)}}</td>
                                    <td>{{ucfirst($quest->difficulty)}}</td>
                                    <td>{{$quest->quest_location->name}}</td>
                                    <td>{{str_limit(strip_tags($pd->parse($quest->how_to)),50)}}</td>
                                    <td>{{$quest->reward}}</td>
                                    <td class="text-muted">None</td>
                                    <td class="text-nowrap">
                                        <a href="/quest/edit?id={{$quest->id}}&last_page={{request('page',1)}}"
                                           class="btn btn-sm btn-primary" role="button" aria-disabled="true"><i
                                                    class="fas fa-edit"></i> Edit</a>
                                        <a href="" data-toggle="modal" data-target="#quest-delete-modal"
                                           data-quest="{{$quest->id}}" class="btn btn-sm btn-danger" role="button"
                                           aria-disabled="true"><i
                                                    class="fas fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row d-print-none">
                            <div class="col-md-6 offset-md-3 py-3">
                                {{ $quests->appends($_GET)->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                        <!-- delete modal -->
                        <div class="modal fade" id="quest-delete-modal" tabindex="-1" role="dialog"
                             aria-labelledby="quest-delete-message" aria-hidden="true">
                            <div id="dialog-quest-delete" class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="quest-delete-message">Delete Quest?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-danger">This will permanently delete this quest and can't be
                                            undone.</p>
                                        <form id="form-delete-quest" method="post" action="/quest/delete">
                                            {{csrf_field()}}
                                            <input type="hidden" id="input-delete-quest" name="quest-id" value="">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel
                                        </button>
                                        <button type="button" class="btn btn-danger"
                                                onclick="$('form#form-delete-quest').submit()">Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection