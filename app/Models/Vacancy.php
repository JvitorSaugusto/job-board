<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use Hasfactory;

    protected $fillable = [
        'id',
        'title',
        'company',
        'type',
        'requirements',
        'is_open',
    ];
}
