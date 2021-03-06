<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'role',
        'mobile_no',
        'address',
        'degree',
        'joining_date',
        'doctor_specialist',
        'password_ref',
        'age'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activity_log(){
        return $this->hasMany(ActiveLog::class, 'user_id', 'id');
    }

    public function educationQualification(){
        return $this->hasOne(EducationalQualification::class, 'id', 'degree');
    }

    public function CollageName(){
        return $this->hasOne(MedicalCollege::class, 'id', 'institute_name');
    }

    public function Specialist(){
        return $this->hasOne(SpecialistArea::class, 'id', 'doctor_specialist');
    }
}
