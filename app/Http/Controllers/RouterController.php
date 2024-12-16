<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Payment;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;

class RouterController extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            return $this->index();
        }

        return view('pages.auth.login');
    }

    public function index()
    {
        $batchCount = Batch::count();
        $batchCountThisMonth = Batch::whereMonth('created_at', now()->month)->count();
        $registeredStudentsInThisMonth = Student::whereMonth('created_at', now()->month)->count();
        $lastTenPayments = Payment::with('student')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        $lastRegisteredStudents = Student::orderBy('created_at', 'desc')->take(10)->get();

        $paymentsLastFiveMonths = Payment::selectRaw('SUM(amount) as total, MONTHNAME(MIN(paid_at)) as month_name')
            ->whereBetween('paid_at', [now()->subMonths(5), now()])
            ->groupByRaw('YEAR(paid_at), MONTH(paid_at)')
            ->orderByRaw('YEAR(paid_at), MONTH(paid_at)')
            ->get();
        $studentCountLastFiveMonths = Student::selectRaw('COUNT(id) as total, MONTHNAME(MIN(created_at)) as month_name')
            ->whereBetween('created_at', [now()->subMonths(5), now()])
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get();

        return view('pages.protected.index', compact([
            'batchCount',
            'batchCountThisMonth',
            'registeredStudentsInThisMonth',
            'lastTenPayments',
            'lastRegisteredStudents',
            'paymentsLastFiveMonths',
            'studentCountLastFiveMonths'
        ]));
    }


    public function batchManagement()
    {
        $batches = Batch::all();
        return view('pages.protected.batch', compact([
            'batches'
        ]));
    }

    public function managementOfficers()
    {
        $managementOfficers = User::role('management_officer')->get();
        return view('pages.protected.management', compact([
            'managementOfficers'
        ]));
    }

    public function students()
    {

        $students = Student::all();
        $batches = Batch::all();
        $schools = School::all();
        return view('pages.protected.students', compact([
            'students',
            'batches',
            'schools'
        ]));
    }

    public function payments()
    {
        $payments = Payment::with('student')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages.protected.payment', compact([
            'payments'
        ]));
    }

    public function studentReports()
    {
        $students = Student::all();
        return view('pages.protected.studentReports', compact([
            'students'
        ]));
    }

    public function PaymentReports()
    {
        $payments = Payment::all();
        return view('pages.protected.PaymentReports', compact([
            'payments'
        ]));
    }

    public function systemLog()
    {
        $logs = UserLog::all();
        return view('pages.protected.UserLog', compact([
            'logs'
        ]));
    }

    public function profile()
    {
        return view('pages.protected.Profile');
    }
}
