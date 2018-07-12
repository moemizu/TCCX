@extends('layouts.base')

@section('title','Quest Locations')

@section('content')
    @include('tccx.nav')
    <script>
        {{-- Note: in PhpStorm, it will raise an error with message "expression expected" --}}
            window.AppData.questLocations = {!!  json_encode($questLocations->items())!!};
    </script>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="quest-location-list" class="card m-2">
                    <h5 class="card-header"><i class="fas fa-map"></i> Quest Locations</h5>
                    <div class="card-body">
                        <button class="btn btn-primary d-print-none" @click="create" role="button">
                            <i class="fas fa-plus"></i> Create
                        </button>
                        <table class="mt-3 table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th class="w-40" scope="col">Name</th>
                                <th class="w-15" scope="col">Type</th>
                                <th class="w-15" scope="col">Coordinate</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody v-cloak class="cloak-transition">
                            <tr is="quest-location" v-for="ql in questLocations" :key="ql.id" :id="ql.id"
                                :name="ql.name" :type="ql.type"
                                :lat="ql.lat" :lng="ql.lng"></tr>
                            </tbody>
                        </table>
                        <div class="row d-print-none">
                            <div class="col-md-6 offset-md-3 py-3">
                                {{ $questLocations->appends($_GET)->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                        <!-- delete modal -->
                        <div class="modal fade" id="quest-location-delete-modal" tabindex="-1" role="dialog"
                             aria-labelledby="quest-location-delete-message" aria-hidden="true">
                            <div id="dialog-quest-location-delete" class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="quest-location-delete-message">Delete Quest
                                            Location?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-danger">This will permanently delete this location and can't be
                                            undone.</p>
                                        <form id="form-delete-quest-location" method="post"
                                              action="/quest/location/delete">
                                            {{csrf_field()}}
                                            <input type="hidden" id="input-delete-quest-location"
                                                   name="quest-location-id" value="">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel
                                        </button>
                                        <button type="button" class="btn btn-danger"
                                                onclick="$('form#form-delete-quest-location').submit()">Delete
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