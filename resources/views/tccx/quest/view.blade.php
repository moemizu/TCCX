@extends('layouts.base')

@section('title')
    Quest: {{$quest->name ?? 'Unnamed quest'}}
@endsection

@section('content')
    <div class="container">
    @inject('qc','App\TCCX\Quest\QuestCode')
    @inject('pd','Parsedown')
    <!-- Quest title row -->
        <div class="row" style="margin-top: 64px;margin-bottom: 16px">
            <div class="col">
                <h2><span class="text-quest-header"><i class="fas fa-bookmark"></i> {{$quest->name}}</span></h2>
                <div id="quest-code">
                    <h3 class="text-quest-code d-none d-sm-none d-md-block">
                        {{$qc->generate($quest)}}
                    </h3>
                </div>
                <h5 class="d-md-none d-block d-sm-block ml-3">
                    {{$qc->generate($quest)}}
                </h5>
            </div>
        </div>
        <div class="row d-print-none">
            <div class="col">
                <button onclick="window.print()" role="button" class="btn btn-primary ml-3">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
        <!-- general details -->
        <dl class="row text-quest-details m-2">
            <dt class="col-sm-2">Type</dt>
            <dd class="col-sm-10">{{$quest->quest_type->name}}</dd>

            <dt class="col-sm-2">Zone</dt>
            <dd class="col-sm-10">{{$quest->quest_zone->name}}</dd>

            <dt class="col-sm-2">Location</dt>
            <dd class="col-sm-10">
                {{$quest->quest_location->name}} ({{$quest->quest_location->type}})
            </dd>

            <dt class="col-sm-2">Difficulty (Reward)</dt>
            <dd class="col-sm-7">{{$quest->difficulty}} ({{$quest->reward}})</dd>
        </dl>
        <!-- Story -->
        <div class="row ml-2 ml-md-0 mt-md-3 mt-sm-2">
            <h3><span class="text-quest-header"><i class="fas fa-book-open fa-fw"></i> Story</span></h3>
        </div>
        <div class="row text-quest-details m-2">
            <div class="col">{!! $pd->parse($quest->story) !!}</div>
        </div>
        <!-- How to -->
        <div class="row ml-2 ml-md-0 ">
            <h3><span class="text-quest-header"><i class="fas fa-wrench fa-fw"></i> How to</span></h3>
        </div>
        <div class="row text-quest-details m-2">
            <div class="col">
                {!! $pd->parse($quest->how_to) !!}
            </div>
        </div>
        <!-- Criteria -->
        <div class="row ml-2 ml-md-0 d-print-none">
            <h3><span class="text-quest-header"><i class="fas fa-list fa-fw"></i> Criteria</span></h3>
        </div>
        <div class="row text-quest-details m-2 d-print-none">
            <div class="col">
                {!! $pd->parse($quest->criteria) !!}
            </div>
        </div>
        <!-- Editorial -->
        <div class="row ml-2 ml-md-0 d-print-none">
            <h3><span class="text-quest-header"><i class="fas fa-unlock fa-fw"></i> Editorial</span></h3>
        </div>
        <div class="row text-quest-details m-2 d-print-none">
            <div class="col">
                {!! $pd->parse($quest->meta) !!}
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .background-fixed {
            background: none;
        }
    </style>
@endpush