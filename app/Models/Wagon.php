<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wagon extends Model
{
    protected $table = 'wagons';

    use HasFactory;

    protected $fillable = [
        'van_id',
        'wagon_number',
        'capacity',
        'status',
    ];

    /**
     * Get the train that owns the wagon.
     */
    public function train(): BelongsTo
    {
        return $this->belongsTo(Train::class);
    }

    /**
     * Get the orders for the wagon.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
