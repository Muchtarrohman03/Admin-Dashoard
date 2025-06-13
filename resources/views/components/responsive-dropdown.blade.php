@props([
    'align' => 'right',
    'width' => 'full',
    'contentClasses' => 'py-1 bg-white',
])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right sm:start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left sm:end-0',
};

$widthClass = match ($width) {
    'full' => 'w-full',
    default => $width,
};
@endphp

<div class="relative sm:inline-block w-full" x-data="{ open: false }" @click.outside="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <!-- Overlay untuk mobile (opsional) -->
    <div 
        class="fixed inset-0 z-40 bg-black bg-opacity-30 sm:hidden" 
        x-show="open" 
        x-transition.opacity 
        @click="open = false" 
        style="display: none;">
    </div>

    <!-- Dropdown -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute sm:absolute sm:mt-2 z-50 sm:rounded-md shadow-lg sm:{{ $alignmentClasses }} {{ $widthClass }} 
                w-full left-0 bottom-0 sm:static sm:w-auto sm:left-auto sm:bottom-auto sm:bg-transparent"
         style="display: none;"
         @click="open = false">

        <div class="rounded-t-lg sm:rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
