<?php

namespace App\Http\Controllers\StudentDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompleteSolutionController extends Controller
{
    public function index(){
        return view('StudentDashboard.complete_solution.main');
    }
}
