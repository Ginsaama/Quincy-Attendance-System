<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchandiser extends Model
{
    use HasFactory;
    protected $fillable = ['call_sign', 'name', 'status'];

    // One to one relationship with the Schedule table
    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'merchandisers_id');
    }
    public function dailies()
    {
        return $this->hasMany(Daily::class, 'merchandisers_id');
    }

    // Get absents
    public function getTotalAbsentAttribute()
    {
        return $this->dailies()
            ->where('status', 'absent')
            ->where('excused', 1)
            ->count()
            + $this->dailies()
            ->where('status', 'absent')
            ->where('excused', 0)
            ->count()
            - $this->dailies()
            ->where('status', 'absent')
            ->whereNotNull('offset')
            ->count();
    }
    public function getTotalScheduke()
    {
        return $this->dailies()->count();
    }
    public function getTotalDutyAttribute()
    {
        return $this->dailies()->count() - $this->getTotalAbsentAttribute();
    }

    public function getTotalWithExcuseAttribute()
    {
        return $this->dailies()->where('status', 'absent')->where('excused', 1)->count();
    }

    public function getTotalWithoutExcuseAttribute()
    {
        return $this->dailies()->where('status', 'absent')->where('excused', 0)->count();
    }

    public function getTotalOffsetAttribute()
    {
        return $this->dailies()->where('status', 'absent')->whereNotNull('offset')->count();
    }
}
