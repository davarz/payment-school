<!-- Button Component -->
<button {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-4 py-2 rounded-lg font-medium transition-all duration-200 whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-offset-2 ' . $getClass()]) }}>
    {{ $slot }}
</button>

@props([
    'variant' => 'primary',
    'size' => 'md',
])

@php
function getClass() {
    $variant = $variant ?? 'primary';
    $size = $size ?? 'md';
    
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 shadow-sm hover:shadow-md focus:ring-blue-500',
        'secondary' => 'bg-gray-200 text-gray-800 hover:bg-gray-300 shadow-sm focus:ring-gray-500',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 shadow-sm hover:shadow-md focus:ring-red-500',
        'success' => 'bg-green-600 text-white hover:bg-green-700 shadow-sm hover:shadow-md focus:ring-green-500',
        'warning' => 'bg-yellow-600 text-white hover:bg-yellow-700 shadow-sm hover:shadow-md focus:ring-yellow-500',
        'outline' => 'border border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-gray-500',
    ];
    
    return $variants[$variant] ?? $variants['primary'];
}
@endphp
