@props([
    'name' => 'country',
    'id' => null,
    'value' => null,
    'required' => false,
    'label' => 'Country',
    'placeholder' => 'Select country',
])

@php
    $id = $id ?? $name;
    $countries = config('countries', []);
    $selected = strtoupper((string) old($name, $value ?? ''));
@endphp

<div>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <select
        name="{{ $name }}"
        id="{{ $id }}"
        @if ($required) required @endif
        {{ $attributes->class(['form-input', 'border-red-500' => $errors->has($name)]) }}
    >
        <option value="">{{ $placeholder }}</option>
        @foreach ($countries as $code => $countryName)
            <option value="{{ $code }}" @selected($selected === $code)>{{ $countryName }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
    @enderror
</div>
