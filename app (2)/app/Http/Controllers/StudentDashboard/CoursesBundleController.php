<?php

namespace App\Http\Controllers\StudentDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoursesBundleController extends Controller
{
   public function index(){
    return view('StudentDashboard.courses_bundle.main');
   }

   public function show(){
    return view('StudentDashboard.courses_bundle.show');
   }
}
