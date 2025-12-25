<!-- Form Input Component -->
<input 
    {{ $attributes->merge([
        'class' => 'w-full px-4 py-2 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition',
        'type' => 'text'
    ]) }}
/>

@if($errors->has($name ?? ''))
<p class="text-xs text-red-500 mt-1">{{ $errors->first($name ?? '') }}</p>
@endif

@props(['name' => null])
