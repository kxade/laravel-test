<div class="border-bottom mb-3">
    @isset($link)
        <div class="mb-2">
            {{ $link}}
        </div>
    @endisset
    <div class="d-flex justify-content-between">
        <div class="">
            <h1 class="h2 mb-3">
                {{ $slot }}
            </h1>
        </div>
        @isset($right)
            <div class="">
                {{ $right }}
            </div>
        @endisset
    </div>
</div>