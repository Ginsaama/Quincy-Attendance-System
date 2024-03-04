<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'monday',
        'monday_in',
        'monday_out',
        'tuesday',
        'tuesday_in',
        'tuesday_out',
        'wednesday',
        'wednesday_in',
        'wednesday_out',
        'thursday',
        'thursday_in',
        'thursday_out',
        'friday',
        'friday_in',
        'friday_out',
        'saturday',
        'saturday_in',
        'saturday_out',
        'sunday',
        'sunday_in',
        'sunday_out',
    ];

    // One to one relationship with merchandiser table
    public function merchandiser()
    {
        return $this->belongsTo(Merchandiser::class, 'merchandisers_id');
    }
    // public function dailies()
    // {
    //     return $this->hasMany(Daily::class);
    // }
}
