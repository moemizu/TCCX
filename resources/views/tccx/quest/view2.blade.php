@extends('layouts.base')

@section('title')
    @if(count($quests) > 1)
        Quests
    @else
        {{$quests[0]->name ?? 'Quest'}}
    @endif
@endsection

@section('content')
    <div class="container d-print-none mt-3 mt-md-5">
        <div class="row">
            <div class="col justify-content-end">
                <button type="button" class="btn btn-primary" onclick="window.print()">Print</button>
                @if($full) <span class="text-warning">  Warning: full edition</span>@endif
            </div>
        </div>
    </div>
    @foreach($quests as $quest)
        @include('tccx.quest.view2-block', ['quest' => $quest])
    @endforeach
@endsection

@push('styles')
    @include('tccx.quest.view2-style')
@endpush