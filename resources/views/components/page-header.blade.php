<!-- Page Header Component -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center space-x-3">
                @if($icon ?? null)
                <i class="fas {{ $icon }} text-blue-600"></i>
                @endif
                <span>{{ $title }}</span>
            </h1>
            @if($subtitle ?? null)
            <p class="text-gray-600 mt-2">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="flex items-center space-x-3">
            {{ $actions ?? '' }}
        </div>
    </div>
</div>

@props(['title', 'subtitle' => null, 'icon' => null, 'actions' => null])
