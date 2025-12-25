<!-- Stats Card Component -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow {{ $class ?? '' }}">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600 mb-1">{{ $label }}</p>
            <p class="text-2xl font-bold text-gray-900">{{ $value }}</p>
            @if($subtitle ?? null)
            <p class="text-xs text-gray-500 mt-2">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="p-3 bg-{{ $color ?? 'blue' }}-100 rounded-lg">
            <i class="fas {{ $icon ?? 'fa-chart-bar' }} text-{{ $color ?? 'blue' }}-600 text-2xl"></i>
        </div>
    </div>
</div>
