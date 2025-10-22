<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'parent_user_username',
        'username',
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
            'role' => 'string',
        ];
    }

    /**
     * Get the name of the unique identifier for the user.
     * This should remain 'id' - the primary key
     */
    public function getAuthIdentifierName(): string
    {
        return 'id'; // Keep this as 'id' (primary key)
    }

    /**
     * Get the name of the field to use for authentication
     * This tells Laravel to use username for login instead of email
     */
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    // Remove the username() method - it's not needed

    // ...rest of your existing relationships and methods...
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_user_username', 'username');
    }

    public function children(): HasMany
    {
        return $this->hasMany(User::class, 'parent_user_username', 'username');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(History::class, 'user_username', 'username');
    }

    // Scopes for filtering
    public function scopeByRole(Builder $query, string $role): Builder
    {
        return $query->where('role', $role);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            });
        });
    }

    public function scopeWithParent(Builder $query): Builder
    {
        return $query->with('parent');
    }

    // Helper methods
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOrangTua(): bool
    {
        return $this->role === 'orangtua';
    }

    public function isAnak(): bool
    {
        return $this->role === 'anak';
    }

    // Get full name with username
    public function getFullNameAttribute(): string
    {
        return "{$this->name} ({$this->username})";
    }
}