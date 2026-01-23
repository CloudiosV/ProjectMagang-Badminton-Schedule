<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements AuditableContract
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $table = "users";

    protected $fillable = [
        'nama',
        'email',
        'password',
    ];
    
    protected $auditInclude = [
        'nama',
        'email',
    ];

    protected $auditExclude = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the jadwals for the user.
     */
    public function jadwals(): HasMany  // Perhatikan: plural 'jadwals'
    {
        return $this->hasMany(Jadwal::class);
    }
}