<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    // protected $table = 'posts';
    protected $fillable = [
        'title',
        'body',
        'image',
        'user_id',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->belongsToMany(User::class, 'post_likes')->withTimestamps();
    }

    public function scopeActive($query){
        return $query->where('status', 'active');
    }

    public function scopeInactive($query){
        return $query->where('status', 'inactive');
    }
}
