@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-muted-700']) }}>
    {{ $value ?? $slot }}
</label>