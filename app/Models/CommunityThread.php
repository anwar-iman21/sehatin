<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityThread extends Model
{
    protected $fillable = ['user_id', 'category', 'title', 'body', 'is_question', 'views'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(CommunityReply::class, 'thread_id');
    }

    public function reports()
    {
        return $this->morphMany(CommunityReport::class, 'reportable');
    }
}
