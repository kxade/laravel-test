<?php

namespace App\DataTransferObjects;

use App\Http\Requests\App\FilterPostsRequest;

class FilterPostsDTO
{
    public function __construct(
        public ?string $fromDate,
        public ?string $toDate,
        public ?string $search,
        public ?string $tag,
    )
    {
    }

    public static function fromAppRequest(FilterPostsRequest $request)
    {
        return new self(
            search: $request->validated('search'),
            fromDate: $request->validated('from_date'),
            toDate: $request->validated('to_date'),
            tag: $request->validated('tag'),
        );
    }
}