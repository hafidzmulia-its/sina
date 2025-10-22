<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class History extends Model
{
    use HasFactory;

    protected $table = 'histories';
    
    protected $fillable = [
        'user_username',
        'buku_id',
        'progress',
        'target',
        'tanggal_record',
    ];

    protected $casts = [
        'tanggal_record' => 'date',
        'progress' => 'integer',
        'target' => 'integer',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_username', 'username');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    // Scopes
    public function scopeByUser(Builder $query, string $username): Builder
    {
        return $query->where('user_username', $username);
    }

    public function scopeByBuku(Builder $query, int $bukuId): Builder
    {
        return $query->where('buku_id', $bukuId);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->whereColumn('progress', '>=', 'target');
    }

    public function scopeInProgress(Builder $query): Builder
    {
        return $query->whereColumn('progress', '<', 'target');
    }

    public function scopeByDateRange(Builder $query, ?string $startDate, ?string $endDate): Builder
    {
        return $query->when($startDate, function ($query, $startDate) {
            return $query->where('tanggal_record', '>=', $startDate);
        })->when($endDate, function ($query, $endDate) {
            return $query->where('tanggal_record', '<=', $endDate);
        });
    }

    public function scopeRecentActivity(Builder $query, int $days = 30): Builder
    {
        return $query->where('tanggal_record', '>=', now()->subDays($days));
    }

    // Helper methods
    public function getProgressPercentage(): float
    {
        if ($this->target <= 0) {
            return 0;
        }
        
        return min(($this->progress / $this->target) * 100, 100);
    }

    public function isCompleted(): bool
    {
        return $this->progress >= $this->target;
    }

    public function getRemainingTarget(): int
    {
        return max($this->target - $this->progress, 0);
    }
}