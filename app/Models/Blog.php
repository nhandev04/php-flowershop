<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the image path attribute.
     */
    protected function getImageAttribute($value)
    {
        if ($value && !str_starts_with($value, 'blog/') && file_exists(storage_path('app/public/blog/' . $value))) {
            return 'blog/' . $value;
        }
        return $value;
    }
}
