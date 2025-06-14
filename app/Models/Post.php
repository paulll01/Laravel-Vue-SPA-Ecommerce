<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * Mass assignment protection.
     * Either list explicitly ($fillable) or guard fields ($guarded).
     */
    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'content',
        'image',
        'status',
        'view_count',
        'comment_count',
        'like_count',
        'dislike_count',
        'share_count',
    ];
    // Alternatively, use guarded:
    // protected $guarded = ['id']; 
    // :contentReference[oaicite:1]{index=1}

    /**
     * Ensure casting for booleans and integers.
     */
    protected $casts = [
        'status'        => 'boolean',
        'view_count'    => 'integer',
        'comment_count' => 'integer',
        'like_count'    => 'integer',
        'dislike_count' => 'integer',
        'share_count'   => 'integer',
    ];

    /**
     * Use UUID slug for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Generate slug or UUID before saving (if needed).
     * Optionally, use model events or traits here.
     */
}
