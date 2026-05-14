<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorStudent extends Model
{
    protected $table = 'mentor_student';
    
    protected $fillable = [
        'mentor_id', 'student_id', 'internship_request_id', 'status', 'notes'
    ];
    
    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }
    
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    
    public function internshipRequest()
    {
        return $this->belongsTo(InternshipRequest::class);
    }
}