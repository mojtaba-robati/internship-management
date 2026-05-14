<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'national_code', 'phone', 
        'email', 'address', 'status', 'user_id', 'password'
    ];
    
    protected $hidden = ['password'];
    
    public function students()
    {
        return $this->belongsToMany(Student::class, 'mentor_student')
                    ->withPivot('internship_request_id', 'status', 'notes')
                    ->withTimestamps();
    }
    
    public function internshipRequests()
    {
        return $this->belongsToMany(InternshipRequest::class, 'mentor_student')
                    ->withPivot('student_id', 'status', 'notes')
                    ->withTimestamps();
    }
}