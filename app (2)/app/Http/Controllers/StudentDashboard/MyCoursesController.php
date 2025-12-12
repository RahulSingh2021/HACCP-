<?php

namespace App\Http\Controllers\StudentDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyCoursesController extends Controller
{
   public function index(){
    return view('StudentDashboard.my_courses.main');
   }
}
