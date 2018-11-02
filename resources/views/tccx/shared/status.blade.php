@if(session('status'))
    @php
        $s = session('status');
        $icon = [
        'success' => 'check', 'info' => 'info-circle','warning' => 'exclamation-triangle',
        'danger' => 'exclamation-circle'];
    @endphp
    <div class="alert alert-{{$s['type']}} alert-dismissible fade show" role="alert">
        <i class="fas fa-{{$icon[$s['type']] ?? 'info-circle'}}"></i> {{$s['message']}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif