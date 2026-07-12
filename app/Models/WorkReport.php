<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkReport extends Model
{
    protected $fillable = [
        'student_id',
        'internship_request_id',
        'mentor_id',
        'row_number',
        'report_date',
        'report_text',
        'attachments',
        'status',
        'mentor_feedback',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'report_date' => 'date',
        'attachments' => 'array',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
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