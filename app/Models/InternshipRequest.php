<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipRequest extends Model
{
    protected $fillable = [
        'student_id',
        'company_name',
        'company_address',
        'company_phone',
        'supervisor_name',
        'supervisor_phone',
        'description',
        'skills',
        'start_date',
        'end_date',
        'status',
        'admin_notes',
        'reviewed_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}