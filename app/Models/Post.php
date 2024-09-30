<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\PostSource;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [

        'title',
        'content',
        'published',
        'published_at',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
        'source' => PostSource::class,
    ];


    public function isPublished(): bool {
        return $this->published &&  $this->published_at; 
    }

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }
}
