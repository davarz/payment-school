<!-- Form Group Component -->
<div class="mb-4">
    @if($label ?? null)
    <label for="{{ $name ?? '' }}" class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
        @if($required ?? false)
        <span class="text-red-500">*</span>
        @endif
    </label>
    @endif
    
    {{ $slot }}
    
    @if($hint ?? null)
    <p class="text-xs text-gray-500 mt-1">{{ $hint }}</p>
    @endif
    
    @error($name ?? '')
    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>

@props(['label' => null, 'name' => null, 'required' => false, 'hint' => null])
