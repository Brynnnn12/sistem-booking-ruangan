@if (session()->has('success'))
    <x-ui.sweet-alert type="success" title="Berhasil" text="{{ session('success') }}" :show-on-load="true" timer="3000"
        position="top-end" toast="true" width="300px" />
@endif

@if (session()->has('error'))
    <x-ui.sweet-alert type="error" title="Gagal" text="{{ session('error') }}" :show-on-load="true" timer="3000"
        position="top-end" toast="true" width="300px" />
@endif

@if (session()->has('warning'))
    <x-ui.sweet-alert type="warning" title="Peringatan" text="{{ session('warning') }}" :show-on-load="true" timer="3000"
        position="top-end" toast="true" width="300px" />
@endif

@if (session()->has('info'))
    <x-ui.sweet-alert type="info" title="Info" text="{{ session('info') }}" :show-on-load="true" timer="3000"
        position="top-end" toast="true" width="300px" />
@endif

@if ($errors->any())
    @php
        $errorListHtml =
            '<ul class="text-left">' .
            implode('', array_map(fn($message) => '<li>' . e($message) . '</li>', $errors->all())) .
            '</ul>';
    @endphp
    <x-ui.sweet-alert type="error" title="Validasi" text="{{ $errorListHtml }}" :html="true" :show-on-load="true"
        timer="5000" position="top-end" toast="true" width="350px" />
@endif
