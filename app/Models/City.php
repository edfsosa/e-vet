<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name',
        'population'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function neighborhoods(): HasMany
    {
        return $this->hasMany(Neighborhood::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function owners(): HasMany
    {
        return $this->hasMany(Owner::class);
    }
}
