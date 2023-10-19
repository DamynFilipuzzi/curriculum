<?php

namespace Tests\Feature;



use App\Models\AssessmentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\LearningOutcome;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Program;
use App\Models\LearningActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


    class ProgramTest extends TestCase
{
    /**
     * 
     *
     * @return void
     */


    public function test_storing_new_program()
    {
        DB::table('users')->insert([
            'name' => 'Test Program',
            'email' => 'test-program@ubc.ca',
            'email_verified_at' => Carbon::now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);


        $user = User::where('email', 'test-program@ubc.ca')->first();


        $response=$this->actingAs($user)->post(route('programs.store'), [
            'program' => 'Bachelor of Testing',
            'campus' => 'Okanagan',
            'faculty' => 'Irving K. Barber Faculty of Science',
            'level' => 'Bachelors',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => $user->id
        ]);


        $program = Program::where('program', 'Bachelor of Testing')->orderBy('program_id', 'DESC')->first();


        $response->assertRedirect('/programWizard/'.($program->program_id).'/step1');


        $this->assertDatabaseHas('programs', [
            'program' => "Bachelor of Testing"
        ]);


        
    }

    public function test_save_plo()
    {
        $user = User::where('email', 'test-program@ubc.ca')->first();
        $program = Program::where('program', 'Bachelor of Testing')->orderBy('program_id', 'DESC')->first();

        $response=$this->actingAs($user)->post(route('program.outcomes.store'), [
            "new_pl_outcome" => [
        0 => "king"
            ],
      "new_pl_outcome_short_phrase" => [
        0 => "queen"
        ],
      "new_plo_category" => [
        0 => null
      ],
      "program_id" => $program->program_id
        ]);

        $this->assertDatabaseHas('program_learning_outcomes', [
            'pl_outcome' => "king"
        ]);

        
    }
    public function test_save_plo_category()
    {
        $user = User::where('email', 'test-program@ubc.ca')->first();
        $program = Program::where('program', 'Bachelor of Testing')->orderBy('program_id', 'DESC')->first();

        $response=$this->actingAs($user)->post(route('program.category.store'), [
      "new_plo_categories" => [
        0 =>"good"
      ],
      "program_id" => $program->program_id
        ]);

        $this->assertDatabaseHas('p_l_o_categories', [
            'plo_category' => "good"
        ]);
       
    }
/*
    public function test_program_outcome_import()
    {
        $user = User::where('email', 'test-program@ubc.ca')->first();
        $program = Program::where('program', 'Bachelor of Testing')->orderBy('program_id', 'DESC')->first();

        $response=$this->actingAs($user)->post(route('program.outcomes.import'), [
            "program_id" => $program->program_id
              ]);

                   
    }
    */
    public function test_addDefaultMappingScale()
    {
        $user = User::where('email', 'test-program@ubc.ca')->first();
        $program = Program::where('program', 'Bachelor of Testing')->orderBy('program_id', 'DESC')->first();

        $response=$this->actingAs($user)->post(route('mappingScale.addDefaultMappingScale'), [
            "mapping_scale_categories_id" => "3",
            "program_id" => $program->program_id
            ]);

              $this->assertDatabaseHas('mapping_scale_programs', [
                'map_scale_id' => "105"
            ]); 

           
    }

    public function test_mappingScale_store()
    {
        $user = User::where('email', 'test-program@ubc.ca')->first();
        $program = Program::where('program', 'Bachelor of Testing')->orderBy('program_id', 'DESC')->first();

        $response=$this->actingAs($user)->post(route('program.mappingScale.store'), [
            "title" => "Naruto",
            "abbreviation" => "fox",
            "colour" => "#c23210",
            "description" => "Hokage of Konoha",
            "program_id" => $program->program_id
            ]);

            $this->assertDatabaseHas('mapping_scales', [
                'title' => "Naruto"
            ]);

            
    }

    public function test_addCoursesToProgram()
    {
        $user = User::where('email', 'test-program@ubc.ca')->first();
        $program = Program::where('program', 'Bachelor of Testing')->orderBy('program_id', 'DESC')->first();

        
        $response=$this->actingAs($user)->post(route('courseProgram.addCoursesToProgram',$program->program_id), [
            "selectedCourses" => [
            0 => "36"],
           // "program_id" => $program->program_id
            ]);

            $this->assertDatabaseHas('course_programs', [
                'course_id' => "36"
            ]);

            
    }

    public function test_editCourseRequired()
    {
        $user = User::where('email', 'test-program@ubc.ca')->first();
        $program = Program::where('program', 'Bachelor of Testing')->orderBy('program_id', 'DESC')->first();

        $response=$this->actingAs($user)->post(route('courseProgram.editCourseRequired',$program->program_id), [
            "required" => "0",
            "note" => null,
            "course_id" => "36",
            "user_id" => "82",
          //  "program_id" => $program->program_id
            ]);

            $this->assertDatabaseHas('course_programs', [
                'course_required' => "0"
            ]);
            
    }

    public function test_duplicateProgram()
    {
        $user = User::where('email', 'test-program@ubc.ca')->first();
        $program = Program::where('program', 'Bachelor of Testing')->orderBy('program_id', 'DESC')->first();

        $response=$this->actingAs($user)->post(route('programs.duplicate',$program->program_id), [
            "_method" => "GET",
            "program" => "Bachelor of Science - Copy",
           // "program_id" => $program->program_id
            ]);

            $this->assertDatabaseHas('programs', [
                'program' => "Bachelor of Science - Copy"
            ]);

           
    }

    public function test_adding_collaborator()
    {
        $user = User::where('email', 'test-program@ubc.ca')->first();
        $program = Program::where('program', 'Bachelor of Testing')->orderBy('program_id', 'DESC')->first();

        DB::table('users')->insert([
            'name' => 'Test Course Collab',
            'email' => 'test-course-collab@ubc.ca',
            'email_verified_at' => Carbon::now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);

        $user2 = User::where('email', 'test-course-collab@ubc.ca')->first();

        $response=$this->actingAs($user)->post(route('programUser.add',$program->program_id), [
            "program_new_collabs" => [
        0 => "test-course-collab@ubc.ca"]
        ,
      "program_new_permissions" => [
        0 => "edit"]
        
            
            ]);

            $this->assertDatabaseHas('program_users', [
                "program_id" => $program->program_id,
                'permission' => "1"
            ]);
            User::where('email', 'test-program@ubc.ca')->delete();
            Program::where('program', 'Bachelor of Testing')->delete();
    }
}
