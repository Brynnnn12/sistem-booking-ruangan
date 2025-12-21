@php
    $alerts = [
        'success' => 'Sukses',
        'error' => 'Error!',
        'warning' => 'Warning!',
        'info' => 'Information',
    ];
@endphp

{{-- Loop untuk session flash messages --}}
@foreach ($alerts as $type => $title)
    @if (session()->has($type))
        <x-ui.sweet-alert type="{{ $type }}" title="{{ $title }}" :text="session('{{ $type }}')" :show-on-load="true"
            timer="3000" position="top-end" toast="true" width="300px" />
    @endif
@endforeach

{{-- Handle khusus untuk Validation Errors --}}
@if ($errors->any())
    <x-ui.sweet-alert type="error" title="Validation Errors" :text="implode('\n', $errors->all())" :show-on-load="true" timer="5000"
        position="top-end" toast="true" width="350px" />
@endif
