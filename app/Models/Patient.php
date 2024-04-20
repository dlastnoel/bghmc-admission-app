<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'suffix',
        'date_of_birth',
        'address'
    ];

    public function getAgeAttribute(): float
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }

    public function scopeFilter($query, $context): Builder
    {
        return $query
            ->whereAny(['firstname', 'middlename', 'lastname', 'suffix'], 'LIKE', '%' . $context . '%')
            ->orWhere(DB::raw('CONCAT(firstname," ",middlename, " ", lastname)'), 'LIKE', '%' . $context . '%')
            ->orWhere(DB::raw('CONCAT(firstname," ",lastname)'), 'LIKE', '%' . $context . '%');
    }
}
