<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationMessage extends Model
{
    protected $fillable = ['user_id', 'admin_id', 'sender', 'message', 'read_at'];

    public static function expireInactiveConversations(): array
    {
        $inactiveUserIds = static::query()
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('MAX(updated_at) <= ?', [now()->subMinutes(10)])
            ->pluck('user_id')
            ->all();

        if ($inactiveUserIds !== []) {
            static::whereIn('user_id', $inactiveUserIds)->delete();
        }

        return $inactiveUserIds;
    }

    public static function touchConversation(int $userId): void
    {
        $latestMessage = static::where('user_id', $userId)->latest('id')->first(['id', 'updated_at']);
        if ($latestMessage && $latestMessage->updated_at->lte(now()->subSeconds(30))) {
            $latestMessage->forceFill(['updated_at' => now()])->save();
        }
    }

    protected function casts(): array
    {
        return ['read_at' => 'datetime'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}