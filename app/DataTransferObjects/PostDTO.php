<?php

namespace App\DataTransferObjects;

use App\Enums\PostSource;

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
}