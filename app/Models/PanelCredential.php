<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelCredential extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'username',
        'pass',
    ];

    /**
     * Get the user that owns the panel credentials.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
