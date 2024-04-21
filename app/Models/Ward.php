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

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }

    public function scopeFilter($query, $context): Builder
    {
        return $query->where('name', 'LIKE', '%' . $context . '%');
    }
}
