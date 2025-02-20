<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Enrolment;
use App\Models\Record;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function hasRole($role)
    {
        $role = (array)$role;

        return in_array($this->role, $role);
    }

    public function enrolments()
    {
        return $this->belongsTo(Enrolment::class);
    }

    public function records()
    {
        return $this->belongsTo(Record::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'token',
        'firstname',
        'lastname1',
        'lastname2',
        'role',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
