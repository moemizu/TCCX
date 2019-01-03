<?php /** @var App\TCCX\Quest\Quest $quest */ ?>
@inject('qc','App\TCCX\Quest\QuestCode')
@inject('pd','Parsedown')
<div id="quest-view" class="container">
    <!-- Logo row -->
    <div class="row">
        <div class="col quest-logo text-center">
            <img class="img-fluid quest-logo-image" src="/storage/images/tccxlogo.png" alt="TCCX">
        </div>
    </div>
    <!-- Name row -->
    <div class="row">
        <div class="col quest-name text-center">
            <strong>{{$quest->name}}</strong>
        </div>
    </div>
    <!-- Type row -->
    <div class="row">
        <div class="col-md-4 offset-md-8 quest-detail ">
            <div class="row my-1">
                <div class="col-md-3 col-sm-3 col-4 quest-head">Type</div>
                <div class="col-md-8 col-sm-9 col-8 quest-sub-detail">{{$quest->quest_type->name ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <!-- Level row -->
    <div class="row">
        <div class="col-md-4 offset-md-8 quest-detail">
            <div class="row my-1">
                <div class="col-md-3 col-sm-3 col-4 quest-head">Level</div>
                <div class="col-md-8 col-sm-9 col-8 quest-sub-detail">{{$quest->difficulty ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <!-- Code row -->
    <div class="row">
        <div class="col-md-4 offset-md-8 quest-detail">
            <div class="row my-1">
                <div class="col-md-3 col-sm-3 col-4 quest-head">Code</div>
                <div class="col-md-8 col-sm-9 col-8 quest-sub-detail">{{$qc->generate($quest)}}</div>
            </div>
        </div>
    </div>
    <!-- Location -->
    <div class="row mt-3 mb-1">
        <div class="col-md-2 col-sm-3 quest-head-secondary quest-detail">
            Location
        </div>
        <div class="col-md-10 col-sm-9 quest-detail quest-sub-detail">
            {{$quest->quest_location->name ?? 'N/A'}}
        </div>
    </div>
    <!-- Material -->
    <div class="row mt-3 mb-5 @if(!$full) d-print-none @endif">
        <div class="col-md-2 col-sm-3 quest-head-secondary quest-detail">
            Material
        </div>
        <div class="col-md-10 col-sm-9 quest-detail quest-sub-detail">
            {{$quest->material ?? '-'}}
        </div>
    </div>
    <!-- Background -->
    @if(!empty($quest->story))
        <div class="row mt-3 mb-1">
            <div class="col-12 quest-head-secondary quest-detail py-1">
                Background
            </div>
            <div class="col-12 quest-detail quest-sub-detail">
                {!! $pd->parse($quest->story) !!}
            </div>
        </div>
@endif
<!-- How to -->
    <div class="row mt-3 mb-1">
        <div class="col-12 quest-head-secondary quest-detail py-1">
            Description
        </div>
        <div class="col-12 quest-detail quest-sub-detail">
            {!! $pd->parse($quest->how_to) !!}
        </div>
    </div>
    <div class="row mt-3 mb-1">
        <div class="col-12 quest-head-secondary quest-detail py-1">
            Target
        </div>
        <div class="col-12 quest-detail quest-sub-detail">
            {!! $pd->parse($quest->target) !!}
        </div>
    </div>
    <!-- Criteria  -->
    <div class="row mt-3 mb-1 @if(!$full) d-print-none @endif">
        <div class="col-12 quest-head-secondary quest-detail py-1">
            Criteria
        </div>
        <div class="col-12 quest-detail quest-sub-detail">
            {!! $pd->parse($quest->criteria) !!}
        </div>
    </div>
    <!-- Note -->
    <div class="row mt-3 mb-1 d-print-none">
        <div class="col-12 quest-head-secondary quest-detail py-1">
            Note
        </div>
        <div class="col-12 quest-detail quest-sub-detail">
            {!! $pd->parse($quest->meta) !!}
        </div>
    </div>
</div>
<div class="page-break"></div>