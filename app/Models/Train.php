<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Train extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'registration_number',
        'capacity',
        'status',
    ];

    /**
     * Get the wagons for the train.
     */
    public function wagons(): HasMany
    {
        return $this->hasMany(Wagon::class);
    }
}
