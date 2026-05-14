<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\InternshipRequest;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    private function toJalali($date)
    {
        if (!$date) return '-';
        $timestamp = strtotime($date);
        $year = date('Y', $timestamp);
        $month = date('m', $timestamp);
        $day = date('d', $timestamp);
        
        if ($month >= 3 && $month <= 12) {
            $jy = $year - 621;
            $jm = $month - 3;
        } else {
            $jy = $year - 622;
            $jm = $month + 9;
        }
        if ($jm > 12) { $jm -= 12; $jy++; }
        return $jy . '/' . str_pad($jm, 2, '0', STR_PAD_LEFT) . '/' . str_pad($day, 2, '0', STR_PAD_LEFT);
    }
    
    public function index()
    {
        $studentId = session('student_id');
        $internshipRequest = InternshipRequest::where('student_id', $studentId)->where('status', 'approved')->first();
        if (!$internshipRequest) {
            return redirect()->route('student.dashboard')->with('error', 'هنوز درخواست کارآموزی شما تایید نشده است.');
        }
        $attendance = Attendance::where('student_id', $studentId)->where('internship_request_id', $internshipRequest->id)->first();
        if (!$attendance) {
            $days = [];
            $startDate = now();
            for ($i = 1; $i <= 40; $i++) {
                $date = $startDate->copy()->addDays($i - 1);
                $days[$i] = [
                    'row_number' => $i,
                    'date' => $date->format('Y-m-d'),
                    'date_fa' => $this->toJalali($date),
                    'check_in' => null,
                    'check_out' => null,
                    'status' => 'pending',
                    'mentor_note' => null,
                    'approved_at' => null,
                ];
            }
            $attendance = Attendance::create(['student_id' => $studentId, 'internship_request_id' => $internshipRequest->id, 'days' => $days]);
        }
        $days = $attendance->days ?? [];
        foreach ($days as $row => &$day) {
            if (!isset($day['date_fa']) && isset($day['date'])) {
                $day['date_fa'] = $this->toJalali($day['date']);
            }
        }
        return view('student.attendance.index', compact('days', 'internshipRequest', 'attendance'));
    }
    
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        if ($attendance->student_id != session('student_id')) {
            return response()->json(['success' => false, 'message' => 'شما به این رکورد دسترسی ندارید.']);
        }
        $request->validate([
            'row' => 'required|integer|between:1,40',
            'date' => 'nullable|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
        ]);
        $days = $attendance->days;
        $row = $request->row;
        if (!isset($days[$row])) {
            return response()->json(['success' => false, 'message' => 'ردیف مورد نظر یافت نشد.']);
        }
        if ($days[$row]['status'] != 'pending') {
            return response()->json(['success' => false, 'message' => 'این روز قبلاً تایید شده و قابل ویرایش نیست.']);
        }
        $days[$row]['date'] = $request->date ?? $days[$row]['date'];
        $days[$row]['date_fa'] = $request->date ? $this->toJalali($request->date) : $days[$row]['date_fa'];
        $days[$row]['check_in'] = $request->check_in;
        $days[$row]['check_out'] = $request->check_out;
        $attendance->days = $days;
        $attendance->save();
        return response()->json(['success' => true]);
    }
}