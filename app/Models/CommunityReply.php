<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityReply extends Model
{
    protected $fillable = ['thread_id', 'user_id', 'body', 'doctor_verified'];

    protected function casts(): array
    {
        return ['doctor_verified' => 'boolean'];
    }

    public function thread()
    {
        return $this->belongsTo(CommunityThread::class, 'thread_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reports()
    {
        return $this->morphMany(CommunityReport::class, 'reportable');
    }
}
