<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddNewCourseController extends Controller
{
    
    public function index(Request $request){
        $categories = DB::table('course_main_category')->select('course_main_category.*')->get();
         foreach($categories as $category){
           $category->subcategories = DB::table('course_sub_category')->where('main_category_id',$category->id)->get();
         }
        return view('admin.AddNewCourse.views.index',['categories'=>$categories]);
    }


    public function addNewCourseDetails(Request $request)
    {
        $request->validate([
            'course_type' => 'required|string',
            'course_title' => 'required|string',
            'new_instructor' => 'nullable|array',
            'course_thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'faq_question' => 'nullable|array',
            'faq_description' => 'nullable|array',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Handle instructors
            $instructors = $request->input('new_instructor') 
                ? implode(',', $request->input('new_instructor')) 
                : null;

            // Insert the main course data
            $courseId = DB::table('course')->insertGetId([
                'course_type' => $request->input('course_type'),
                'instructor' => $instructors,
                'course_title' => $request->input('course_title'),
                'short_description' => $request->input('short_description'),
                'description' => $request->input('description'),
                'category' => $request->input('category'),
                'level' => $request->input('level'),
                'language_made_in' => $request->input('language_made_in'),
                'enable_drip_content' => $request->input('enable_drip_content', 0),
                'updated_as' => $request->input('updated_as'),
                'course_is_top_course' => $request->input('course_is_top_course', 0),
            ]);

            // Handle the course thumbnail
            $thumbnailPath = null;
            if ($request->hasFile('course_thumbnail')) {
                $file = $request->file('course_thumbnail');
                $thumbnailPath = $file->store('public/resources/courses/lesson/thumbnail');
            }

            // Insert pricing information
            DB::table('course_manage_pricing')->insert([
                'course_id' => $courseId,
                'is_a_free_course' => $request->input('is_free_course'),
                'price' => $request->input('price'),
                'if_course_has_discount' => $request->input('discount_flag'),
                'discounted_price' => $request->input('discounted_price'),
                'expiry_period' => $request->input('expiry_period'),
                'no_of_month' => $request->input('number_of_month'),
            ]);

            // Insert media information
            DB::table('course_manage_media')->insert([
                'course_id' => $courseId,
                'overview_provider' => $request->input('course_overview_provider'),
                'overview_url' => $request->input('course_overview_url'),
                'thumbnail' => $thumbnailPath,
            ]);

            // Insert SEO settings
            DB::table('course_seo_settings')->insert([
                'course_id' => $courseId,
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
            ]);

            // Handle FAQs
            $faqQuestions = $request->input('faq_question', []);
            $faqDescriptions = $request->input('faq_description', []);
            foreach ($faqQuestions as $index => $question) {
                if (!empty($question) && isset($faqDescriptions[$index]) && !empty($faqDescriptions[$index])) {
                    DB::table('course_manage_faqs')->insert([
                        'course_id' => $courseId,
                        'question' => $question,
                        'answer' => $faqDescriptions[$index],
                    ]);
                }
            }

            // Handle requirements
            $requirements = $request->input('requirement', []);
            foreach ($requirements as $requirement) {
                if (!empty($requirement)) {
                    DB::table('course_manage_requirements')->insert([
                        'course_id' => $courseId,
                        'requirement' => $requirement,
                    ]);
                }
            }

            // Handle outcomes
            $outcomes = $request->input('outcome', []);
            foreach ($outcomes as $outcome) {
                if (!empty($outcome)) {
                    DB::table('course_manage_outcomes')->insert([
                        'course_id' => $courseId,
                        'outcome' => $outcome,
                    ]);
                }
            }

            // Commit the transaction
            DB::commit();

            return response()->json(['message' => 'Course details added successfully']);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            // Log the error for debugging
            Log::error('Error adding course details', ['error' => $e->getMessage()]);

            return response()->json(['error' => 'Failed to add course details', 'message' => $e->getMessage()], 500);
        }
    }


    // public function addNewCourseDetails(Request $request)
    // {
        
    //     // print_r('opopoopoppopo');die;
        
    //     print_r($request->all());die;
    //     $instructors = $request->input('new_instructor') ? implode(',', $request->input('new_instructor')) : null;

    //     $insertedId = DB::table('course')->insertGetId([
    //         'course_type' => $request->input('course_type') ?? null,
    //         'instructor' => $instructors,
    //         'course_title' => $request->input('course_title') ?? null,
    //         'short_description' => $request->input('short_description') ?? null,
    //         'description' => $request->input('description') ?? null,
    //         'category' => $request->input('category') ?? null,
    //         'level' => $request->input('level') ?? null,
    //         'language_made_in' => $request->input('language_made_in') ?? null,
    //         'enable_drip_content' => $request->input('enable_drip_content') ?? 0,
    //         'updated_as' => $request->input('updated_as') ?? null,
    //         'course_is_top_course' => $request->input('course_is_top_course') ?? 0,
    //     ]);

    //     if ($insertedId) {
    //         DB::table('course_manage_pricing')->insert([
    //             'course_id' => $insertedId,
    //             'is_a_free_course' => $request->input('is_free_course') ?? null,
    //             'price' => $request->input('price') ?? null,
    //             'if_course_has_discount' => $request->input('discount_flag') ?? null,
    //             'discounted_price' => $request->input('discounted_price') ?? null,
    //             'expiry_period' => $request->input('expiry_period') ?? null,
    //             'no_of_month' => $request->input('number_of_month') ?? null,
    //         ]);

    //         DB::table('course_seo_settings')->insert([
    //             'course_id' => $insertedId,
    //             'meta_keywords' => $request->input('meta_keywords') ?? null,
    //             'meta_description' => $request->input('meta_description') ?? null,
    //         ]);

    //         $path = '';
    //         if ($request->hasFile('course_thumbnail')) {
    //             $file = $request->file('course_thumbnail');
    //             $filename = time() . '.' . $file->getClientOriginalExtension();
    //             $path = $file->storeAs('public/resources/courses/lesson/thumbnail', $filename);
    //         }

    //         DB::table('course_manage_media')->insert([
    //             'course_id' => $insertedId,
    //             'overview_provider' => $request->input('course_overview_provider') ?? null,
    //             'overview_url' => $request->input('course_overview_url') ?? null,
    //             'thumbnail' => $path,
    //         ]);

    //         $faqQuestions = array_filter($request->input('faq_question'), fn($value) => !is_null($value) && $value !== '');
    //         $faqDescriptions = array_filter($request->input('faq_description'), fn($value) => !is_null($value) && $value !== '');

    //         $faqs = [];
    //         foreach ($faqQuestions as $index => $question) {
    //             if (isset($faqDescriptions[$index]) && !is_null($faqDescriptions[$index]) && $faqDescriptions[$index] !== '') {
    //                 $faqs[] = [
    //                     'course_id' => $insertedId,
    //                     'question' => $question,
    //                     'answer' => $faqDescriptions[$index],
    //                 ];
    //             }
    //         }
    //         foreach ($faqs as $faq) {
    //             DB::table('course_manage_faqs')->insert($faq);
    //         }

    //         $requirements = array_filter($request->input('requirement'), fn($value) => !is_null($value) && $value !== '');
    //         foreach ($requirements as $requirement) {
    //             DB::table('course_manage_requirements')->insert([
    //                 'course_id' => $insertedId,
    //                 'requirement' => $requirement,
    //             ]);
    //         }

    //         $outcomes = array_filter($request->input('outcome'), fn($value) => !is_null($value) && $value !== '');
    //         foreach ($outcomes as $outcome) {
    //             DB::table('course_manage_outcomes')->insert([
    //                 'course_id' => $insertedId,
    //                 'outcome' => $outcome,
    //             ]);
    //         }
    //     }

    //     return response()->json(['message' => 'Course details added successfully']);
    // }

}
