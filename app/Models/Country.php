<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'name',
        'iso3',
        'numeric_code',
        'iso2',
    ];

    public $timestamps = false;

    // Relationships

    public function regions()
    {
        return $this->hasMany(Region::class);
    }
}
