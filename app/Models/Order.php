<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wagon_id',
        'order_number',
        'description',
        'status',
        'delivery_date',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the wagon that the order is attached to.
     */
    public function wagon(): BelongsTo
    {
        return $this->belongsTo(Wagon::class);
    }
}
