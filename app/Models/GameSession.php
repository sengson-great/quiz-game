<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\GameAnswer;

class GameSession extends Model
{
    protected $guarded = [];

    protected $casts = [
        'started_at'  => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(GameAnswer::class);
    }

    public function isFinished(): bool
    {
        return $this->finished_at !== null;
    }

    public function currentQuestionNumber(): int
    {
        return $this->correct_count + $this->wrong_count + $this->skipped_count + 1;
    }
}
