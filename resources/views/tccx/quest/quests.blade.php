@extends('layouts.base')

@section('title','Quests')

@section('content')
    @include('tccx.nav')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('tccx.shared.status')
                @include('tccx.shared.errors')
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
                                <th scope="col">Type</th>
                                <th scope="col">Time</th>
                                <th scope="col">Group</th>
                                <th scope="col">Location</th>
                                <th scope="col">Level</th>
                                <!--<th scope="col">Instruction</th>-->
                                <th scope="col">Reward</th>
                                <th class="text-nowrap" scope="col">Status</th>
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
                                    <td><a href="/quest/view/{{$qc->generate($quest)}}"
                                           target="_blank">{{$quest->name}}</a></td>
                                    <td>{{optional($quest->quest_type)->code}}</td>
                                    <td>{{[0 => 'N/A',1 => 'M',2 => 'A'][$quest->getOriginal('time')] ?? ''}}</td>
                                    <td>{{$quest->group}}</td>
                                    <td>@if(isset($quest->quest_location))
                                            {{$quest->quest_location->name}} @if(isset($quest->quest_zone))
                                                ({{$quest->quest_zone->name}})@endif
                                        @else <span
                                                    class="text-muted font-italic">Unspecified</span>
                                        @endif
                                    </td>
                                    <td>{{ucfirst($quest->difficulty)}}</td>
                                <!--<td>{{str_limit(strip_tags($pd->parse($quest->how_to)),50)}}</td>-->
                                    <td>{{$quest->reward}}</td>
                                    <td>
                                        {{-- If quest has been assigned --}}
                                        @if(!empty($quest->assignedTo()))
                                            @if($quest->isCompleted())
                                                <span class="text-success">Completed on {{$quest->assignedTo()->pivot->completed_at}}
                                                    by {{$quest->assignedTo()->name}}</span>
                                            @else
                                                <span class="text-muted">Assigned to {{$quest->assignedTo()->name ?? 'None'}}
                                                    on {{$quest->assignedTo()->pivot->assigned_at}}</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="/quest/edit?id={{$quest->id}}&last_page={{request('page',1)}}"
                                           class="btn btn-sm btn-primary" role="button" aria-disabled="true"><i
                                                    class="fas fa-edit"></i> Edit</a>
                                        <a href="" data-toggle="modal" data-target="#quest-delete-modal"
                                           data-quest="{{$quest->id}}" class="btn btn-sm btn-danger" role="button"
                                           aria-disabled="true"><i
                                                    class="fas fa-trash"></i> Delete</a>
                                        @if($quest->assignedTo())
                                            @if(!$quest->isCompleted())
                                                <a href="" data-toggle="modal" data-target="#quest-finish-modal"
                                                   data-quest="{{$quest->id}}" class="btn btn-sm btn-success"
                                                   role="button"
                                                ><i class="fas fa-paper-plane"></i> Finish</a>
                                            @endif
                                        @else
                                            <a href="" data-toggle="modal" data-target="#quest-assign-modal"
                                               data-quest="{{$quest->id}}" class="btn btn-sm btn-info" role="button"
                                            ><i class="fas fa-file"></i> Assign</a>
                                        @endif
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
                        <!-- assign modal -->
                        <div class="modal fade" id="quest-assign-modal" tabindex="-1" role="dialog"
                             aria-labelledby="quest-finish-message" aria-hidden="true">
                            <div id="dialog-quest-assign" class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="quest-finish-message">Assign Quest</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-info">Please select a team</p>
                                        <form id="form-assign-quest" method="post" action="/quest/assign">
                                            {{csrf_field()}}
                                            <input type="hidden" id="input-assign-quest" name="quest-id" value="">
                                            <select id="select-team" name="selected-team" class="form-control">
                                                @foreach($teams as $team)
                                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel
                                        </button>
                                        <button type="button" class="btn btn-info"
                                                onclick="$('form#form-assign-quest').submit()">Assign
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Finish -->
                        <div class="modal fade" id="quest-finish-modal" tabindex="-1" role="dialog"
                             aria-labelledby="quest-finish-message" aria-hidden="true">
                            <div id="dialog-quest-finish" class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="quest-finish-message">Finish Quest</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-info">Are you sure?</p>
                                        <form id="form-finish-quest" method="post" action="/quest/finish">
                                            {{csrf_field()}}
                                            <input type="hidden" id="input-finish-quest" name="quest-id" value="">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel
                                        </button>
                                        <button type="button" class="btn btn-success"
                                                onclick="$('form#form-finish-quest').submit()">Finish
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