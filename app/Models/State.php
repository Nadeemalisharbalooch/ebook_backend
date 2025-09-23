<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';

    protected $fillable = [
        'region_id',
        'name',
        // add other fields
    ];

    public $timestamps = false;

    // Relationships

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function subregions()
    {
        return $this->hasMany(Subregion::class);
    }
}
