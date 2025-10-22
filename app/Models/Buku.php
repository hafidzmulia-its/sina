<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'jenis',
        'judul',
        'cover',
        'sinopsis',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function histories(): HasMany
    {
        return $this->hasMany(History::class, 'buku_id');
    }

    // Scopes for filtering and searching
    public function scopeByJenis(Builder $query, ?string $jenis): Builder
    {
        return $query->when($jenis, function ($query, $jenis) {
            return $query->where('jenis', $jenis);
        });
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('judul', 'like', "%{$search}%")
                      ->orWhere('jenis', 'like', "%{$search}%")
                      ->orWhere('sinopsis', 'like', "%{$search}%");
            });
        });
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount('histories')
                    ->orderBy('histories_count', 'desc');
    }

    public function scopeSortBy(Builder $query, ?string $sortBy, string $direction = 'asc'): Builder
    {
        $allowedSorts = ['judul', 'jenis', 'created_at', 'updated_at'];
        
        if (in_array($sortBy, $allowedSorts)) {
            return $query->orderBy($sortBy, $direction);
        }
        
        return $query->orderBy('created_at', 'desc');
    }

    // Helper methods
    public function getJenisOptions(): array
    {
        return [
            'Fabel',
            'Cerita Rakyat', 
            'Dongeng',
        ];
    }

    public function getTotalReaders(): int
    {
        return $this->histories()->distinct('user_id')->count();
    }

    public function getAverageProgress(): float
    {
        return $this->histories()->avg('progress') ?? 0;
    }
    public function getFullNameAttribute(): string
    {
        return "{$this->name} ({$this->username})";
    }   

}