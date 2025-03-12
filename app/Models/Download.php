<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'url',
        'version',
        'type',
        'release_notes',
    ];

    /**
     * Get formatted created date.
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y');
    }
} 