@props(['members' => [], 'columns' => 4, 'id' => null])

<section @if($id) id="{{ $id }}" @endif class="py-16 lg:py-24 scroll-mt-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if (isset($heading))
            <div class="max-w-2xl">
                {{ $heading }}
            </div>
        @endif
        <div class="mt-12 grid gap-8 sm:grid-cols-2 {{ $columns === 4 ? 'lg:grid-cols-4' : 'lg:grid-cols-3' }}">
            @foreach ($members as $member)
                <article class="group text-center sm:text-left">
                    <div class="photo-frame mx-auto aspect-square max-w-[220px] sm:mx-0">
                        <img
                            src="{{ asset($member['photo']) }}"
                            alt="{{ $member['name'] }}, {{ $member['title'] }}"
                            class="img-cover object-top transition duration-500 group-hover:scale-105"
                            width="220"
                            height="220"
                            loading="lazy"
                        >
                    </div>
                    <h3 class="mt-5 font-display text-lg font-semibold text-heading">{{ $member['name'] }}</h3>
                    <p class="text-sm font-medium text-brand-400">{{ $member['title'] }}</p>
                    <p class="mt-2 text-sm leading-relaxed text-muted">{{ $member['bio'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
