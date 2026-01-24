@php
    $types = [
        'success' => 'success',
        'warning' => 'warning'
    ];
@endphp

@foreach ($types as $key => $bootstrap)
    @if (session($key))
        <div class="alert alert-{{ $bootstrap }} alert-dismissible fade show" role="alert">
            {{ session($key) }}
            {{-- <button type="button" class="close" data-dismiss="alert"></button> --}}
        </div>
    @endif
@endforeach

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $errors->first() }}
    </div>
@endif