<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'internship_request_id',
        'days',
    ];

    protected $casts = [
        'days' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function internshipRequest()
    {
        return $this->belongsTo(InternshipRequest::class);
    }
}