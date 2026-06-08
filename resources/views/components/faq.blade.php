@props(['items' => []])

<section class="py-20" x-data="{ open: null }">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        <h2 class="section-heading text-center">Frequently asked questions</h2>
        <div class="mt-10 space-y-3">
            @foreach ($items as $index => $item)
                <div class="glass rounded-2xl overflow-hidden">
                    <button
                        type="button"
                        class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left text-sm font-semibold text-heading"
                        @click="open = open === {{ $index }} ? null : {{ $index }}"
                        :aria-expanded="open === {{ $index }}"
                    >
                        {{ $item['q'] }}
                        <svg class="h-5 w-5 shrink-0 text-brand-400 transition" :class="open === {{ $index }} && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open === {{ $index }}" x-cloak class="border-t border-subtle-5 px-5 pb-4 text-sm text-muted">
                        {{ $item['a'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
