<?php

namespace App\Http\Controllers\StudentDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrainingCourseController extends Controller
{
    public function index(){
        return view('StudentDashboard.training_course.main');
    }
}
