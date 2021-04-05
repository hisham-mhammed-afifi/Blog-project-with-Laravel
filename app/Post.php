<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'image', 'title', 'body','category_id', 'user_id'
    ];
    protected $table = 'posts';

    /**
     * delete post image from storage
     *
     * @return void
     */
    public function deleteImage()
    {
        Storage::disk('public')->delete($this->image);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function hasComments()
    {
        return $this->comments->pluck('id')->toArray();
    }

    public function scopeSearched($query)
    {
        $search = request()->query('search');
        if (!$search) {
            return $query;
        } else {
            return $query->where('title', 'LIKE', "%{$search}%");
        }
    }
}
