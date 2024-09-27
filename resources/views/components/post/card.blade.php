<x-card>
    <x-card-body>
        <h2 class="h5">
            <a href="{{ route('blog.show', $post->id) }}">
                {{ $post->title }}
            </a>
        </h2>
        {{ $post->id}}
        <div class="small text-muted">
            <span>{{ $post->published_at->format('d.m.Y h:i:s') }} by</span>
            <a href="">{{ $post->user->name }}</a>
        </div>
    </x-card-body>
</x-card>