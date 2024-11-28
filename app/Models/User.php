<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'department_id',
        'section_id',
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'street',
        'house_number',
        'zip_code',
        'city',
        'contract_type',
        'contract_hours',
        'hire_date',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    // all the relationships
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function register()
    {
        return $this->hasOne(Register::class);
    }

    public function permissions()
    {
        return $this->roles()->permissions();
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // other methods
    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

}
