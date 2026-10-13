<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified_doctor' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function bookmarkedArticles()
    {
        return $this->belongsToMany(Article::class, 'article_bookmarks')->withTimestamps();
    }

    public function searchHistories()
    {
        return $this->hasMany(SearchHistory::class);
    }

    public function communityThreads()
    {
        return $this->hasMany(CommunityThread::class);
    }

    public function consultationMessages()
    {
        return $this->hasMany(ConsultationMessage::class);
    }
}
