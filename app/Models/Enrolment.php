<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Career;
use App\Models\Term;
use App\Models\User;
use App\Models\Enrolment_uf;
use App\Models\Req_enrol;


class Enrolment extends Model
{
    use HasFactory;

    protected $fillable = ['dni', 'user_id', 'term_id', 
    'career_id', 'state','address','city',
    'postal_code','phone_number','emergency_number',
    'tutor_1','tutor_1_dni','tutor_2','tutor_2_dni'];

    public function careers()
    {
        return $this->belongsTo(Career::class);
    }

    public function terms()
    {
        return $this->belongsTo(Term::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function enrolment_ufs()
    {
        return $this->hasMany(Enrolment_uf::class);
    }

    public function req_enrols()
    {
        return $this->hasMany(Req_enrol::class);
    }
}
