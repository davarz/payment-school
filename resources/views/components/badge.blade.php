@props(['type' => 'info', 'icon' => null])

@php
$types = [
    'success' => 'bg-green-100 text-green-800',
    'warning' => 'bg-yellow-100 text-yellow-800',
    'danger' => 'bg-red-100 text-red-800',
    'info' => 'bg-blue-100 text-blue-800',
    'secondary' => 'bg-gray-100 text-gray-800',
    'primary' => 'bg-blue-100 text-blue-800',
];

$badgeClass = $types[$type] ?? $types['info'];
@endphp

<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $badgeClass }}">
    @if($icon ?? null)
    <i class="fas {{ $icon }} mr-1.5"></i>
    @endif
    {{ $slot }}
</span>
