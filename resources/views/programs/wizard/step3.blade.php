@extends('layouts.app')

@section('content')

<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('programs.wizard.header')

            <div class="card">
                <h3 class="card-header wizard" >
                    Courses
                </h3>

                <div class="card-body">
                    <h6 class="card-subtitle mb-4 text-center lh-lg">
                        Input the required and non-required courses for this program (to the best of your knowledge). <strong>All courses need to have at least one assigned instructor to be mapped to a program.</strong> 
                    </h6>
                    <div id="courses">
                        <div class="row">
                            <div class="col">
                                @if ($programCourses->count() < 1)
                                    <div class="alert alert-warning wizard">
                                        <i class="bi bi-exclamation-circle-fill pr-2 fs-5"></i>There are no courses set for this program yet.                    
                                    </div>
                                @else 
                                    <table class="table table-light table-bordered" >
                                        <tr class="table-primary">
                                            <th class="w-25">Course Title</th>
                                            <th>Course Code</th>
                                            <th>Term</th>
                                            <th>Assigned</th>
                                            <th>Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>

                                        @foreach($programCourses as $programCourse)
                                        <tr >
                                            <td >
                                                {{$programCourse->course_title}}
                                                <p class="form-text text-muted">@if($programCourse->pivot->course_required == 1)Required @elseif($programCourse->pivot->course_required == 0) Not Required @endif</p>                                            
                                            </td>
                                            <td>
                                                {{$programCourse->course_code}} {{$programCourse->course_num}}
                                            </td>
                                            <td>
                                                {{$programCourse->year}} {{$programCourse->semester}}
                                            </td>
                                            <td>
                                            @if(count($programCoursesUsers[$programCourse->course_id]) > 0 )
                                                <i class="bi bi-check-circle-fill text-success pr-2"></i>Assigned
                                            @else
                                                <i class="bi bi-exclamation-circle-fill text-warning pr-2"></i>Unassigned                                                       
                                            @endif

                                            </td>
                                            <td>
                                            @if($programCourse->status == -1)
                                                <i class="bi bi-exclamation-circle-fill text-warning pr-2"></i>In Progress
                                            @else
                                                <i class="bi bi-check-circle-fill text-success pr-2"></i>Completed
                                            @endif
                                            </td>
                                            <td>
                                                <!-- Delete button -->
                                                <button style="width:70px" type="submit" class="btn btn-danger btn-sm float-right ml-2" data-toggle="modal" data-target="#deleteConfirmationCourse{{$programCourse->course_id}}">Remove</button>

                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteConfirmationCourse{{$programCourse->course_id}}" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationCourse" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Remove Confirmation</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                            Are you sure you want to Remove {{$programCourse->course_code . ' ' . $programCourse->course_num}} ?
                                                            </div>

                                                            <form action="{{route('courses.remove', $programCourse->course_id)}}" method="POST" class="float-right ml-2">
                                                                @csrf
                                                                {{method_field('GET')}}
                                                                <input type="hidden" class="form-check-input " name="program_id" value={{$program->program_id}}>
                                                                <div class="modal-footer">
                                                                <button style="width:60px" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                                                                <button style="width:70px" type="submit" class="btn btn-danger btn-sm">Remove</button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edit button -->
                                                <button type="button" style="width:60px" class="btn btn-secondary btn-sm float-right ml-2" data-toggle="modal" data-target="#editCourseModal{{$programCourse->course_id}}">
                                                    Edit
                                                </button>
                                                <!-- Edit Course Modal -->
                                                <div class="modal fade" id="editCourseModal{{$programCourse->course_id}}" tabindex="-1"
                                                    role="dialog" aria-labelledby="editCourseModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editCourseModalLabel">
                                                                    Edit
                                                                    Course</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <form method="POST"
                                                                action="{{ action('CourseController@update', $programCourse->course_id) }}">
                                                                @csrf
                                                                {{method_field('PUT')}}

                                                                <div class="modal-body">


                                                                    <div class="form-group row">
                                                                        <label for="course_code"
                                                                            class="col-md-3 col-form-label text-md-right">Course
                                                                            Code</label>

                                                                        <div class="col-md-8">
                                                                            <input id="course_code" type="text"
                                                                                pattern="[A-Za-z]{4}"
                                                                        class="form-control @error('course_code') is-invalid @enderror" value="{{$programCourse->course_code}}"
                                                                                name="course_code" required autofocus>

                                                                            @error('course_code')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                            <small id="helpBlock" class="form-text text-muted">
                                                                                Four letter course code e.g. SUST, COSC etc.
                                                                            </small>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <label for="course_num"
                                                                            class="col-md-3 col-form-label text-md-right">Course
                                                                            Number</label>

                                                                        <div class="col-md-8">
                                                                            <input id="course_num" type="text"
                                                                                class="form-control @error('course_num') is-invalid @enderror"
                                                                                name="course_num"
                                                                                value="{{$programCourse->course_num}}"
                                                                                required autofocus>

                                                                            @error('course_num')
                                                                            <span class="invalid-feedback"
                                                                                role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <label for="course_title"
                                                                            class="col-md-3 col-form-label text-md-right">Course
                                                                            Title</label>

                                                                        <div class="col-md-8">
                                                                            <input id="course_title" type="text"
                                                                                class="form-control @error('course_title') is-invalid @enderror"
                                                                                name="course_title"
                                                                                value="{{$programCourse->course_title}}"
                                                                                required autofocus>

                                                                            @error('course_title')
                                                                            <span class="invalid-feedback"
                                                                                role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <label for="course_semester" class="col-md-3 col-form-label text-md-right">Year and Semester</label>

                                                                        <div class="col-md-3">
                                                                            <select id="course_semester" class="form-control @error('course_semester') is-invalid @enderror"
                                                                                name="course_semester" required autofocus>
                                                                                <option @if($programCourse->semester === "W1") selected @endif value="W1">Winter Term 1</option>
                                                                                <option @if($programCourse->semester === "W2") selected @endif value="W2">Winter Term 2</option>
                                                                                <option @if($programCourse->semester === "S1") selected @endif value="S1">Summer Term 1</option>
                                                                                <option @if($programCourse->semester === "S2") selected @endif value="S2">Summer Term 2</option>

                                                                            @error('course_semester')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-md-2 float-right">
                                                                            <select id="course_year" class="form-control @error('course_year') is-invalid @enderror"
                                                                            name="course_year" required autofocus>
                                                                                <option @if($programCourse->year === 2021) selected @endif value="2021">2021</option>
                                                                                <option @if($programCourse->year === 2020) selected @endif value="2020">2020</option>
                                                                                <option @if($programCourse->year === 2019) selected @endif value="2019">2019</option>
                                                                                <option @if($programCourse->year === 2018) selected @endif value="2018">2018</option>
                                                                                <option @if($programCourse->year === 2017) selected @endif value="2017">2017</option>

                                                                            @error('course_year')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                            </select>
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <label for="course_section" class="col-md-3 col-form-label text-md-right">Course
                                                                            Section</label>

                                                                        <div class="col-md-4">
                                                                            <input id="course_section" type="text"
                                                                                class="form-control @error('course_section') is-invalid @enderror"
                                                                        name="course_section" autofocus value= {{$programCourse->section}}>

                                                                            @error('course_section')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <label for="delivery_modality" class="col-md-3 col-form-label text-md-right">Mode of Delivery</label>

                                                                        <div class="col-md-3 float-right">
                                                                            <select id="delivery_modality" class="form-control @error('delivery_modality') is-invalid @enderror"
                                                                            name="delivery_modality" required autofocus>
                                                                                <option @if($programCourse->delivery_modality === 'O') selected @endif value="O">Online</option>
                                                                                <option @if($programCourse->delivery_modality === 'I') selected @endif value="I">In-person</option>
                                                                                <option @if($programCourse->delivery_modality === 'B') selected @endif value="B">Hybrid</option>

                                                                            @error('delivery_modality')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <label for="required"
                                                                            class="col-md-3 col-form-label text-md-right">Required</label>
                                                                        <div class="col-md-6">

                                                                                @if($programCourse->required == -1)
                                                                                    <div class="form-check ">
                                                                                        <label class="form-check-label">
                                                                                            <input type="radio" class="form-check-input" name="required" value="1">
                                                                                            Required
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check">
                                                                                        <label class="form-check-label">
                                                                                            <input type="radio" class="form-check-input" name="required" value="-1" checked>
                                                                                            Not Required
                                                                                        </label>
                                                                                    </div>
                                                                                @elseif($programCourse->required == 1)
                                                                                    <div class="form-check ">
                                                                                        <label class="form-check-label">
                                                                                            <input type="radio" class="form-check-input" name="required" value="1" checked>
                                                                                            Required
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check">
                                                                                        <label class="form-check-label">
                                                                                            <input type="radio" class="form-check-input" name="required" value="-1" >
                                                                                            Not Required
                                                                                        </label>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="form-check ">
                                                                                        <label class="form-check-label">
                                                                                            <input type="radio" class="form-check-input" name="required" value="1" >
                                                                                            Required
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check">
                                                                                        <label class="form-check-label">
                                                                                            <input type="radio" class="form-check-input" name="required" value="-1" >
                                                                                            Not Required
                                                                                        </label>
                                                                                    </div>

                                                                                @endif
                                                                                <small class="form-text text-muted">
                                                                                    Is this course required by the program?
                                                                                </small>
                                                                        </div>
                                                                    </div>

                                                                    <input type="hidden" class="form-input" name="program_id" value={{$program->program_id}}>
                                                                    <input type="hidden" class="form-check-input" name="user_id" value={{Auth::id()}}>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-secondary col-2 btn-sm"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary col-2 btn-sm">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Assign instructor button  -->
                                                <button type="button" class="btn btn-outline-primary btn-sm ml-2 float-right" data-toggle="modal" data-target="#assignInstructorModal{{$programCourse->course_id}}">
                                                Assign Instructor
                                                </button>

                                                <!-- Assign Instructor Modal -->
                                                <div class="modal fade" id="assignInstructorModal{{$programCourse->course_id}}" tabindex="-1" role="dialog" aria-labelledby="assignInstructorModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="assignInstructorModalLabel">Assign Instructor to Course</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="container">
                                                                <p class="form-text text-muted">
                                                                    Instructors can see and edit the course (not the program). Instructors must first register with this web application to be assigned to a course.
                                                                    By adding an instructor, a verification email will be sent to their email address. <Strong>You can assign the course to yourself by clicking "Assign to Self"</Strong>.
                                                                </p>
                                                                <table class="table table-borderless">

                                                                    <tr class="table-active">
                                                                        <th colspan="2">Instructor</th>
                                                                    </tr>
                                                                    <div>
                                                                        @foreach($programCoursesUsers[$programCourse->course_id] as $programCourseUser)
                                                                                    <tr>
                                                                                        <td>{{$programCourseUser->email}}</td>
                                                                                        <td>
                                                                                            <form action="{{route('courses.unassign', $programCourse->course_id)}}" method="POST" class="float-right ml-2">
                                                                                                <!-- TODO: unassign on user id not email -->
                                                                                                @csrf
                                                                                                {{method_field('DELETE')}}
                                                                                                <input type="hidden" class="form-check-input" name="program_id" value="{{$program->program_id}}">
                                                                                                <input type="hidden" class="form-check-input" name="email" value="{{$programCourseUser->email}}">
                                                                                                <button type="submit"class="btn btn-danger btn-sm">Unassign</button>
                                                                                            </form>
                                                                                        </td>
                                                                                    </tr>
                                                                        @endforeach
                                                                    </div>

                                                                </table>
                                                            </div>

                                                            <form method="POST" action="{{route('courses.assign', $programCourse->course_id)}}">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="form-group row">
                                                                        <label for="email"
                                                                            class="col-md-3 col-form-label text-md-right">Instructor
                                                                            Email</label>

                                                                        <div class="col-md-7">
                                                                            <input id="email" type="email"
                                                                                class="form-control @error('email') is-invalid @enderror"
                                                                                name="email" autofocus>

                                                                            @error('program')
                                                                            <span class="invalid-feedback"
                                                                                role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <input type="hidden" class="form-input" name="program_id" value="{{$program->program_id}}">

                                                                </div>
                                                                <div class="modal-footer">

                                                                    <button type="button" class="btn btn-secondary col-2 btn-sm" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary col-2 btn-sm">Assign</button>
                                                                </form>

                                                                <form method="POST" action="{{route('courses.assign', $programCourse->course_id)}}">
                                                                    @csrf
                                                                    <input id="self" type="hidden" class="form-control" name="email" value="{{Auth::User()->email}}">
                                                                    <input type="hidden" class="form-input" name="program_id" value={{$program->program_id}}>
                                                                    <button type="submit" style="width:120px" class="btn btn-outline-primary btn-sm" >Assign to Self</button>
                                                                </form>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>                                        
                                        </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-sm col-2 mt-2 float-right" data-toggle="modal" data-target="#createCourseModal" style="background-color:#002145;color:white;">
                                ＋ Add New Course
                            </button>
                            <button type="button" class="btn btn-primary btn-sm col-2 mt-2 float-right" data-toggle="modal" data-target="#addCourseModal" style="margin-right: 10px; background-color:#002145;color:white;">
                                ＋ Add Exist Course
                            </button>
                        </div>
                    </div>

                    <!-- Create Course Modal -->
                    <div class="modal fade" id="createCourseModal" tabindex="-1" role="dialog" aria-labelledby="createCourseModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createCourseModalLabel">Add Course</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="{{ action('CourseController@store') }}">
                                    @csrf
                                    <div class="modal-body">

                                        <div class="form-group row">
                                            <label for="course_code"
                                                class="col-md-3 col-form-label text-md-right">Course Code</label>

                                                <div class="col-md-8">
                                                    <input id="course_code" type="text"
                                                        pattern="[A-Za-z]{4}"
                                                class="form-control @error('course_code') is-invalid @enderror"
                                                        name="course_code" required autofocus>

                                                    @error('course_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    <small id="helpBlock" class="form-text text-muted">
                                                        Four letter course code e.g. SUST, COSC etc.
                                                    </small>
                                                </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="course_num" class="col-md-3 col-form-label text-md-right">Course
                                                Number</label>

                                            <div class="col-md-8">
                                                <input id="course_num" type="text"
                                                    class="form-control @error('course_num') is-invalid @enderror"
                                                    name="course_num" required autofocus>

                                                @error('course_num')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="course_title"
                                                class="col-md-3 col-form-label text-md-right">Course Title</label>

                                            <div class="col-md-8">
                                                <input id="course_title" type="text"
                                                    class="form-control @error('course_title') is-invalid @enderror"
                                                    name="course_title" required autofocus>

                                                @error('course_title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="course_title" class="col-md-3 col-form-label text-md-right">Year and Semester</label>

                                            <div class="col-md-3">
                                                <select id="course_semester" class="form-control @error('course_semester') is-invalid @enderror"
                                                    name="course_semester" required autofocus>
                                                    <option value="W1">Winter Term 1</option>
                                                    <option value="W2">Winter Term 2</option>
                                                    <option value="S1">Summer Term 1</option>
                                                    <option value="S2">Summer Term 2</option>

                                                @error('course_semester')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                </select>
                                            </div>

                                            <div class="col-md-2 float-right">
                                                <select id="course_year" class="form-control @error('course_year') is-invalid @enderror"
                                                name="course_year" required autofocus>
                                                    <option value="2021">2021</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2016">2016</option>

                                                @error('course_year')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label for="course_section" class="col-md-3 col-form-label text-md-right">Course
                                                Section</label>

                                            <div class="col-md-4">
                                                <input id="course_section" type="text"
                                                    class="form-control @error('course_section') is-invalid @enderror"
                                                    name="course_section" autofocus>

                                                @error('course_section')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="delivery_modality" class="col-md-3 col-form-label text-md-right">
                                                Delivery Modality
                                            </label>

                                            <div class="col-md-3 float-right">
                                                <select id="delivery_modality" class="form-control @error('delivery_modality') is-invalid @enderror"
                                                name="delivery_modality" required autofocus>
                                                    <option value="O">online</option>
                                                    <option value="I">in-person</option>
                                                    <option value="B">blended</option>

                                                @error('delivery_modality')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Passes Information for Ministry Standards -->
                                        <div class="form-group row">
                                            <label for="standard_category_id" class="col-md-3 col-form-label text-md-right"> Map this course against</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="standard_category_id" id="standard_category_id" required>
                                                    <option value="" disabled selected hidden>Please Choose...</option>
                                                    @foreach($standard_categories as $standard_category)
                                                        <option value="{{ $standard_category->standard_category_id }}">{{$standard_category->sc_name}}</option>
                                                    @endforeach
                                                </select>
                                                <small id="helpBlock" class="form-text text-muted">
                                                    These are the standards from the Ministry of Advanced Education in BC.
                                                </small>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="required" class="col-md-3 col-form-label text-md-right">Required</label>
                                            <div class="col-md-6">

                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="required" value="1" >
                                                Required
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="required" value="0">
                                                Not Required
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">
                                                Is this course required by the program?
                                            </small>
                                            </div>
                                        </div>
                                        <!-- Passes 'program_id', type='assigned', and 'user_id' to be used by the CourseController store method -->
                                        <input type="hidden" class="form-check-input" name="program_id" value={{$program->program_id}}>
                                        <input type="hidden" class="form-check-input" name="type" value="assigned">
                                        <input type="hidden" class="form-check-input" name="user_id" value={{Auth::id()}}>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary col-2 btn-sm"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary col-2 btn-sm">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Create Course Modal -->

                    <!-- Add existing course Modal ( Drag and drop effect)-->
                    <div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="createCourseModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document" style="width:1250px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createCourseModalLabel">Add Existing Courses to {{$program->program}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <p>Select the courses you want to add to this program.</p>
                                    <form method="POST" id="addExistCourse" action="{{route('courseProgram.addCoursesToProgram', $program->program_id)}}">
                                        @csrf
                                        <input type="hidden" name="program_id" value="{{$program->program_id}}">
                                        <table class="table table-light table-bordered">
                                            <tr class="table-primary">
                                                <td></td>
                                                <th>Course Title</th>
                                                <th>Course Code</th>
                                                <th>Term</th>
                                                <th>Required </i></th>
                                            </tr>
                                            @foreach($userCoursesNotInProgram as $index => $course)
                                            <tr>
                                                <td>
                                                    <input class="form-check-input ml-0" type="checkbox" name="selectedCourses[]" value={{$course->course_id}} id="flexCheck{{$course->course_id}}">
                                                </td>
                                                <td>
                                                    {{$course->course_title}}
                                                </td>
                                                <td>
                                                    {{$course->course_code}} {{$course->course_num}}
                                                </td>
                                                <td>
                                                    {{$course->year}} {{$course->semester}}
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input ml-0" name="require{{$course->course_id}}" type="checkbox" id="flexSwitchCheck{{$course->course_id}}">
                                                    </div>                                           
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </form>
                                </div> 

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary col-2 btn-sm" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary col-2 btn-sm" form="addExistCourse">Add Selected</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="card-body mb-4">
                        <a href="{{route('programWizard.step2', $program->program_id)}}"><button class="btn btn-sm btn-primary col-3  float-left"><i class="bi bi-arrow-left ml-2"></i> Mapping Scale</button></a>
                        <a href="{{route('programWizard.step4', $program->program_id)}}"><button class="btn btn-sm btn-primary col-3 float-right">Begin Mapping Program <i class="bi bi-arrow-right ml-2"></i></button></a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script type="application/javascript" src="{{ asset('js/drag_drop.js') }}">
    $(document).ready(function () {

        $('[data-toggle="tooltip"]').tooltip();


        $("form").submit(function () {
            // prevent duplicate form submissions
            $(this).find(":submit").attr('disabled', 'disabled');
            $(this).find(":submit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

            });
    });
</script>
@endsection
