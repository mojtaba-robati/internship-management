<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'national_code',
        'major',
        'grade',
        'password',
        'is_active',
        'must_change_password'
    ];

    public function internshipRequests()
{
    return $this->hasMany(InternshipRequest::class);
}

    
}

