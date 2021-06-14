<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseUser;
use App\Models\LearningOutcome;
use App\Models\AssessmentMethod;
use App\Models\LearningActivity;
use App\Models\Program;
use App\Models\ProgramLearningOutcome;
use App\Models\OutcomeAssessment;
use App\Models\OutcomeActivity;
use App\Models\MappingScale;
use App\Models\PLOCategory;
use PDF;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('course')->only([ 'show', 'pdf', 'edit', 'submit', 'outcomeDetails' ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $courseUsers = CourseUser::select('course_code', 'program_id')->where('user_id',Auth::id())->get();
        // $courses = Course::all();
        // $programs = Program::all();
        $user = User::where('id', Auth::id())->first();

        $activeCourses = User::join('course_users', 'users.id', '=', 'course_users.user_id')
                ->join('courses', 'course_users.course_id', '=', 'courses.course_id')
                ->join('programs', 'courses.program_id', '=', 'programs.program_id')
                ->select('courses.program_id','courses.course_code','courses.delivery_modality','courses.semester','courses.year','courses.section',
                'courses.course_id','courses.course_num','courses.course_title', 'courses.status','programs.program', 'programs.faculty', 'programs.department','programs.level')
                ->where('course_users.user_id','=',Auth::id())->where('courses.status','=', -1)
                ->get();

        $archivedCourses = User::join('course_users', 'users.id', '=', 'course_users.user_id')
                ->join('courses', 'course_users.course_id', '=', 'courses.course_id')
                ->join('programs', 'courses.program_id', '=', 'programs.program_id')
                ->select('courses.program_id','courses.course_code','courses.delivery_modality','courses.semester','courses.year','courses.section',
                'courses.course_id','courses.course_num','courses.course_title', 'courses.status','programs.program', 'programs.faculty', 'programs.department','programs.level')
                ->where('course_users.user_id','=',Auth::id())->where('courses.status','=', 1)
                ->get();

        return view('courses.index')->with('user', $user)->with('activeCourses', $activeCourses)->with('archivedCourses', $archivedCourses);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'course_code' => 'required',
            'course_num' => 'required',
            'course_title'=> 'required',

            ]);

        $course = new Course;
        $course->program_id = $request->input('program_id');
        $course->course_title = $request->input('course_title');
        $course->course_num = $request->input('course_num');
        $course->course_code =  strtoupper($request->input('course_code'));
        // status of mapping process
        $course->status = -1;
        // course required for program
        $course->required = $request->input('required');
        $course->type = $request->input('type');

        $course->delivery_modality = $request->input('delivery_modality');
        $course->year = $request->input('course_year');
        $course->semester = $request->input('course_semester');
        $course->section = $request->input('course_section');

        // course creation triggered by add new course for program
        if($request->input('type') == 'assigned'){
            // course not yet assigned to an instructor
            $course->assigned = -1;
            $course->save();

            $user = User::where('id', $request->input('user_id'))->first();
            $courseUser = new CourseUser;
            $courseUser->course_id = $course->course_id;
            $courseUser->user_id = $user->id;

            if($courseUser->save()){
                $request->session()->flash('success', 'New course added');
            }else{
                $request->session()->flash('error', 'There was an error adding the course');
            }

            return redirect()->route('programWizard.step3', $request->input('program_id'));
        
        // course creation triggered by add new course on dashboard
        }else{
            // course assigned to course creator
            $course->assigned = 1;
            $course->save();

            $user = User::where('id', $request->input('user_id'))->first();
            $courseUser = new CourseUser;
            $courseUser->course_id = $course->course_id;
            $courseUser->user_id = $user->id;
            if($courseUser->save()){
                $request->session()->flash('success', 'New course added');
            }else{
                $request->session()->flash('error', 'There was an error adding the course');
            }

            return redirect()->route('home');
        }

    }

    /**
     * Copy a existed resource and assign it to the program.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function copy(Request $request){
        $this->validate($request, [
            'course_id' => 'required',
            'program_id' => 'required',
            ]);

        $program_id = $request->input('program_id');
        $course_ids = $request->input('course_id');

        //forloop create an copy of the courses
        foreach($course_ids as $index => $course_id){
            $existCourse = Course::where('course_id', $course_id)->first();
            $requires = $request->input('require'.$course_ids[$index]);

            $course = new Course;

            $course->program_id = $program_id;
            $course->course_title = $existCourse->course_title;
            $course->course_num = $existCourse->course_num;
            $course->course_code =  $existCourse->course_code;
            $course->status = -1;
            $course->required = $requires;
            $course->type = $existCourse->type;

            $course->delivery_modality = $existCourse->delivery_modality;
            $course->year = $existCourse->year;
            $course->semester = $existCourse->semester;
            $course->section = $existCourse->section;

            $course->assigned = -1;
            if($course->save()){

                /*copy learning activities
                $learning_activities = DB::table('learning_activities',$course_id)->pluck('l_activity')->toArray();

                foreach($learning_activities as $learning_activitie){

                }
                */

                //copy learning outcomes
                $l_outcomes = DB::table('learning_outcomes',$course_id)->pluck('clo_shortphrase')->toArray();
                $clo_shortphrases = DB::table('learning_outcomes',$course_id)->pluck('l_outcome')->toArray();

                foreach($l_outcomes as $index => $l_outcome){
                    $lo = new LearningOutcome;
                    $lo->clo_shortphrase = $clo_shortphrases[$index];
                    $lo->l_outcome = $l_outcome;
                    $lo->course_id = $course->course_id;
                    $lo->save();
                }
                /*copy assessment methods
                $a_methods = DB::table('assessment_methods',$course_id)->pluck('a_method')->toArray();
                $weights = DB::table('assessment_methods',$course_id)->pluck('weight')->toArray();

                foreach($a_methods as $a_method){

                }
                */

                $request->session()->flash('success', 'New course added');
            }else{
                $request->session()->flash('error', 'There was an error adding the course');
            }
        }

        return redirect()->route('programWizard.step3', $request->input('program_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($course_id)
    {
        //
        $course =  Course::where('course_id', $course_id)->first();
        $program = Program::where('program_id', $course->program_id)->first();
        $a_methods = AssessmentMethod::where('course_id', $course_id)->get();
        $l_activities = LearningActivity::where('course_id', $course_id)->get();
        $l_outcomes = LearningOutcome::where('course_id', $course_id)->get();
        $pl_outcomes = ProgramLearningOutcome::where('program_id', $course->program_id)->get();
        // $mappingScales = MappingScale::where('program_id', $course->program_id)->get();
        $mappingScales = MappingScale::join('mapping_scale_programs', 'mapping_scales.map_scale_id', "=", 'mapping_scale_programs.map_scale_id')
                                    ->where('mapping_scale_programs.program_id', $course->program_id)->get();
        $ploCategories = PLOCategory::where('program_id', $course->program_id)->get();

        $outcomeActivities = LearningActivity::join('outcome_activities','learning_activities.l_activity_id','=','outcome_activities.l_activity_id')
                                ->join('learning_outcomes', 'outcome_activities.l_outcome_id', '=', 'learning_outcomes.l_outcome_id' )
                                ->select('outcome_activities.l_activity_id','learning_activities.l_activity','outcome_activities.l_outcome_id', 'learning_outcomes.l_outcome')
                                ->where('learning_activities.course_id','=',$course_id)->get();

        $outcomeAssessments = AssessmentMethod::join('outcome_assessments','assessment_methods.a_method_id','=','outcome_assessments.a_method_id')
                                ->join('learning_outcomes', 'outcome_assessments.l_outcome_id', '=', 'learning_outcomes.l_outcome_id' )
                                ->select('assessment_methods.a_method_id','assessment_methods.a_method','outcome_assessments.l_outcome_id', 'learning_outcomes.l_outcome')
                                ->where('assessment_methods.course_id','=',$course_id)->get();

        $outcomeMaps = ProgramLearningOutcome::join('outcome_maps','program_learning_outcomes.pl_outcome_id','=','outcome_maps.pl_outcome_id')
                                ->join('learning_outcomes', 'outcome_maps.l_outcome_id', '=', 'learning_outcomes.l_outcome_id' )
                                ->select('outcome_maps.map_scale_value','outcome_maps.pl_outcome_id','program_learning_outcomes.pl_outcome','outcome_maps.l_outcome_id', 'learning_outcomes.l_outcome')
                                ->where('learning_outcomes.course_id','=',$course_id)->get();


        return view('courses.summary')->with('course', $course)
                                        ->with('program', $program)
                                        ->with('l_outcomes', $l_outcomes)
                                        ->with('pl_outcomes',$pl_outcomes)
                                        ->with('l_activities', $l_activities)
                                        ->with('a_methods', $a_methods)
                                        ->with('outcomeActivities', $outcomeActivities)
                                        ->with('outcomeAssessments', $outcomeAssessments)
                                        ->with('outcomeMaps', $outcomeMaps)
                                        ->with('mappingScales', $mappingScales)
                                        ->with('ploCategories', $ploCategories);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id)
    {
        //
        $course = Course::where('course_id', $course_id)->first();
        $course->status =-1;
        $course->save();

        return redirect()->route('courseWizard.step1', $course_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $course_id)
    {
        //
        $this->validate($request, [
            'course_code'=> 'required',
            'course_num'=> 'required',
            'course_title'=> 'required',
            ]);

        $course = Course::where('course_id', $course_id)->first();
        $course->course_num = $request->input('course_num');
        $course->course_code = strtoupper($request->input('course_code'));
        $course->course_title = $request->input('course_title');
        $course->required = $request->input('required');

        $course->delivery_modality = $request->input('delivery_modality');
        $course->year = $request->input('course_year');
        $course->semester = $request->input('course_semester');
        $course->section = $request->input('course_section');

        if($course->save()){
            $request->session()->flash('success', 'Course updated');
        }else{
            $request->session()->flash('error', 'There was an error updating the course');
        }

        return redirect()->back();


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $course_id)
    {
        //
        $c = Course::where('course_id', $course_id)->first();
        $type = $c->type;

        if($c->delete()){
            $request->session()->flash('success','Course has been deleted');
        }else{
            $request->session()->flash('error', 'There was an error deleting the course');
        }

        if($type == 'assigned'){
            return redirect()->route('programWizard.step3', $request->input('program_id'));
        }else{
            return redirect()->route('home');
        }

    }

    // public function status(Request $request, $course_id)
    // {
    //     //
    //     $c = Course::where('course_id', $course_id)->first();

    //     if($c->status == -1){
    //         $c->status = 1;
    //     }else if($c->status == 1){
    //         $c->status = -1;
    //     }

    //     if($c->save()){
    //         $request->session()->flash('success','Course status has been updated');
    //     }else{
    //         $request->session()->flash('error', 'There was an error updating the course status');
    //     }

    //     return redirect()->route('programWizard.step3', $c->program_id);
    // }

    
    public function submit(Request $request, $course_id)
    {
        //
        $c = Course::where('course_id', $course_id)->first();
        $c->status = 1;

        if($c->save()){
            $request->session()->flash('success','Your answers have	been submitted successfully');
        }else{
            $request->session()->flash('error', 'There was an error submitting your answers');
        }

        return redirect()->route('home');
    }

    public function outcomeDetails(Request $request, $course_id)
    {
        //
        $l_outcomes = LearningOutcome::where('course_id', $course_id)->get();



        foreach($l_outcomes as $l_outcome){
            $i = $l_outcome->l_outcome_id;

            if($request->input('l_activities')== null){

                $l_outcome->learningActivities()->detach();

            }elseif (array_key_exists($i,$request->input('l_activities'))){
                $arr=$request->input('l_activities');
                $l_outcome->learningActivities()->detach();
                $l_outcome->learningActivities()->sync($arr[$i]);

            }else{

                $l_outcome->learningActivities()->detach();
            }

        }

        foreach($l_outcomes as $l_outcome){
            $i = $l_outcome->l_outcome_id;

            if($request->input('a_methods')== null){

                $l_outcome->assessmentMethods()->detach();

            }elseif (array_key_exists($i,$request->input('a_methods'))){
                $arr=$request->input('a_methods');
                $l_outcome->assessmentMethods()->detach();
                $l_outcome->assessmentMethods()->sync($arr[$i]);

            }else{

                $l_outcome->assessmentMethods()->detach();
            }

        }

        return redirect()->route('courseWizard.step4', $course_id)->with('success', 'Changes have been saved successfully.');
    }

    public function pdf($course_id)
    {
        //
        $course =  Course::where('course_id', $course_id)->first();
        $program = Program::where('program_id', $course->program_id)->first();
        $a_methods = AssessmentMethod::where('course_id', $course_id)->get();
        $l_activities = LearningActivity::where('course_id', $course_id)->get();
        $l_outcomes = LearningOutcome::where('course_id', $course_id)->get();
        $pl_outcomes = ProgramLearningOutcome::where('program_id', $course->program_id)->get();
        // $mappingScales = MappingScale::where('program_id', $course->program_id)->get();
        $mappingScales = MappingScale::join('mapping_scale_programs', 'mapping_scales.map_scale_id', "=", 'mapping_scale_programs.map_scale_id')
                                    ->where('mapping_scale_programs.program_id', $course->program_id)->get();
        $ploCategories = PLOCategory::where('program_id', $course->program_id)->get();

        $outcomeActivities = LearningActivity::join('outcome_activities','learning_activities.l_activity_id','=','outcome_activities.l_activity_id')
                                ->join('learning_outcomes', 'outcome_activities.l_outcome_id', '=', 'learning_outcomes.l_outcome_id' )
                                ->select('outcome_activities.l_activity_id','learning_activities.l_activity','outcome_activities.l_outcome_id', 'learning_outcomes.l_outcome')
                                ->where('learning_activities.course_id','=',$course_id)->get();

        $outcomeAssessments = AssessmentMethod::join('outcome_assessments','assessment_methods.a_method_id','=','outcome_assessments.a_method_id')
                                ->join('learning_outcomes', 'outcome_assessments.l_outcome_id', '=', 'learning_outcomes.l_outcome_id' )
                                ->select('assessment_methods.a_method_id','assessment_methods.a_method','outcome_assessments.l_outcome_id', 'learning_outcomes.l_outcome')
                                ->where('assessment_methods.course_id','=',$course_id)->get();

        $outcomeMaps = ProgramLearningOutcome::join('outcome_maps','program_learning_outcomes.pl_outcome_id','=','outcome_maps.pl_outcome_id')
                                ->join('learning_outcomes', 'outcome_maps.l_outcome_id', '=', 'learning_outcomes.l_outcome_id' )
                                ->select('outcome_maps.map_scale_value','outcome_maps.pl_outcome_id','program_learning_outcomes.pl_outcome','outcome_maps.l_outcome_id', 'learning_outcomes.l_outcome')
                                ->where('learning_outcomes.course_id','=',$course_id)->get();

        $pdf = PDF::loadView('courses.download', compact('course','program','l_outcomes','pl_outcomes','l_activities','a_methods','outcomeActivities', 'outcomeAssessments', 'outcomeMaps','mappingScales', 'ploCategories')) ;

        return $pdf->download('summary.pdf');
    }

}
