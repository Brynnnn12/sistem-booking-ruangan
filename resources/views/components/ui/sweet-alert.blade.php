@props([
    'type' => 'info',
    'title' => '',
    'text' => '',
    'html' => false,
    'confirmButton' => 'OK',
    'showOnLoad' => false,
    'timer' => null,
    'position' => 'center',
    'toast' => false,
    'width' => null,
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
            const options = {
                icon: @js($config['icon']),
                title: @js($title),
                toast: @js((bool) $toast),
                position: @js($toast && $position === 'center' ? 'top-end' : $position),
                timer: @js($timer),
                timerProgressBar: @js((bool) $timer),
                showConfirmButton: @js(!$timer),
                confirmButtonColor: @js($config['color']),
                confirmButtonText: @js($confirmButton),
                width: @js($width),
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
            };

            if (@js((bool) $html)) {
                options.html = @js($text);
            } else {
                options.text = @js($text);
            }

            Swal.fire(options);
        });
    </script>
@endif
