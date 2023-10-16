<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CommunityLink extends Model

{
    protected $fillable = [
        'channel_id',
        'title',
        'link',
        'user_id',
        'approved',

    ];
    use HasFactory;
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
    public static function hasAlreadyBeenSubmitted($link)
    {
        if ($existing = static::where('link', $link)->first()) {
            if (Auth::user()->isTrusted()) {
                $existing->touch();
                $existing->save();
            }
            return true;
        }
        return false;
    }
}
