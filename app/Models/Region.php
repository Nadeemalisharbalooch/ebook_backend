<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'translations', 'flag', 'wikiDataId'];

    protected $casts = [
        'translations' => 'array', // If stored as JSON
    ];

    public function subregions()
    {
        return $this->hasMany(Subregion::class);
    }

    public function countries()
    {
        return $this->hasMany(Country::class);
    }
}
