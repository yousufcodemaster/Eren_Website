<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'panel_password',
        'role',
        'is_reseller',
        'max_clients',
        'premium_type',
        'discord_id',
        'discord_username',
        'discord_avatar',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'panel_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'panel_password' => 'hashed',
        'is_reseller' => 'boolean',
    ];

    /**
     * Get the user's role.
     */
    protected function role(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value,
        );
    }

    /**
     * Check if user is premium.
     */
    public function isPremium(): bool
    {
        return $this->premium_type !== null;
    }

    /**
     * Check if user has a specific premium type.
     */
    public function isPremiumType($type): bool
    {
        return $this->premium_type === $type;
    }

    /**
     * Get all clients for this reseller.
     */
    public function clients()
    {
        return $this->hasMany(ResellerClient::class, 'reseller_id');
    }

    /**
     * Determine if the user can add more clients.
     */
    public function canAddMoreClients()
    {
        if (!$this->is_reseller) {
            return false;
        }

        $count = $this->clients()->count();
        
        return $count < $this->max_clients;
    }

    /**
     * Get the number of remaining client slots.
     */
    public function remainingClientSlots()
    {
        if (!$this->is_reseller) {
            return 0;
        }
        
        $count = $this->clients()->count();
        
        return $this->max_clients - $count;
    }

    /**
     * Get the user's panel credentials.
     */
    public function panelCredential()
    {
        return $this->hasOne(PanelCredential::class);
    }

    /**
     * Get the reseller's panel credentials for their clients.
     */
    public function resellerPanelCredentials()
    {
        return $this->hasMany(ResellerPanelCredential::class, 'reseller_id');
    }
}
