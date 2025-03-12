<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResellerPanelCredential extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reseller_id',
        'username',
        'pass',
    ];

    /**
     * Get the reseller that owns these panel credentials.
     */
    public function reseller()
    {
        return $this->belongsTo(User::class, 'reseller_id');
    }
}
