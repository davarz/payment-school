<!-- Alert Component -->
<div class="rounded-lg border p-4 {{ $getClass() }}" role="alert">
    <div class="flex items-start space-x-3">
        <i class="fas {{ $getIcon() }} text-lg flex-shrink-0 mt-0.5"></i>
        <div class="flex-1">
            @if($title ?? null)
            <h3 class="font-semibold mb-1">{{ $title }}</h3>
            @endif
            <p class="text-sm">{{ $slot }}</p>
        </div>
        @if($closable ?? false)
        <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-lg opacity-70 hover:opacity-100 transition">
            &times;
        </button>
        @endif
    </div>
</div>

@props(['type' => 'info', 'title' => null, 'closable' => false])

@php
function getClass() {
    $type = $type ?? 'info';
    
    $types = [
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'danger' => 'bg-red-50 border-red-200 text-red-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    ];
    
    return $types[$type] ?? $types['info'];
}

function getIcon() {
    $type = $type ?? 'info';
    
    $icons = [
        'success' => 'fa-check-circle',
        'warning' => 'fa-exclamation-triangle',
        'danger' => 'fa-times-circle',
        'info' => 'fa-info-circle',
    ];
    
    return $icons[$type] ?? $icons['info'];
}
@endphp
