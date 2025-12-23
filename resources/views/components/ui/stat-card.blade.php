@props(['title', 'value', 'color', 'icon'])

<div
    class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100 transition-transform hover:scale-[1.02]">
    <div class="p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 {{ $color }} rounded-xl p-3 shadow-lg">
                <i class="{{ $icon }} text-white text-xl w-6 h-6 flex items-center justify-center"></i>
            </div>
            <div class="ml-5">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ $title }}</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($value) }}</p>
            </div>
        </div>
    </div>
</div>
