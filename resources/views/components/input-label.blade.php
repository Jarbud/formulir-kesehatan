@props(['value', 'required' => false])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-gray-700 mb-2']) }}>
    {{ $value ?? $slot }}
    @if($required)
        <span class="text-red-500 ml-1" aria-label="required">*</span>
    @endif
</label>
