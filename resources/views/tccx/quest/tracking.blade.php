@extends('layouts.base')

@section('title','Tracking')

@section('content')
    @include('tccx.nav')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('tccx.shared.status')
                @include('tccx.shared.errors')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="tracking" class="card my-2">
                    <h5 class="card-header"><i class="fas fa-info-circle"></i> Tracking</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="mt-3 table table-hover table-sm table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" class="align-middle text-center">#</th>
                                    <th scope="col" class="align-middle text-center">Name</th>
                                    <th scope="col" class="align-middle text-center">Tracking No.</th>
                                    <th scope="col" class="align-middle text-center">Item</th>
                                    <th scope="col" class="align-middle text-center">Used</th>
                                    <th scope="col" class="align-middle text-center">Current Quest</th>
                                    <th scope="col" class="align-middle text-center">Main 1</th>
                                    <th scope="col" class="align-middle text-center">Main 2</th>
                                    <th scope="col" class="align-middle text-center">Side Morning</th>
                                    <th scope="col" class="align-middle text-center">Lunch</th>
                                    <th scope="col" class="align-middle text-center">Main 3</th>
                                    <th scope="col" class="align-middle text-center">Main 4</th>
                                    <th scope="col" class="align-middle text-center">Side Afternoon</th>
                                </tr>
                                </thead>
                                <tbody>
                                @inject('qc','App\TCCX\Quest\QuestCode')
                                @foreach($teams as $team)
                                    <tr>
                                        <td class="align-middle text-center">{{$loop->iteration}}</td>
                                        <td class="align-middle text-center">{{$team->name}}</td>
                                        <td class="align-middle text-center">{{optional($team->tracking)->assigned_group ?? '-'}}</td>
                                        <td class="align-middle text-center">{{optional(optional($team->tracking)->item)->name ?? '-'}}</td>
                                        <td class="align-middle text-center">
                                            @if(optional(optional($team->tracking)->item)->used)
                                                Yes, {{empty($team->tracking->item->usage) ? 'No details.' : $team->tracking->item->usage}}
                                            @else
                                                No
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">{{$states[$team->id]['current_quest'] ?? '-'}}</td>
                                        <!-- Morning -->
                                        <td class="align-middle text-center">
                                            @if($states[$team->id]['M']['M'] > 0)
                                                &#x2713
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            @if($states[$team->id]['M']['M'] > 1)
                                                &#x2713
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            @if($states[$team->id]['S']['M'] > 0)
                                                {{$states[$team->id]['S']['M']}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <!-- Lunch -->
                                        <td class="align-middle text-center">
                                            @if($states[$team->id]['L']['M'] > 0)
                                                &#x2713
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <!-- Afternoon -->
                                        <td class="align-middle text-center">
                                            @if($states[$team->id]['M']['A'] > 0)
                                                &#x2713
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            @if($states[$team->id]['M']['A'] > 1)
                                                &#x2713
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            @if($states[$team->id]['S']['A'] > 0)
                                                {{$states[$team->id]['S']['A']}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tools -->
        <div class="row">
            <!-- Group -->
            <div class="col-md-4 my-2">
                <div class="card">
                    <h5 class="card-header"><i class="fas fa-wrench"></i> Set Group</h5>
                    <div class="card-body">
                        <form id="form-set-group" method="post" action="/quest/tracking/set-group">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="input-team" class="col-sm-4 col-form-label">Team</label>
                                <div class="col-sm-8">
                                    <select id="input-team" name="team" class="custom-select form-control">
                                        @foreach($teams->sortBy('score') as $team)
                                            <option @if(old('team',-1) == $team->id)
                                                    selected
                                                    @endif
                                                    value="{{$team->id}}">{{$team->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-group" class="col-sm-4 col-form-label">Group</label>
                                <div class="col-sm-8">
                                    <input name="group" type="number" min="1" class="form-control" id="input-group"
                                           placeholder="Group No.">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 offset-sm-4">
                                    <button type="submit" class="btn btn-primary">Set</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-md-4 my-2">
                <div class="card">
                    <h5 class="card-header"><i class="fas fa-wrench"></i> Give Item</h5>
                    <div class="card-body">
                        <form id="form-set-group" method="post" action="/quest/tracking/set-item">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="input-team" class="col-sm-4 col-form-label">Team</label>
                                <div class="col-sm-8">
                                    <select id="input-team" name="team" class="custom-select form-control">
                                        @foreach($teams as $team)
                                            <option @if(old('team',-1) == $team->id)
                                                    selected
                                                    @endif
                                                    value="{{$team->id}}">{{$team->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-item" class="col-sm-4 col-form-label">Item</label>
                                <div class="col-sm-8">
                                    <select id="input-item" name="item" class="custom-select form-control">
                                        @foreach($items as $item)
                                            <option @if(old('item',-1) == $item->id)
                                                    selected
                                                    @endif
                                                    value="{{$item->id}}">{{$item->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 offset-sm-4">
                                    <button type="submit" class="btn btn-primary">Give</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Set used -->
            <div class="col-md-4 my-2">
                <div class="card">
                    <h5 class="card-header"><i class="fas fa-wrench"></i> Set Item Status</h5>
                    <div class="card-body">
                        <form id="form-toggle-item" method="post" action="/quest/tracking/set-item">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="input-team" class="col-sm-4 col-form-label">Team</label>
                                <div class="col-sm-8">
                                    <select id="input-team" name="team" class="custom-select form-control">
                                        @foreach($teams as $team)
                                            <option @if(old('team',-1) == $team->id)
                                                    selected
                                                    @endif
                                                    value="{{$team->id}}">{{$team->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-used" class="col-sm-4 col-form-label">Used</label>
                                <div class="col-sm-8">
                                    <select id="input-used" name="used" class="custom-select form-control">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 offset-sm-4">
                                    <button type="submit" class="btn btn-primary">Set</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection