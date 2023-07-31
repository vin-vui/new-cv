<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'client',
        'job',
        'logo',
        'url',
        'github',
        'description',
        'start_date',
        'end_date',
        'illustration_1',
        'illustration_2',
        'illustration_3',
        'illustration_4',
        'status',
        'is_printable',
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }
}
