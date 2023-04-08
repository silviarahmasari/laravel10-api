<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';
    protected $fillable = [
        'address_id',
        'address AS address_name',
        'address2',
        'dsitrict',
        'city_id',
        'postal_code',
        'phone'
    ];
    protected $hidden = [
      'last_update'
    ];

    /**
     * Get all of the comments for the Address
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function store(): HasMany
    {
        return $this->hasMany(Store::class);
    }
}
