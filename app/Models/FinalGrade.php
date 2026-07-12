<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalGrade extends Model
{
    protected $fillable = [
        'student_id',
        'internship_request_id',
        'mentor_id',
        'grade',
        'mentor_note',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function internshipRequest()
    {
        return $this->belongsTo(InternshipRequest::class);
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }
}