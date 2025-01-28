<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Classes;
use App\Models\Payment;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use App\Models\UserLog;


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

        $paymentsLastSixMonths = Payment::selectRaw('SUM(amount) as total, MONTHNAME(MIN(created_at)) as month_name')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get();

        $students = Student::all();

        return view('pages.protected.index', compact([
            'batchCount',
            'batchCountThisMonth',
            'registeredStudentsInThisMonth',
            'lastTenPayments',
            'lastRegisteredStudents',
            'paymentsLastFiveMonths',
            'studentCountLastFiveMonths',
            'paymentsLastSixMonths',
            'students'
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
        $newRegistrations = User::role('management_officer')->where('created_at', '>=', now()->subMonth())->count();
        $officerStudentData = $managementOfficers->map(function ($officer) {
            return [
                'name' => $officer->name,
                'total_students' => $officer->getAddedStudentCount(),
            ];
        });
        return view('pages.protected.management', compact([
            'managementOfficers',
            'newRegistrations',
            'officerStudentData'
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

        $classes = Classes::all();

        return view('pages.protected.payment', compact([
            'payments',
            'classes'
        ]));
    }

    public function schools()
    {
        $schools = School::all();
        return view('pages.protected.schools', compact([
            'schools'
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
        // Group payments by month and calculate totals
        $monthlyTotals = Payment::whereYear('created_at', now()->year)
            ->where('status', 'paid')
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => \Carbon\Carbon::create()->month($item->month)->format('F'),
                    'total' => $item->total,
                ];
            });

        $payments = Payment::all();

        return view('pages.protected.PaymentReports', compact([
            'payments',
            'monthlyTotals',
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

    public function classes()
    {
        $classes = Classes::with('payments')->get();

        // Map data for the chart
        $classesForChart = $classes->map(function ($class) {
            $totalAmount = $class->payments
                ->where('created_at', '>=', now()->startOfMonth())
                ->where('status', 'paid') // Include only paid payments
                ->sum('amount');

            return [
                'name' => $class->name,
                'totalAmount' => $totalAmount,
            ];
        });

        return view('pages.protected.classes', compact('classes', 'classesForChart'));
    }

    public function classSchedule()
    {
        $classes = Classes::all();
        return view('pages.protected.ClassSchedule', compact(['classes']));
    }
}
