<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subregion extends Model
{
    protected $table = 'subregions';

    protected $fillable = [
        'state_id',
        'name',
        // add other fields
    ];

    public $timestamps = false;

    // Relationships

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
