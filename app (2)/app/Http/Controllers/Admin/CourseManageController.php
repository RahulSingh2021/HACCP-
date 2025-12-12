<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseManageController extends Controller
{

public function list(Request $request)
{
    $query = DB::table('course')
        ->join('course_sub_category', 'course.category', '=', 'course_sub_category.id')
        ->select('course.*');

    $categoryid = $request->input('category_id', 'all');
    $status = $request->input('status', 'all');
    $instructor_id = $request->input('instructor_id', 'all');
    $price = $request->input('price', 'all');
    if ($categoryid && $categoryid != 'all') {
        $query->where('course_sub_category.id', $categoryid);
    }

    if ($status && $status != 'all') {
        $query->where('course.updated_as', $status);
    }

    if ($instructor_id && $instructor_id != 'all') {
        $query->where('course.instructor', $instructor_id);
    }

    if ($price && $price != 'all') {
        $query->join('course_manage_pricing', 'course.id', '=', 'course_manage_pricing.course_id');
        if ($price == 'free') {
            $query->where('course_manage_pricing.is_a_free_course', 1);
        } elseif ($price == 'paid') {
            $query->where('course_manage_pricing.is_a_free_course', 0);
        }
    }

    $active_course = DB::table('course')->where('updated_as', 'active')->count();
    $upcoming_course = DB::table('course')->where('updated_as', 'upcoming')->count();
    $private_course = DB::table('course')->where('updated_as', 'private')->count();
    $top_course = DB::table('course')->where('course_is_top_course', 1)->count();
    $free_course = DB::table('course_manage_pricing')->where('is_a_free_course', 1)->count();
    $paid_course = DB::table('course_manage_pricing')->where('is_a_free_course', 0)->count();

    $courses = $query->paginate(10);
    foreach ($courses as $course) {
        $course->category = DB::table('course_sub_category')->where('id', $course->category)->first();
        $course->section_count = DB::table('course_manage_add_section')->where('courser_id', $course->id)->count();
        $sections = DB::table('course_manage_add_section')->where('courser_id', $course->id)->get();
        $course->sections = $sections;
        $totalLessonCount = 0;
        foreach ($sections as $section) {
            $lessonCount = DB::table('course_manage_add_lesson')->where('section_id', $section->id)->count();
            $totalLessonCount += $lessonCount;
        }
        $course->lesson_count = $totalLessonCount;
        $course->pricing = DB::table('course_manage_pricing')->where('course_id', $course->id)->first();
    }

    $categories = DB::table('course_main_category')->select('course_main_category.*')->paginate(4);
    foreach ($categories as $category) {
        $category->subcategories = DB::table('course_sub_category')->where('main_category_id', $category->id)->get();
    }


    return view('admin.CourseManage.views.list', compact(
        'active_course', 'upcoming_course', 'private_course', 'top_course',
        'free_course', 'paid_course', 'courses', 'categories', 'categoryid', 'status', 'instructor_id', 'price'
    ));
}


public function index($id)
{
    $sections =  DB::table('course_manage_add_section')->where('courser_id', $id)->orderBy('sort_order')->get();
    
    foreach ($sections as $section) {
        $section->lessons = DB::table('course_manage_add_lesson')->where('section_id', $section->id)->orderBy('sort_order')->get();
        
        foreach ($section->lessons as $lesson) {
            $lesson->files = DB::table('courser_manage_new_resource')->where('lesson_id', $lesson->id)->get();
        }
        
        $section->quizs = DB::table('course_manage_add_quiz')->where('section_id', $section->id)->get();
        
        foreach ($section->quizs as $quiz) {
            $quiz->questions = DB::table('course_manage_quiz_questions')->where('quiz_id', $quiz->id)->orderBy('sort_order')->get();
            
            foreach ($quiz->questions as $question) {
                $question->answers = DB::table('course_manage_quiz_question_answers')->where('quiz_question_id', $question->id)->get();
            }
        }
    }

    // Retrieve other course-related data
    $meta_keywords = DB::table('course_seo_settings')->where('course_id', $id)->first();
    $google_meet_class = DB::table('google_meet_live_class')->where('course_id', $id)->first();
    $jitsi_live_class = DB::table('jitsi_live_class')->where('course_id', $id)->first();
    $assignments = DB::table('course_manage_assignment')->where('course_id', $id)->get();
    $notices = DB::table('course_manage_notice_board')->where('course_id', $id)->get();
    $faqs = DB::table('course_manage_faqs')->where('course_id', $id)->get();
    $requirements = DB::table('course_manage_requirements')->where('course_id', $id)->get();
    $outcomes = DB::table('course_manage_outcomes')->where('course_id', $id)->get();
    $course_pricing = DB::table('course_manage_pricing')->where('course_id', $id)->first();
    $course_media = DB::table('course_manage_media')->where('course_id', $id)->first();
    $seo_tags = DB::table('course_seo_settings')->where('course_id', $id)->first();

    $course_details = DB::table('course')->where('id', $id)->first();

    $categories = DB::table('course_main_category')->select('course_main_category.*')->get();
    foreach ($categories as $category) {
        $category->subcategories = DB::table('course_sub_category')->where('main_category_id', $category->id)->get();
    }

    // Return view with all variables
    return view('admin.CourseManage.views.index', compact(
        'sections', 
        'meta_keywords', 
        'google_meet_class', 
        'jitsi_live_class', 
        'assignments', 
        'notices', 
        'faqs', 
        'requirements', 
        'outcomes', 
        'course_pricing', 
        'course_media', 
        'seo_tags', 
        'id', 
        'course_details', 
        'categories'
    ));
}


public function editCourse($id)
{
    $sections =  DB::table('course_manage_add_section')->where('courser_id', $id)->orderBy('sort_order')->get();
    
    foreach ($sections as $section) {
        $section->lessons = DB::table('course_manage_add_lesson')->where('section_id', $section->id)->orderBy('sort_order')->get();
        
        foreach ($section->lessons as $lesson) {
            $lesson->files = DB::table('courser_manage_new_resource')->where('lesson_id', $lesson->id)->get();
        }
        
        $section->quizs = DB::table('course_manage_add_quiz')->where('section_id', $section->id)->get();
        
        foreach ($section->quizs as $quiz) {
            $quiz->questions = DB::table('course_manage_quiz_questions')->where('quiz_id', $quiz->id)->orderBy('sort_order')->get();
            
            foreach ($quiz->questions as $question) {
                $question->answers = DB::table('course_manage_quiz_question_answers')->where('quiz_question_id', $question->id)->get();
            }
        }
    }

    // Retrieve other course-related data
    $meta_keywords = DB::table('course_seo_settings')->where('course_id', $id)->first();
    $google_meet_class = DB::table('google_meet_live_class')->where('course_id', $id)->first();
    $jitsi_live_class = DB::table('jitsi_live_class')->where('course_id', $id)->first();
    $assignments = DB::table('course_manage_assignment')->where('course_id', $id)->get();
    $notices = DB::table('course_manage_notice_board')->where('course_id', $id)->get();
    $faqs = DB::table('course_manage_faqs')->where('course_id', $id)->get();
    $requirements = DB::table('course_manage_requirements')->where('course_id', $id)->get();
    $outcomes = DB::table('course_manage_outcomes')->where('course_id', $id)->get();
    $course_pricing = DB::table('course_manage_pricing')->where('course_id', $id)->first();
    $course_media = DB::table('course_manage_media')->where('course_id', $id)->first();
    $seo_tags = DB::table('course_seo_settings')->where('course_id', $id)->first();

    $course_details = DB::table('course')->where('id', $id)->first();

    $categories = DB::table('course_main_category')->select('course_main_category.*')->get();
    foreach ($categories as $category) {
        $category->subcategories = DB::table('course_sub_category')->where('main_category_id', $category->id)->get();
    }

    return view('admin.CourseManage.views.edit-course', compact(
        'sections', 
        'meta_keywords', 
        'google_meet_class', 
        'jitsi_live_class', 
        'assignments', 
        'notices', 
        'faqs', 
        'requirements', 
        'outcomes', 
        'course_pricing', 
        'course_media', 
        'seo_tags', 
        'id', 
        'course_details', 
        'categories'
    ));
}



    public function addSection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode('<br>', $errors);
            return redirect()->back()
                ->with('error', $errorMessages)
                ->withInput();
        }

        DB::table('course_manage_add_section')->insert([
            'courser_id' => $request->course_id,
            'title' => $request->section_title,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Section added successfully!');
    }


    public function addLesson(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lesson_type' => 'required',
            'title' => 'required',
            'section' => 'required',
            'summary' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode('<br>', $errors);
            return redirect()->back()
                ->with('error', $errorMessages)
                ->withInput();
        }

        $rules = [];
        $fileFields = [];

        switch ($request->lesson_type) {
            case "YouTube Video":
            case "Vimeo Video":
            case "Google drive video":
                $rules = [
                    'video_url' => 'required|url',
                    'duration' => 'required',
                ];
                break;

            case "Video file":
                $rules = [
                    'upload_video_file' => 'required|file|mimes:mp4,mov,avi|max:100000',
                    'duration' => 'required',
                    'caption' => 'required',
                ];
                break;

            case "Audio file":
                $rules = [
                    'audio_file' => 'required|file|mimes:mp3,wav|max:100000',
                    'duration' => 'required',
                ];
                break;

            case "Video url [.mp4]":
                $rules = [
                    'video_url' => 'required|url',
                    'duration' => 'required',
                    'thumbnail' => 'required|image|dimensions:979,551',
                    'caption' => 'required',
                ];
                break;

            case "Amazon S3 Bucket":
            case "Wasabi storage video":
                $rules = [
                    'upload_video_file' => 'required|file|mimes:mp4,mov,avi|max:100000',
                    'duration' => 'required',
                ];
                break;

            case "Document file":
                $rules = [
                    'document_type' => 'required|string',
                    'attachment' => 'required|file|mimes:pdf,doc,docx|max:100000',
                ];
                break;

            case "Text":
                $rules = [
                    'text' => 'required|string',
                ];
                break;

            case "Image file":
                $rules = [
                    'attachment' => 'required|image|mimes:jpg,jpeg,png|max:100000',
                ];
                break;

            case "Iframe embed":
                $rules = [
                    'iframe_source' => 'required|string',
                ];
                break;

            default:
                return redirect()->back()
                    ->with('error', 'Invalid lesson type provided.')
                    ->withInput();
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode('<br>', $errors);
            return redirect()->back()
                ->with('error', $errorMessages)
                ->withInput();
        }

        if ($request->hasFile('upload_video_file')) {
            $file = $request->file('upload_video_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fileFields['upload_video_file'] = $file->storeAs('public/resources/courses/lesson/videos', $filename);
        }

        if ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fileFields['audio_file'] = $file->storeAs('public/resources/courses/lesson/audio', $filename);
        }

        if ($request->hasFile('caption')) {
            $file = $request->file('caption');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fileFields['caption'] = $file->storeAs('public/resources/courses/lesson/caption', $filename);
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fileFields['thumbnail'] = $file->storeAs('public/resources/courses/lesson/thumbnail', $filename);
        }

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fileFields['attachment'] = $file->storeAs('public/resources/courses/lesson/attachment', $filename);
        }

        $data = [
            'course_id'=>$request->course_id,
            'section_id' => $request->section,
            'lesson_type' => $request->lesson_type,
            'title' => $request->title,
            'video_url' => $request->video_url ?? null,
            'duration' => $request->duration ?? null,
            'summary' => $request->summary,
            'audio_url' => isset($fileFields['audio_file']) ? str_replace('public/', '', $fileFields['audio_file']) : null,
            'upload_video_file' => isset($fileFields['upload_video_file']) ? str_replace('public/', '', $fileFields['upload_video_file']) : null,
            'thumbnail' => isset($fileFields['thumbnail']) ? str_replace('public/', '', $fileFields['thumbnail']) : null,
            'caption' => isset($fileFields['caption']) ? str_replace('public/', '', $fileFields['caption']) : null,
            'document_type' => $request->document_type ?? null,
            'attachment' => isset($fileFields['attachment']) ? str_replace('public/', '', $fileFields['attachment']) : null,
            'text' => $request->text ?? null,
            'iframe_source' => $request->iframe_source ?? null,
            'mark_as_free_lesson' => $request->has('free_lesson') ? 1 : 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];


        DB::table('course_manage_add_lesson')->insert($data);

        return redirect()->back()
            ->with('success', 'Lesson added successfully!');
    }


    public function addQuiz(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quiz_title' => 'required',
            'quiz_section' => 'required',
            'quiz_duration' => 'required',
            'total_marks' => 'required',
            'pass_marks' => 'required',
            'number_of_quiz_retakes' => 'required',
            'quiz_summary' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode('<br>', $errors);
            return redirect()->back()
                ->with('error', $errorMessages)
                ->withInput();
        }


        DB::table('course_manage_add_quiz')->insert([
            'course_id' => $request->course_id,
            'section_id' => $request->quiz_section,
            'quiz_title' => $request->quiz_title,
            'quiz_duration' => $request->quiz_duration,
            'total_marks' => $request->total_marks,
            'pass_marks' => $request->pass_marks,
            'drip_content_rule' => $request->drip_content_rules ?? null,
            'number_of_quiz_retakes' => $request->number_of_quiz_retakes ?? 0,
            'instruction' => $request->quiz_summary,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Quiz added successfully!');
    }

    public function deleteLesson($id)
    {
        DB::table('course_manage_add_lesson')->where('id', $id)->delete();
        return redirect()->back()
            ->with('success', 'Lesson deleted successfully!');
    }

    public function addResourceFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'resource_file' => 'required|file|mimes:pdf,csv,xlsx,xls|max:1048576',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode('<br>', $errors);

            return redirect()->back()
                ->with('error', $errorMessages)
                ->withInput();
        }

        if ($request->hasFile('resource_file')) {
            $file = $request->file('resource_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/resources/courses/lesson/resource', $filename);
        } else {
            $path = '';
        }


        DB::table('courser_manage_new_resource')->insert([
            'lesson_id' => $request->lesson_id,
            'title' => $request->title,
            'resource_file' => $path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->back()
            ->with('success', 'Resource file added successfully!');
    }

    public function deleteResourceFile($id)
    {
        DB::table('courser_manage_new_resource')->where('id', $id)->delete();
        return redirect()->back()
            ->with('success', 'Resource file deleted successfully!');
    }

    public function updateResourceFile(Request $request)
    {
        // Validate the request data
        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|string|max:255',
        //     'resource_file' => 'nullable|file|mimes:pdf,csv,xlsx,xls|max:1048576',
        // ]);

        // if ($validator->fails()) {
        //     $errors = $validator->errors()->all();
        //     $errorMessages = implode('<br>', $errors);

        //     return redirect()->back()
        //         ->with('error', $errorMessages)
        //         ->withInput();
        // }

        $resource = DB::table('courser_manage_new_resource')->where('id', $request->file_id)->first();

        if (!$resource) {
            return redirect()->back()
                ->with('error', 'Resource not found.');
        }

        if ($request->hasFile('resource_file')) {
            $file = $request->file('resource_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/resources/courses/lesson/resource', $filename);
        } else {
            $path = $resource->resource_file;
        }

        DB::table('courser_manage_new_resource')->where('id', $request->file_id)->update([
            'title' => $request->title,
            'resource_file' => $path,
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Resource file updated successfully!');
    }

    public function downloadResourceFile($id)
    {
        $data = DB::table('courser_manage_new_resource')->where('id', $id)->first();
        $filePath = $data->resource_file;
        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }


    public function deleteQuiz($id)
    {
        $quiz = DB::table('course_manage_add_quiz')->where('id', $id)->delete();
        return redirect()->back()
            ->with('success', 'Quiz deleted successfully!');
    }

    public function updateQuiz(Request $request)
    {
        $data = DB::table('course_manage_add_quiz')->where('id', $request->input('quiz_id'))->first();
        DB::table('course_manage_add_quiz')->where('id', $request->input('quiz_id'))->update([
            'section_id' => $request->input('section', $data->section_id),
            'quiz_title' => $request->input('quiz_title', $data->quiz_title),
            'quiz_duration' => $request->input('quiz_duration', $data->quiz_duration),
            'pass_marks' => $request->input('pass_marks', $data->pass_marks),
            'total_marks' => $request->input('total_marks', $data->total_marks),
            'drip_content_rule' => $request->input('drip_content_rules', $data->drip_content_rule),
            'number_of_quiz_retakes' => $request->input('number_of_quiz_retakes', $data->number_of_quiz_retakes),
            'instruction' => $request->input('quiz_summary', $data->instruction),
            'updated_at' => now(),
        ]);
        return redirect()->back()
            ->with('success', 'Quiz updated successfully!');
    }

    public function deleteSection($id)
    {
        DB::table('course_manage_add_section')->where('id', $id)->delete();
        return redirect()->back()
            ->with('success', 'Section deleted successfully!');
    }

    public function updateSection(Request $request)
    {
        DB::table('course_manage_add_section')->where('id', $request->section_id)->update([
            'title' => $request->title
        ]);
        return redirect()->back()
            ->with('success', 'Section update successfully!');
    }

    public function deleteQuizQuestion($id)
    {
        DB::table('course_manage_quiz_questions')->where('id', $id)->delete();
        return redirect()->back()
            ->with('success', 'Quiz deleted successfully!');
    }

    public function addQuizQuestion(Request $request)
    {
        $validator = null;
        $question = '';
        $answer = '';

        if ($request->question_type_add_quiz === 'fill_in_the_blank') {
            $validator = Validator::make($request->all(), [
                'enter_one_word_add_quiz_question' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errorMessages = implode('<br>', $errors);

                return redirect()->back()
                    ->with('error', $errorMessages)
                    ->withInput();
            }

            $keyword = $request->enter_one_word_add_quiz_question;

            if (strpos($request->question, $keyword) === false) {
                $errorMessage = 'The keyword "' . $keyword . '" does not match the question.';

                return redirect()->back()
                    ->with('error', $errorMessage)
                    ->withInput();
            }
            $question = str_replace($keyword, '____', $request->question);
            $answer = $keyword;
        } elseif ($request->question_type_add_quiz === 'single_choice_true_false') {
            $validator = Validator::make($request->all(), [
                'single_choice_true_false' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errorMessages = implode('<br>', $errors);

                return redirect()->back()
                    ->with('error', $errorMessages)
                    ->withInput();
            }

            $question = $request->question;
            $answer = $request->single_choice_true_false;
        } elseif ($request->question_type_add_quiz === 'multiple_choice') {
            $validator = Validator::make($request->all(), [
                'add_quiz_option' => 'required|array',
                'checkbox_quiz_option' => 'required|array',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errorMessages = implode('<br>', $errors);

                return redirect()->back()
                    ->with('error', $errorMessages)
                    ->withInput();
            }

            $question = $request->question;
            $answer = $request->checkbox_quiz_option;
        }

        $questionId = DB::table('course_manage_quiz_questions')->insertGetId([
            'quiz_id' => $request->quiz_id,
            'question' => $question,
            'question_type' => $request->question_type_add_quiz,
            'answer' => is_array($answer) ? json_encode($answer) : $answer
        ]);

        if ($request->question_type_add_quiz === 'multiple_choice') {
            $correctIndices = array_map(function ($value) {
                return intval(trim($value, '.'));
            }, $request->checkbox_quiz_option);

            foreach ($request->add_quiz_option as $index => $option) {
                DB::table('course_manage_quiz_question_answers')->insert([
                    'quiz_question_id' => $questionId,
                    'answer' => $option,
                    'is_correct' => in_array($index + 1, $correctIndices) ? 1 : 0,
                ]);
            }
        }

        return redirect()->back()
            ->with('success', 'Quiz question added successfully!');
    }
    public function updateQuizQuestion(Request $request)
    {
        $question = '';
        $answer = '';

        if ($request->question_type_add_quiz === 'fill_in_the_blank') {
            $validator = Validator::make($request->all(), [
                'enter_one_word_add_quiz_question' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errorMessages = implode('<br>', $errors);

                return redirect()->back()
                    ->with('error', $errorMessages)
                    ->withInput();
            }

            $keyword = $request->enter_one_word_add_quiz_question;

            if (strpos($request->question, $keyword) === false) {
                $errorMessage = 'The keyword "' . $keyword . '" does not match the question.';

                return redirect()->back()
                    ->with('error', $errorMessage)
                    ->withInput();
            }
            $question = str_replace($keyword, '____', $request->question);
            $answer = $keyword;
        } elseif ($request->question_type_add_quiz === 'single_choice_true_false') {
            $validator = Validator::make($request->all(), [
                'single_choice_true_false' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errorMessages = implode('<br>', $errors);

                return redirect()->back()
                    ->with('error', $errorMessages)
                    ->withInput();
            }

            $question = $request->question;
            $answer = $request->single_choice_true_false;
        } elseif ($request->question_type_add_quiz === 'multiple_choice') {
            $validator = Validator::make($request->all(), [
                'add_quiz_option' => 'required|array',
                'checkbox_quiz_option' => 'required|array',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errorMessages = implode('<br>', $errors);

                return redirect()->back()
                    ->with('error', $errorMessages)
                    ->withInput();
            }

            $question = $request->question;
            $answer = $request->checkbox_quiz_option;
        }

        $updated = DB::table('course_manage_quiz_questions')
            ->where('id', $request->question_id)
            ->update([
                'question' => $question,
                'question_type' => $request->question_type_add_quiz,
                'answer' => is_array($answer) ? json_encode($answer) : $answer
            ]);

        if (!$updated) {
            return redirect()->back()
                ->with('error', 'Failed to update the quiz question.')
                ->withInput();
        }

        if ($request->question_type_add_quiz === 'multiple_choice') {
            $correctIndices = array_map(function ($value) {
                return intval(trim($value, '.'));
            }, $request->checkbox_quiz_option);

            DB::table('course_manage_quiz_question_answers')
                ->where('quiz_question_id', $request->question_id)
                ->delete();

            foreach ($request->add_quiz_option as $index => $option) {
                DB::table('course_manage_quiz_question_answers')->insert([
                    'quiz_question_id' => $request->question_id,
                    'answer' => $option,
                    'is_correct' => in_array($index + 1, $correctIndices) ? 1 : 0,
                ]);
            }
        }

        return redirect()->back()
            ->with('success', 'Quiz question updated successfully!');
    }

    public function updateQuizQuestionOrder(Request $request)
    {
        $sortedIDs = $request->input('sorted_ids');
        foreach ($sortedIDs as $index => $id) {
            DB::table('course_manage_quiz_questions')
                ->where('id', $id)
                ->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function updateLessonOrder(Request $request)
    {
        $sortedIDs = $request->input('sorted_ids');
        foreach ($sortedIDs as $index => $id) {
            DB::table('course_manage_add_lesson')
                ->where('id', $id)
                ->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function updateSectionOrder(Request $request)
    {
        $sortedIDs = $request->input('sorted_ids');
        foreach ($sortedIDs as $index => $id) {
            DB::table('course_manage_add_section')
                ->where('id', $id)
                ->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function updateSeoByCourseId(Request $request)
    {
        $seo = DB::table('course_seo_settings')->where('course_id', $request->course_id);

        if ($seo->exists()) {
            $seo->update([
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description,
            ]);
        } else {
            $seo->insert([
                'course_id' => $request->course_id,
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description,
            ]);
        }
        return redirect()->back()->with('success', 'Seo tags added successfully!');
     }

    public function addGoogleMeetLiveClass(Request $request){
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'time' => 'required',
            'note_to_students' => 'required',
            'meet_meeting_id' => 'required',
            'meet_meeting_password' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode('<br>', $errors);

            return redirect()->back()
                ->with('error', $errorMessages)
                ->withInput();
        }

        if($request->course_id > 0){
            $check = DB::table('google_meet_live_class')->where('course_id',$request->course_id)->first();

            if($check){
                    $udpate = DB::table('google_meet_live_class')->where('course_id',$request->course_id)->update([
                    'date' => $request->date ?? '',
                    'time' => $request->time ?? '',
                    'notes_to_student' => $request->note_to_students ?? '',
                    'meeting_id' => $request->meet_meeting_id ?? '',
                    'meeting_password' => $request->meet_meeting_password ?? '',
                    ]);
            }else{
                    $add = DB::table('google_meet_live_class')->insert([
                        'course_id' => $request->course_id ?? '',
                        'date' => $request->date ?? '',
                        'time' => $request->time ?? '',
                        'notes_to_student' => $request->note_to_students ?? '',
                        'meeting_id' => $request->meet_meeting_id ?? '',
                        'meeting_password' => $request->meet_meeting_password ?? '',
                    ]);
            }
        }


       return redirect()->back()
       ->with('success', 'Google meet live class details updated successfully!');
    }

    public function addJitsiLiveClass(Request $request){
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'time' => 'required',
            'note_to_students' => 'required',
            'jitsi_meeting_password' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode('<br>', $errors);

            return redirect()->back()
                ->with('error', $errorMessages)
                ->withInput();
        }

        if($request->course_id > 0){
            $check = DB::table('jitsi_live_class')->where('course_id',$request->course_id)->first();

            if($check){
                    $udpate = DB::table('jitsi_live_class')->where('course_id',$request->course_id)->update([
                    'date' => $request->date ?? '',
                    'time' => $request->time ?? '',
                    'notes_to_student' => $request->note_to_students ?? '',
                    'jitsi_meeting_password' => $request->jitsi_meeting_password ?? '',
                    ]);
            }else{
                    $add = DB::table('jitsi_live_class')->insert([
                        'course_id' => $request->course_id ?? '',
                        'date' => $request->date ?? '',
                        'time' => $request->time ?? '',
                        'notes_to_student' => $request->note_to_students ?? '',
                        'jitsi_meeting_password' => $request->jitsi_meeting_password ?? '',
                    ]);
            }
        }


       return redirect()->back()
       ->with('success', 'Jitsi live class details updated successfully!');
    }

    public function addAssignment(Request $request){
        $validator = Validator::make($request->all(), [
            'assignment_title' => 'required',
            'questions' => 'required',
            'date' => 'required',
            'time' => 'required',
            'total_marks' => 'required',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode('<br>', $errors);

            return redirect()->back()
                ->with('error', $errorMessages)
                ->withInput();
        }

        if ($request->hasFile('question_file')) {
            $file = $request->file('question_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/resources/courses/assignment/question_file', $filename);
        } else {
            $path = '';
        }

        DB::table('course_manage_assignment')->insert([
            'course_id' => $request->course_id,
            'title' => $request->assignment_title,
            'question' => $request->questions,
            'question_file' => $path,
            'total_marks' => $request->total_marks,
            'deadline_date' => $request->date,
            'deadline_time' => $request->time,
            'notes' => $request->note ?? '',
            'submission_status' => $request->status ?? 0,
        ]);
        return redirect()->back()->with('success', 'Assignment added successfully!');
    }

    public function deleteAssignment($id){
        DB::table('course_manage_assignment')->where('id',$id)->delete();
        return redirect()->back()->with('success', 'Assignment deleted successfully!');
    }

    public function downloadAssignmentQuestionFile($id){
        $data = DB::table('course_manage_assignment')->where('id', $id)->first();
        $filePath = $data->question_file;
        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    public function updateAssignment(Request $request){
        $validator = Validator::make($request->all(), [
            'assignment_title' => 'required',
            'questions' => 'required',
            'date' => 'required',
            'time' => 'required',
            'total_marks' => 'required',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode('<br>', $errors);

            return redirect()->back()
                ->with('error', $errorMessages)
                ->withInput();
        }

        $check_data =  DB::table('course_manage_assignment')->where('id',$request->assignment_id)->first();

        if ($request->hasFile('question_file')) {
            $file = $request->file('question_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/resources/courses/assignment/question_file', $filename);
        } else {
            $path = $check_data->question_file;
        }

        DB::table('course_manage_assignment')->where('id',$request->assignment_id)->update([
            'title' => $request->assignment_title,
            'question' => $request->questions,
            'question_file' => $path,
            'total_marks' => $request->total_marks,
            'deadline_date' => $request->date,
            'deadline_time' => $request->time,
            'notes' => $request->note ?? '',
            'submission_status' => $request->status ?? 0,
        ]);
        return redirect()->back()->with('success', 'Assignment updated successfully!');
    }

    public function addNewNotice(Request $request){
        $validator = Validator::make($request->all(), [
            'notice_title' => 'required',
            'notice_description' => 'required',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode('<br>', $errors);

            return redirect()->back()
                ->with('error', $errorMessages)
                ->withInput();
        }

        DB::table('course_manage_notice_board')->insert([
            'course_id' => $request->course_id,
            'title' => $request->notice_title,
            'description' => $request->notice_description,
            'is_mail_send' => $request->mail_to_students ?? 0,
        ]);
        return redirect()->back()->with('success', 'Notice added successfully!');
    }

    public function deleteNotice($id){
        DB::table('course_manage_notice_board')->where('id',$id)->delete();
        return redirect()->back()->with('success', 'Notice deleted successfully!');
    }

    public function updateNotice(Request $request){
        DB::table('course_manage_notice_board')->where('id',$request->notice_id)->update([
            'title' => $request->notice_title,
            'description' => $request->notice_description,
        ]);
        return redirect()->back()->with('success', 'Notice updated successfully!');
    }

    public function addFaqs(Request $request){
        $faq = DB::table('course_manage_faqs')->insert([
            'course_id'=> $request->course_id,
            'question' =>  $request->question,
            'answer' =>  $request->answer,
        ]);
        return redirect()->back()->with('success', 'Faqs added successfully!');
    }

    public function addRequirements(Request $request){
        $req = DB::table('course_manage_requirements')->insert([
            'course_id'=> $request->course_id,
            'requirement' =>  $request->requirement,
        ]);
        return redirect()->back()->with('success', 'Requirements added successfully!');
    }

    public function addOutcomes(Request $request){
        $outcome = DB::table('course_manage_outcomes')->insert([
            'course_id'=> $request->course_id,
            'outcome' =>  $request->outcome,
        ]);
        return redirect()->back()->with('success', 'Outcomes added successfully!');
    }

    public function deleteFaq($id){
        $del = DB::table('course_manage_faqs')->where('id',$id)->delete();
        return redirect()->back()->with('success', 'Faqs deleted successfully!');
    }

    public function deleteRequirement($id){
        $del = DB::table('course_manage_requirements')->where('id',$id)->delete();
        return redirect()->back()->with('success', 'Requirements deleted successfully!');
    }

    public function deleteOutcome($id){
        $del = DB::table('course_manage_outcomes')->where('id',$id)->delete();
        return redirect()->back()->with('success', 'Outcomes deleted successfully!');
    }

    public function updateFaq(Request $request){
        $faq = DB::table('course_manage_faqs')->where('id',$request->faq_id)->update([
            'question' =>  $request->question,
            'answer' =>  $request->answer,
        ]);
        return redirect()->back()->with('success', 'Faqs updated successfully!');
    }

    public function updateRequirements(Request $request){
        $req = DB::table('course_manage_requirements')->where('id',$request->requirement_id)->update([
            'requirement' =>  $request->requirement,
        ]);
        return redirect()->back()->with('success', 'Requirements updated successfully!');
    }

    public function updateOutcomes(Request $request){
        $outcome = DB::table('course_manage_outcomes')->where('id',$request->outcome_id)->update([
            'outcome' =>  $request->outcome,
        ]);
        return redirect()->back()->with('success', 'Outcomes updated successfully!');
    }

    public function coursePricing(Request $request){
        $check_exist = DB::table('course_manage_pricing')->where('course_id',$request->course_id)->first();
        if($check_exist){
            $pricing = DB::table('course_manage_pricing')->where('course_id',$request->course_id)->update([
                'is_a_free_course' =>  $request->is_free_course ?? $check_exist->is_a_free_course,
                'price' => $request->price  ?? $check_exist->price,
                'if_course_has_discount' => $request->discount_flag  ?? $check_exist->if_course_has_discount,
                'discounted_price' => $request->discounted_price  ?? $check_exist->discounted_price,
                'expiry_period' => $request->expiry_period  ?? $check_exist->expiry_period,
                'no_of_month' => $request->number_of_month  ?? $check_exist->no_of_month,
            ]);
        }else{
            $pricing = DB::table('course_manage_pricing')->insert([
                'course_id'=> $request->course_id,
                'is_a_free_course' =>  $request->is_free_course,
                'price' => $request->price,
                'if_course_has_discount' => $request->discount_flag,
                'discounted_price' => $request->discounted_price,
                'expiry_period' => $request->expiry_period,
                'no_of_month' => $request->number_of_month,
            ]);
        }
        return redirect()->back()->with('success', 'Pricing added successfully!');
    }

    public function courseMedia(Request $request){
        $check_exist = DB::table('course_manage_media')->where('course_id',$request->course_id)->first();
        if($check_exist){
            if ($request->hasFile('course_thumbnail')) {
                    // $file = $request->file('course_thumbnail');
                    // $filename = time() . '_' . $file->getClientOriginalName();
                    // $path = $file->storeAs('public/resources/courses/media', $filename);
                    $path = null;
                    $file = $request->file('course_thumbnail');
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/courses/media'), $filename);
                    $path = 'images/courses/media/' . $filename; 
            } else {
                $path = $check_exist->thumbnail;
            }
            $media = DB::table('course_manage_media')->where('course_id',$request->course_id)->update([
                'overview_provider' => $request->course_overview_provider ?? $check_exist->overview_provider,
                'overview_url' => $request->course_overview_url ?? $check_exist->overview_url,
                'thumbnail' => $path,
            ]);
            return redirect()->back()->with('success', 'Media added successfully!');
        }else{
            if ($request->hasFile('course_thumbnail')) {
                    // $file = $request->file('course_thumbnail');
                    // $filename = time() . '_' . $file->getClientOriginalName();
                    // $path = $file->storeAs('resources/courses/media', $filename);
                    $path = null;
                    $file = $request->file('course_thumbnail');
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/courses/media'), $filename); 
                    $path = 'images/courses/media/' . $filename; 
            } else {
                $path = '';
            }
            $media = DB::table('course_manage_media')->insert([
                'course_id'=> $request->course_id,
                'overview_provider' => $request->course_overview_provider,
                'overview_url' => $request->course_overview_url,
                'thumbnail' => $path,
            ]);
            return redirect()->back()->with('success', 'Media added successfully!');
        }
    }

    public function downloadCaptionFile($id){
        $data = DB::table('course_manage_add_lesson')->where('id', $id)->first();
        $filePath = 'public/'.$data->caption;
        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    public function updateLesson(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'section' => 'required',
            'summary' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode('<br>', $errors);
            return redirect()->back()
                ->with('error', $errorMessages)
                ->withInput();
        }

        $rules = [];
        $fileFields = [];

        switch ($request->lesson_type) {
            case "YouTube Video":
            case "Vimeo Video":
            case "Google drive video":
                $rules = [
                    'video_url' => 'url',
                ];
                break;

            case "Video file":
                $rules = [
                    'upload_video_file' => 'file|mimes:mp4,mov,avi|max:100000',
                ];
                break;

            case "Audio file":
                $rules = [
                    'audio_file' => 'file|mimes:mp3,wav|max:100000',
                ];
                break;

            case "Video url [.mp4]":
                $rules = [
                    'video_url' => 'url',
                    'thumbnail' => 'image|dimensions:979,551',
                ];
                break;

            case "Amazon S3 Bucket":
            case "Wasabi storage video":
                $rules = [
                    'upload_video_file' => 'file|mimes:mp4,mov,avi|max:100000',
                ];
                break;

            case "Document file":
                $rules = [
                    'document_type' => 'string',
                    'attachment' => 'file|mimes:pdf,doc,docx|max:100000',
                ];
                break;

            case "Text":
                $rules = [
                    'text' => 'string',
                ];
                break;

            case "Image file":
                $rules = [
                    'attachment' => 'image|mimes:jpg,jpeg,png|max:100000',
                ];
                break;

            case "Iframe embed":
                $rules = [
                    'iframe_source' => 'string',
                ];
                break;

            default:
                return redirect()->back()
                    ->with('error', 'Invalid lesson type provided.')
                    ->withInput();
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode('<br>', $errors);
            return redirect()->back()
                ->with('error', $errorMessages)
                ->withInput();
        }



        if ($request->hasFile('upload_video_file')) {
            $file = $request->file('upload_video_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fileFields['upload_video_file'] = $file->storeAs('public/resources/courses/lesson/videos', $filename);
        }

        if ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fileFields['audio_file'] = $file->storeAs('public/resources/courses/lesson/audio', $filename);
        }

        if ($request->hasFile('caption')) {
            $file = $request->file('caption');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fileFields['caption'] = $file->storeAs('public/resources/courses/lesson/caption', $filename);
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fileFields['thumbnail'] = $file->storeAs('public/resources/courses/lesson/thumbnail', $filename);
        }

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fileFields['attachment'] = $file->storeAs('public/resources/courses/lesson/attachment', $filename);
        }


        $get_data = DB::table('course_manage_add_lesson')->where('id',$request->lesson_id)->first();

        $data = [
            'section_id' => $request->section ?? $get_data->section_id,
            'title' => $request->title ?? $get_data->title,
            'video_url' => $request->video_url ?? $get_data->video_url,
            'duration' => $request->duration ?? $get_data->duration,
            'summary' => $request->summary ?? $get_data->summary,
            'audio_url' => isset($fileFields['audio_file']) ? str_replace('public/', '', $fileFields['audio_file']) : $get_data->audio_url,
            'upload_video_file' => isset($fileFields['upload_video_file']) ? str_replace('public/', '', $fileFields['upload_video_file']) : $get_data->upload_video_file,
            'thumbnail' => isset($fileFields['thumbnail']) ? str_replace('public/', '', $fileFields['thumbnail']) :  $get_data->thumbnail,
            'caption' => isset($fileFields['caption']) ? str_replace('public/', '', $fileFields['caption']) : $get_data->caption,
            'document_type' => $request->document_type ??  $get_data->document_type,
            'attachment' => isset($fileFields['attachment']) ? str_replace('public/', '', $fileFields['attachment']) : $get_data->attachment,
            'text' => $request->text ?? $get_data->text,
            'iframe_source' => $request->iframe_source ?? $get_data->iframe_source,
            'mark_as_free_lesson' => $request->has('free_lesson') ? 1 : 0,
            'updated_at' => now(),
        ];


        DB::table('course_manage_add_lesson')->where('id',$request->lesson_id)->update($data);

        return redirect()->back()
            ->with('success', 'Lesson updated successfully!');
    }

    public function updataCourse(Request $request){
        $data =  DB::table('course')->where('id',$request->course_id)->first();
        DB::table('course')->where('id',$request->course_id)->update([
         'course_title' => $request->course_title ?? $data->instructor,
         'instructor' => $request->instructor ?? $data->instructor,
         'short_description' => $request->short_description ?? $data->short_description,
         'description' => $request->description ?? $data->description,
         'category' => $request->category ?? $data->category,
         'level' => $request->level ?? $data->level,
         'language_made_in' => $request->language_made_in ?? $data->language_made_in,
         'enable_drip_content' => $request->enable_drip_content ?? $data->enable_drip_content,
         'updated_as' =>$request->status ?? $data->updated_as ,
         'course_is_top_course' => $request->is_top_course ?? $data->course_is_top_course,
        ]);
        return redirect()->back()
        ->with('success', 'Basic Info updated successfully!');
    }
}
