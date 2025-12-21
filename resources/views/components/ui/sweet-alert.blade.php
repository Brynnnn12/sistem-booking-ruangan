@props([
    'type' => 'info',
    'title' => '',
    'text' => '',
    'confirmButton' => 'OK',
    'showOnLoad' => false,
    'timer' => null,
    'position' => 'center',
    'toast' => false,
])

@php
    $config = [
        'success' => ['icon' => 'success', 'color' => '#10b981'],
        'error' => ['icon' => 'error', 'color' => '#dc2626'],
        'warning' => ['icon' => 'warning', 'color' => '#f59e0b'],
        'info' => ['icon' => 'info', 'color' => '#3b82f6'],
    ][$type] ?? ['icon' => 'info', 'color' => '#3b82f6'];
@endphp

@if ($showOnLoad)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '{{ $config['icon'] }}',
                title: '{{ $title }}',
                text: `{!! $text !!}`,
                toast: {{ $toast ? 'true' : 'false' }},
                position: '{{ $toast && $position === 'center' ? 'top-end' : $position }}',
                timer: {{ $timer ?? 'null' }},
                timerProgressBar: {{ $timer ? 'true' : 'false' }},
                showConfirmButton: {{ $timer ? 'false' : 'true' }},
                confirmButtonColor: '{{ $config['color'] }}',
                confirmButtonText: '{{ $confirmButton }}',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        });
    </script>
@endif
