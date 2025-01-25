<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SMSController;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function TestSMS(){
        $smsController = new SMSController();

        //Get all call_no from students table
        $students = \App\Models\Student::all();
        $phoneNumbers = [];
        foreach($students as $student){
            $phoneNumbers[] = $student->call_no;
        }

        //Send SMS to all students
        $response = $smsController->sendSms($phoneNumbers, 'Test to all students.');
        return response()->json($response);
    }
}
