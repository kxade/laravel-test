<?php
namespace App\DTO;

use App\Enums\PostSource;
use App\Http\Requests\Posts\PostRequest as PostRequest;

readonly class PostDTO
{
    public function __construct(
        public string $title,
        public string $content,
        public ?string $published_at,
        public ?bool $published,
        public ?int $category_id,
        public PostSource $source,
    ) 
    {
    }

    private static function fromRequest(PostRequest $request, PostSource $source): self
    {
        return new self(
            title: $request->validated('title'),
            content: $request->validated('content'),
            published_at: $request->validated('published_at'),
            published: $request->validated('published'),
            category_id: $request->validated('category_id'),
            source: $source,
        );
    }

    public static function fromAppRequest(PostRequest $request): self
    {
        return self::fromRequest($request, PostSource::App);
    }

    public static function fromApiRequest(PostRequest $request): self
    {
        return self::fromRequest($request, PostSource::Api);
    }
}
