<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    use HasFactory;

    protected $table = 'Dailies';
    protected $fillable = ['date', 'status', 'excused', 'offset'];

    public function merchandiser()
    {
        return $this->belongsTo(Merchandiser::class);
    }
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
