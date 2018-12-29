@extends('layouts.base')

@section('title','Tracking')

@section('content')
    @include('tccx.nav')
    <div class="container">
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
    </div>
@endsection