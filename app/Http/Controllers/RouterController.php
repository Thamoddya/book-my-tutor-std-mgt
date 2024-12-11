<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Payment;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
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
        return view('pages.protected.index', compact([
            'batchCount',
            'batchCountThisMonth'
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
        return view('pages.protected.payment',compact([
            'payments'
        ]));
    }
}
