@props([
    'showSuccess' => true,
    'showError' => true,
    'showValidation' => true,
])

<div {{ $attributes->merge(['class' => 'space-y-4']) }}>
    @if ($showSuccess && session('success'))
        <div class="rounded-xl border border-brand-500/30 bg-brand-500/10 px-4 py-3 text-sm text-brand-800 dark:text-brand-200" role="status">
            {{ session('success') }}
        </div>
    @endif

    @if ($showError && session('error'))
        <div class="rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-700 dark:text-red-300" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @php
        $errorBag = session('errors');
    @endphp

    @if ($showValidation && $errorBag && $errorBag->any())
        <div class="rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-700 dark:text-red-300" role="alert">
            <p class="font-semibold">Please fix the following:</p>
            <ul class="mt-2 list-inside list-disc space-y-1">
                @foreach ($errorBag->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
