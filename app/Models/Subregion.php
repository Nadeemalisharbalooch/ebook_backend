<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subregion extends Model
{
    protected $fillable = ['name', 'translations', 'region_id', 'flag', 'wikiDataId'];


    protected $casts = [
        'translations' => 'array', // If stored as JSON
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function countries()
    {
        return $this->hasMany(Country::class);
    }
}
