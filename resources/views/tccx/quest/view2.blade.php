@extends('layouts.base')

@section('title')
    Quest
@endsection

@section('content')
    <div class="container d-print-none mt-3 mt-md-5">
        <div class="row">
            <div class="col justify-content-end">
                <button type="button" class="btn btn-primary" onclick="window.print()">Print</button>
            </div>
        </div>
    </div>
    @each('tccx.quest.view2-block', $quests, 'quest')
@endsection

@push('styles')
    @include('tccx.quest.view2-style')
@endpush