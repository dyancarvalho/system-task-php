<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'responsible',
        'category',
        'status',
        'start_date',
        'end_date',
        'duration'
    ];
}
