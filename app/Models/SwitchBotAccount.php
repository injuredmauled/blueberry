<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SwitchBotAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'token', 'secret',
    ];

    protected $hidden = [
        'secret'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
