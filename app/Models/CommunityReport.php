<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityReport extends Model
{
    protected $fillable = ['reporter_id', 'reason', 'details', 'status'];

    public function reporter()
    {
        return $this->belongsTo(User::class);
    }

    public function reportable()
    {
        return $this->morphTo();
    }
}
