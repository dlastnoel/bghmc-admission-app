<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'capacity'
    ];

    public function getVacantAttribute(): int
    {
        return (int)$this->capacity - ($this->admissions->whereNotNull('discharged_at'))->count();
    }

    public function getOccupiedAttribute(): int
    {
        $count = ($this->admissions->whereNull('discharged_at'))->count();

        return $count ? (int)$this->capacity - $count : 0;
    }

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }

    public function scopeFilter($query, $context): Builder
    {
        return $query->where('name', 'LIKE', '%' . $context . '%');
    }
}
