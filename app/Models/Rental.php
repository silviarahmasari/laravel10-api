<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rental extends Model
{
    use HasFactory;
    protected $table = 'rental';
    protected $fillable = [
        'rental_date',
        'return_date',
        'inventory_id'
    ];
    protected $hidden = [
        'customer_id',
        'rental_id',
        'staff_id',
        'last_update'
    ];

     /**
     * Get the user that owns the Store
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

     /**
     * Get the user that owns the Store
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'inventory_id');
    }

    /**
     * Get the user that owns the Store
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class, 'film_id', 'film_id');
    }

    /**
     * Get all of the comments for the Rental
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payment(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
