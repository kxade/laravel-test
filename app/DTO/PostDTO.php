<?php

namespace App\DTO;

use App\Enums\PostSource;
use App\Http\Requests\Posts\{PostRequest, FilterPostsRequest};

readonly class PostDTO
{
    public function __construct(
        public ?string $title,
        public ?string $content,
        public ?string $published_at,
        public ?bool $published,
        public ?int $category_id,
        public ?PostSource $source,
        public ?string $fromDate,
        public ?string $toDate,
        public ?string $search,
        public ?string $tag,
    ) {
    }

    private static function postRequest(PostRequest $request, PostSource $source): self
    {
        return new self(
            title: $request->validated('title'),
            content: $request->validated('content'),
            published_at: $request->validated('published_at'),
            published: $request->validated('published'),
            category_id: $request->validated('category_id'),
            source: $source,
            search: null,
            fromDate: null,
            toDate: null,
            tag: null,
        );
    }

    public static function fromAppRequest(PostRequest $request): self
    {
        return self::postRequest($request, PostSource::App);
    }

    public static function fromApiRequest(PostRequest $request): self
    {
        return self::postRequest($request, PostSource::Api);
    }

    public static function filterPostsRequest(FilterPostsRequest $request)
    {
        return new self(
            search: $request->validated('search'),
            fromDate: $request->validated('from_date'),
            toDate: $request->validated('to_date'),
            tag: $request->validated('tag'),
            title: null,
            content: null,
            published_at: null,
            published: null,
            category_id: null,
            source: null,
        );
    }
}
