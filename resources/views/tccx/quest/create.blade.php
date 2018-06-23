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
                        <form id="form-add-quest" method="post" action="/quest/create">
                            {{csrf_field()}}
                            <h5><i class="fas fa-pencil-alt"></i> General</h5>
                            <!-- Name/order group -->
                            <div class="form-row">
                                <div class="form-group col-md-8 col-sm-8">
                                    <label class="col-form-label" for="input-name">Name</label>
                                    <input required type="text" class="form-control" id="input-name" name="name"
                                           placeholder="Name" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4 col-sm-4">
                                    <label class="col-form-label" for="input-order">Order</label>
                                    <input required type="number" min="0" max="999" class="form-control"
                                           id="input-order" name="order"
                                           placeholder="Order">
                                </div>
                            </div>
                            <!-- Type/zone/difficulty group -->
                            <div class="form-row">
                                <div class="form-group col-md-4 col-sm-4">
                                    <label class="col-form-label" for="input-type">Type</label>
                                    <select id="input-type" name="type" class="custom-select">
                                        {{-- Default to side quest --}}
                                        @foreach($types as $type)
                                            <option @if($type->id == 2) selected
                                                    @endif value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 col-sm-4">
                                    <label class="col-form-label" for="input-zone">Zone</label>
                                    <select id="input-zone" name="zone" class="custom-select">
                                        @foreach($zones as $zone)
                                            <option value="{{$zone->id}}">{{$zone->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 col-sm-4">
                                    <label class="col-form-label" for="input-zone">Difficulty</label>
                                    <select id="input-difficulty" name="difficulty" class="custom-select">
                                        <option value="Easy">Easy (100)</option>
                                        <option value="Normal">Normal (200)</option>
                                        <option value="Hard">Hard (300)</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Location -->
                            <h5><i class="fas fa-location-arrow"></i> Location</h5>
                            <h6 class="mb-0">Select existing</h6>
                            <div class="form-row">
                                <div class="form-group col-md-8 col-sm-8">
                                    <label class="col-form-label" for="input-location-id">Location</label>
                                    <select id="input-location-id" name="location-id" class="custom-select">
                                        <option value="">None</option>
                                        @foreach($locations as $loc)
                                            <option value="{{$loc->id}}">{{$loc->name}} ({{$loc->type}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <h6 class="mb-0">Or create the new one</h6>
                            <div class="form-row">
                                <div class="form-group col-md-8 col-sm-9">
                                    <label class="col-form-label" for="input-location-name">Location Name</label>
                                    <input type="text" class="form-control" id="input-location-name"
                                           name="location-name"
                                           placeholder="Location Name" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4 col-sm-3">
                                    <label class="col-form-label" for="input-location-type">Type</label>
                                    <input type="text" class="form-control" id="input-location-type"
                                           name="location-type"
                                           placeholder="Location Type">
                                </div>
                            </div>
                            <!-- Lat/Lng -->
                            <div class="form-row">
                                <div class="form-group col-md-4 col-sm-6">
                                    <label class="col-form-label" for="input-location-lat">Latitude</label>
                                    <input type="text" pattern="(\-?\d+(\.\d+)?)" class="form-control"
                                           id="input-location-lat" name="location-lat"
                                           placeholder="Latitude">
                                </div>
                                <div class="form-group col-md-4 col-sm-6">
                                    <label class="col-form-label" for="input-location-lng">Longitude</label>
                                    <input type="text" pattern="(\-?\d+(\.\d+)?)" class="form-control"
                                           id="input-location-lng" name="location-lng"
                                           placeholder="Longitude">
                                </div>
                            </div>
                            <!-- Details -->
                            <h5><i class="fas fa-info-circle"></i> Details</h5>
                            <div class="form-group">
                                <label for="input-story">Story</label>
                                <textarea class="form-control" id="input-story" name="story" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="input-how-to">How to</label>
                                <textarea class="form-control" id="input-how-to" name="how-to" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="input-criteria">Criteria <span
                                            class="text-warning">(Only staff can see this)</span></label>
                                <textarea class="form-control" id="input-criteria" name="criteria" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="input-editorial">Editorial <span
                                            class="text-warning">(Only staff can see this)</span></label>
                                <textarea class="form-control" id="input-editorial" name="editorial"
                                          rows="5"></textarea>
                            </div>
                            <!-- Submit  -->
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection