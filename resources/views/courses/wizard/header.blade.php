<div class="mt-2 mb-5">
    <div class="row">
        <div class="col">
            <h3>Course: {{$course->year}} {{$course->semester}} {{$course->course_code}}{{$course->course_num}} {{$course->section}}</h3>
            <h5 class="text-muted">{{$course->course_title}}</h5>
        </div>
        <div class="col">

            <div class="row">
                <div class="col">
                    <!-- Edit button -->
                    <button type="button" class="btn btn-secondary btn-sm float-right" style="width:200px" data-toggle="modal" data-target="#editCourseModal{{$course->course_id}}">
                        Edit Course Information
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="editCourseModal{{$course->course_id}}" tabindex="-1" role="dialog" aria-labelledby="editCourseModalLabel"aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCourseModalLabel">Edit Course information</h5>
                                    <button type="button" class="close"data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form method="POST" action="{{ action('CourseController@update', $course->course_id) }}">
                                    @csrf
                                    {{method_field('PUT')}}

                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label for="course_code" class="col-md-2 col-form-label text-md-right">Course Code</label>

                                            <div class="col-md-8">
                                                <input id="course_code" type="text" pattern="[A-Za-z]{4}" class="form-control @error('course_code') is-invalid @enderror" value="{{$course->course_code}}"
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
                                            <label for="course_num" class="col-md-2 col-form-label text-md-right">Course Number</label>

                                            <div class="col-md-8">
                                                <input id="course_num" type="number" class="form-control @error('course_num') is-invalid @enderror" name="course_num" value="{{$course->course_num}}" required autofocus>

                                                @error('course_num')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="course_title" class="col-md-2 col-form-label text-md-right">Course Title</label>

                                            <div class="col-md-8">
                                                <input id="course_title" type="text" class="form-control @error('course_title') is-invalid @enderror" name="course_title" value="{{$course->course_title}}" required autofocus>

                                                @error('course_title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="course_semester" class="col-md-2 col-form-label text-md-right">Year & Semester</label>

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
                                            <label for="course_section" class="col-md-2 col-form-label text-md-right">Course
                                                Section</label>

                                            <div class="col-md-4">
                                                <input id="course_section" type="text"
                                                    class="form-control @error('course_section') is-invalid @enderror"
                                                    name="course_section" required autofocus>

                                                @error('course_section')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="delivery_modality" class="col-md-2 col-form-label text-md-right">Delivery Modality</label>

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

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary col-2 btn-sm" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary col-2 btn-sm">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-2">
                <div class="col">
                    <!-- Assign instructor button  -->
                    <button type="button" class="btn btn-outline-primary btn-sm float-right" style="width:200px"
                        data-toggle="modal" data-target="#assignInstructorModal">Add Collaborators</button>

                    <!-- Modal -->
                    <div class="modal fade" id="assignInstructorModal" tabindex="-1" role="dialog"
                        aria-labelledby="assignInstructorModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="assignInstructorModalLabel">Add Collaborators to
                                        Course</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <p class="form-text text-muted">Collaborators can see and edit the course. Collaborators must first register with this web application to be added to a course.
                                        By adding a collaborator, a verification email will be sent to their email address.
                                        </p>

                                    <table class="table table-borderless">

                                            @if(count($courseUsers)===1)
                                                <tr class="table-active">
                                                    <th colspan="2">You have not added any collaborators to this course
                                                    </th>
                                                </tr>

                                            @else

                                                <tr class="table-active">
                                                    <th colspan="2">Collaborators</th>
                                                </tr>
                                                @foreach($courseUsers as $instructor)
                                                    @if($instructor->email != $user->email)
                                                        <tr>
                                                            <td>{{$instructor->email}}</td>
                                                            <td>
                                                                <form action="{{route('courses.unassign', $course->course_id)}}" method="POST" class="float-right ml-2">
                                                                    @csrf
                                                                    {{method_field('DELETE')}}
                                                                    <input type="hidden" class="form-check-input" name="program_id" value="{{$course->program_id}}">
                                                                    <input type="hidden" class="form-check-input" name="email" value="{{$instructor->email}}">
                                                                    <button type="submit" class="btn btn-danger btn-sm">Unassign</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach


                                            @endif
                                    </table>
                                </div>

                                <form method="POST" action="{{route('courses.assign', $course->course_id)}}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label for="email" class="col-md-3 col-form-label text-md-right">Collaborator Email</label>

                                            <div class="col-md-7">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" autofocus>

                                                @error('program')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <input type="hidden" class="form-input" name="program_id" value="{{$course->program_id}}">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary col-2 btn-sm" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary col-2 btn-sm">Assign</button>
                                    </div>
                                </form>
                            </div>



                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                        <button type="button" style="width:200px" class="btn btn-danger btn-sm float-right"
                        data-toggle="modal" data-target="#deleteConfirmation" >Delete Course</button>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmation" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteConfirmation">Delete Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                Are you sure you want to delete {{$course->course_code }} {{$course->course_num}} ?
                                </div>

                                <form action="{{route('courses.destroy', $course->course_id)}}" method="POST">
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <input type="hidden" class="form-check-input " name="program_id"
                                        value={{$course->program_id}}>

                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>


    </div>

</div>
