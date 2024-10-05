<?php

namespace App\DataTransferObjects;

use App\Enums\PostSource;
use App\Http\Requests\App\PostRequest as AppPostRequest;
use App\Http\Requests\Api\PostRequest as ApiPostRequest;

readonly class PostDTO
{
    public function __construct(
        public string $title,
        public string $content,
        public ?string $published_at,
        public bool $published,
        public ?int $category_id,
        public PostSource $source,
    )
    {

    }
    
    public static function fromAppRequest(AppPostRequest $request)
    {
        return new self(
            title: $request->validated('title'),
            content: $request->validated('content'),
            published_at: $request->validated('published_at'),
            published: $request->validated('published'),
            category_id: $request->validated('category_id'),
            source: PostSource::App,
        );
    }

    public static function fromApiRequest(ApiPostRequest $request)
    {
        return new self(
            title: $request->validated('title'),
            content: $request->validated('content'),
            published_at: $request->validated('published_at'),
            published: $request->validated('published'),
            category_id: $request->validated('category_id'),
            source: PostSource::App,
        );
    }
}