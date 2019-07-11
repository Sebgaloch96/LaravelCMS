<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'title', 'description', 'content', 'image', 'published_at', 'category_id'
    ];

    /**
     * Delete post image from storage
     * 
     * @return void
     */
    public function deleteImage()
    {
        Storage::delete($this->image);
    }

    /**
     * Relationship to category
     * 
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship to tags
     * 
     * @return void
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    } 
    
    /**
     * Check if post has any tags associated with it
     * 
     * @return bool
     */
    public function hasTag($tagId)
    {
        return in_array($tagId, $this->tags->pluck('id')->toArray());
    }
}
