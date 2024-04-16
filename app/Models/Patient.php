<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return Carbon::now()->diffInYears(Carbon::parse($this->date_of_birth));
    }

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }

    public function scopeFilter($query, $context): Builder
    {
        return $query->whereAny(['firstname', 'middlename', 'lastname', 'name_extension', 'contact_no', 'username'], 'LIKE', '%' . $context . '%');
    }
}