<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use App\Models\LastNews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'seo' => 'array',
        'meta' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function lastnews()
    {
        return $this->hasMany(LastNews::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
        // return $this->belongsToMany(Tag::class)->withTimestamps()->onDelete('cascade');
    }
}
