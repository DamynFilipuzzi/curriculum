@extends('layouts.app')

@section('content')

@include('modals.importCourseModal', ['myCourses' => $myCourses])

@include('modals.courseSchedule')

<style>
    .inputFieldDescription {
        font-size: 13px;
        text-align: justify;
        line-height: 2;
        color: #6c757d;
    }
</style>


<div class="m-auto" style="max-width:860px;height:100%;">
    <div class="m-3">
        <h3 class="text-center lh-lg fw-bold mt-4">Syllabus Generator</h3>

        <div class="text-center row justify-content-center">
            <div class="col-2" style="max-width:10%">
                <button type="submit" form="sylabusGenerator" class="btn m-0 p-0" style="background:none;border:none" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Save my syllabus">
                    <i class="btn btn-light rounded-circle m-2 text-secondary bi bi-clipboard2-check-fill"></i>
                    <p style="font-size:12px" class="text-muted m-0">SAVE</p>
                </button>
            </div>
            <div class="col-2" style="max-width:10%">
                <button type="submit" name="download" value="pdf" form="sylabusGenerator"
                    class="btn m-0 p-0" style="background:none;border:none" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Save and download my syllabus as PDF">
                    <i class="text-danger bi-file-pdf-fill btn btn-light rounded-circle m-2"></i>
                    <p style="font-size:12px" class="text-muted m-0">PDF</p>
                </button>
            </div>
            <div class="col-2" style="max-width:10%">
                <button type="submit" name="download" value="word" form="sylabusGenerator"
                    class="btn m-0 p-0" style="background:none;border:none" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Save and Download syllabus as Word"><i
                        class="bi-file-earmark-word-fill text-primary btn btn-light rounded-circle m-2"></i></i>
                    <p style="font-size:12px" class="text-muted m-0">WORD</p>
                </button>
            </div>
            <div class="col-2" style="max-width:10%">
                <span data-bs-toggle="modal" data-bs-target="#importExistingCourse">
                    <button type="button" class="btn m-0 p-0" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="Import an existing course" style="background:none;border:none"><i
                            class="text-secondary bi bi-box-arrow-in-down-left btn btn-light rounded-circle m-2"></i>
                            <p style="font-size:12px" class="text-muted m-0">IMPORT</p>
                        </button>
                </span>
            </div>
    
            @if (!empty($syllabus))
                @include('modals.syllabusCollabsModal', ['syllabus' => $syllabus, 'user' => $user])
                <div class="col-2" style="max-width:10%">
                    <span data-bs-toggle="modal" data-bs-target="#addSyllabusCollaboratorsModal{{$syllabus->id}}">
                        <button type="button" class="btn m-0 p-0" style="background:none;border:none" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Add collaborators to my syllabus"><i
                                class="text-primary bi bi-people-fill btn btn-light rounded-circle m-2"></i>
                            <p style="font-size:12px" class="text-muted m-0">PEOPLE</p>
                        </button>
                    </span>
                </div>
        
                @include('modals.duplicateModal', ['syllabus' => $syllabus])
                <div class="col-2" style="max-width:10%">
                    <span data-bs-toggle="modal" data-bs-target="#duplicateConfirmation">
                        <button type="button" class="btn m-0 p-0" style="background:none;border:none" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Make a copy of my syllabus"><i
                                class="btn btn-light rounded-circle m-2 text-success bi bi-files"></i>
                                <p style="font-size:12px" class="text-muted m-0">COPY</p>
                        </button>
                    </span>
                </div>
        
                @include('modals.deleteModal', ['syllabus' => $syllabus])
                <div class="col-2" style="max-width:10%">
                    <span data-bs-toggle="modal" data-bs-target="#deleteSyllabusConfirmation">
                        <button type="button" class="btn m-0 p-0" style="background:none;border:none" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Delete my syllabus"><i class="btn btn-danger rounded-circle m-2 bi bi-trash-fill"></i>
                            <p style="font-size:12px" class="text-muted m-0">DELETE</p>
                        </button>
                    </span>
                </div>
            @endif
        </div>
    </div>
    
    <div class="alert alert-primary d-flex align-items-center" role="alert" style="text-align:justify">
        <i class="bi bi-info-circle-fill pr-2 fs-3"></i>                        
        <div>
            To assist faculty in preparing their syllabi, this generator follows the policies, guidelines and templates provided by the <a target="_blank" rel="noopener noreferrer" href="https://senate.ubc.ca/okanagan/curriculum/forms">UBC Okanagan <i class="bi bi-box-arrow-up-right"></i></a> and <a target="_blank" rel="noopener noreferrer" href="https://senate.ubc.ca/policies-resources-support-student-success">UBC Vancouver <i class="bi bi-box-arrow-up-right"></i></a> senate. 
        </div>
    </div>

    <form class="row gy-4 courseInfo needs-validation" novalidate method="POST" id="sylabusGenerator" action="{{!empty($syllabus) ? action('SyllabusController@save', $syllabus->id) : action('SyllabusController@save')}}">
        @csrf

        <h5 class="fw-bold col-12 mt-5">Course Information</h5>

        <div class="col-9">
            <label for="courseTitle" class="form-label">Course Title<span class="requiredField"> *</span></label>
            <input oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="100" spellcheck="true" id = "courseTitle" name = "courseTitle" class ="form-control" type="text" placeholder="E.g. Intro to Software development" required value="{{ !empty($syllabus) ? $syllabus->course_title : '' }}">
            <div class="invalid-tooltip">
                Please enter the course title.
            </div>
        </div>
        
        <div class="col-3">
            <label for="campus" class="form-label">Campus<span class="requiredField"> *</span></label>
            <select class="form-select" id="campus" name="campus" form="sylabusGenerator" required>
                <option selected value=""> -- Campus -- </option>
                <option value="O">UBC Okanagan</option>
                <option value="V">UBC Vancouver</option>
            </select>
        </div>

        <div class="col-3">
            <label for="courseCode">Course Code<span class="requiredField"> *</span></label>
            <input id = "courseCode" pattern="[A-Za-z]+" minlength="1" name = "courseCode" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="4" class ="form-control" type="text" placeholder="E.g. CPSC" required value="{{ !empty($syllabus) ? $syllabus->course_code : '' }}">
            <div class="invalid-tooltip">
                Please enter the course code.
            </div>
        </div>
        
        <div class="col-3">
            <label for="courseNumber">Course Number<span class="requiredField"> *</span></label>
            <input id = "courseNumber" name = "courseNumber" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="3" class ="form-control" type="number" placeholder="E.g. 310" value="{{ !empty($syllabus) ? $syllabus->course_num : '' }}">
            <div class="invalid-tooltip">
                Please enter the course number.
            </div>
        </div>
        
        <div class="col-3">
            <label for="deliveryModality">Mode of Delivery<span class="requiredField"> *</span></label>
            <select id="deliveryModality" class="form-select" name="deliveryModality" required>
                <option value="O" {{!empty($syllabus) ? (($syllabus->delivery_modality == 'O') ? 'selected=true' : '') : ''}}>Online</option>
                <option value="I" {{!empty($syllabus) ? (($syllabus->delivery_modality == 'I') ? 'selected=true' : '') : ''}}>In-person</option>
                <option value="B" {{!empty($syllabus) ? (($syllabus->delivery_modality == 'B') ? 'selected=true' : '') : ''}}>Hybrid</option>
                <option value="M" {{!empty($syllabus) ? (($syllabus->delivery_modality == 'M') ? 'selected=true' : '') : ''}}>Multi-Access</option>
            </select>
            <div class="invalid-tooltip">
                Please enter the course mode of delivery.
            </div>
        </div>

        <div id="courseCredit" class="col-3"></div>

        <div class="col-3">
            <label for="courseYear">Course Year <span class="requiredField">*</span></label>
            <select id="courseYear" class="form-select" name="courseYear" required>
                <option disabled selected value="">  -- Year -- </option>
                <option value="2021" {{!empty($syllabus) ? (($syllabus->course_year == '2021') ? 'selected=true' : '') : ''}}>2021</option>
                <option value="2022" {{!empty($syllabus) ? (($syllabus->course_year == '2022') ? 'selected=true' : '') : ''}}>2022</option>
                <option value="2023" {{!empty($syllabus) ? (($syllabus->course_year == '2023') ? 'selected=true' : '') : ''}}>2023</option>
                <option value="2024" {{!empty($syllabus) ? (($syllabus->course_year == '2024') ? 'selected=true' : '') : ''}}>2024</option>
                <option value="2025" {{!empty($syllabus) ? (($syllabus->course_year == '2025') ? 'selected=true' : '') : ''}}>2025</option>
                <option value="2026" {{!empty($syllabus) ? (($syllabus->course_year == '2026') ? 'selected=true' : '') : ''}}>2026</option>
                <option value="2027" {{!empty($syllabus) ? (($syllabus->course_year == '2027') ? 'selected=true' : '') : ''}}>2027</option>
                <option value="2028" {{!empty($syllabus) ? (($syllabus->course_year == '2028') ? 'selected=true' : '') : ''}}>2028</option>
                <option value="2029" {{!empty($syllabus) ? (($syllabus->course_year == '2029') ? 'selected=true' : '') : ''}}>2029</option>
                <option value="2030" {{!empty($syllabus) ? (($syllabus->course_year == '2030') ? 'selected=true' : '') : ''}}>2030</option>
            </select>
            <div class="invalid-tooltip">
                Please enter the course year.
            </div>
        </div>

        <div class="col-3">
            <label for="courseSemester" class="form-label">Course Term <span class="requiredField">*</span></label>
            <select id="courseSemester" class="form-select" name="courseSemester" required>
                <option disabled selected value=""> -- Term --</option>
                <option value="W1" {{!empty($syllabus) ? (($syllabus->course_term == 'W1') ? 'selected=true' : '') : ''}}>Winter Term 1</option>
                <option value="W2" {{!empty($syllabus) ? (($syllabus->course_term == 'W2') ? 'selected=true' : '') : ''}}>Winter Term 2</option>
                <option value="S1" {{!empty($syllabus) ? (($syllabus->course_term == 'S1') ? 'selected=true' : '') : ''}}>Summer Term 1</option>
                <option value="S2" {{!empty($syllabus) ? (($syllabus->course_term == 'S2') ? 'selected=true' : '') : ''}}>Summer Term 2</option>
                <option value="O" {{!empty($syllabus) ? (($syllabus->course_term != 'W1' && $syllabus->course_term != 'W2' && $syllabus->course_term != 'S1' && $syllabus->course_term != 'S2') ? 'selected=true' : '') : ''}}>Other</option>
            </select>
            <div class="invalid-tooltip">
                Please enter the course term.
            </div>
        </div>

        <div id="courseSemesterOther" class="col-6">
            @if (!empty($syllabus))
                @if ($syllabus->course_term != 'W1' && $syllabus->course_term != 'W2' && $syllabus->course_term != 'S1' && $syllabus->course_term != 'S2')
                    <label class="form-label" for="courseSemesterOther">Other</label>
                    <input name="courseSemesterOther" type="text" class="form-control" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="49" value="{{$syllabus->course_term}}">
                @endif
            @endif
        </div>

        <div class="col-3">
            <label for="startTime">Class Start Time</label>
            <input oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="20" id = "startTime" name = "startTime" class ="form-control" type="text" placeholder="E.g. 1:00 PM" value="{{ !empty($syllabus) ? $syllabus->class_start_time : ''}}">
        </div>
        
        <div class="col-3">
            <label for="endTime">Class End Time</label>
            <input oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="20" id = "endTime" name = "endTime" class ="form-control" type="text" placeholder="E.g. 2:00 PM" value="{{ !empty($syllabus) ? $syllabus->class_end_time : ''}}" >
        </div>

        <div class="col-3">
            <label for="courseLocation">Course Location</label>
            <input id = "courseLocation" name = "courseLocation" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="150" class ="form-control" type="text" placeholder="E.g. WEL 140" value="{{ !empty($syllabus) ? $syllabus->course_location : ''}}">
        </div>
        
        <div id="officeLocation" class="col-3"></div>

        <div class="col">
            <label for="officeHour">Office Hours</label>
            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right" title="{{$inputFieldDescriptions['officeHours']}}"></i>
            <textarea oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="2500" spellcheck="true" id = "officeHour" name = "officeHour" class ="form-control" type="date" form="sylabusGenerator">{{ !empty($syllabus) ? $syllabus->office_hours : ''}}</textarea>
        </div>

        <div class="col-12">
            <label for="classDate">Class Meeting Days</label>
            <div class="classDate">
                <input id="monday" type="checkbox" name="schedule[]" value="Mon">
                <label for="monday" class="mr-2">Monday</label>

                <input id="tuesday" type="checkbox" name="schedule[]" value="Tue">
                <label for="tuesday" class="mr-2">Tuesday</label>

                <input id="wednesday" type="checkbox" name="schedule[]" value="Wed">
                <label for="wednesday" class="mr-2">Wednesday</label>

                <input id="thursday" type="checkbox" name="schedule[]" value= "Thu">
                <label for="thursday" class="mr-2">Thursday</label>

                <input id="friday" type="checkbox" name="schedule[]" value="Fri">
                <label for="friday" class="mr-2">Friday</label>
									
				<input id="saturday" type="checkbox" name="schedule[]" value="Sat">
                <label for="saturday" class="mr-2">Saturday</label>
            </div>
        </div>

        <h5 class="col-12 fw-bold">Course Instructor(s)</h5>

        @if (!empty($syllabus) && $syllabusInstructors->count() > 0)
            @foreach ($syllabusInstructors as $syllabusInstructor)
                <div class="instructor row g-3 align-items-end m-0 p-0">
                    <div class="col-5">
                        <label for="courseInstructor">Name<span class="requiredField"> *</span></label>
                        <input name = "courseInstructor[]" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="75" class ="form-control" type="text" placeholder="E.g. Dr. J. Doe" required value="{{$syllabusInstructor->name}}">
                        <div class="invalid-tooltip">
                        Please enter the course instructor.
                        </div>
                    </div>

                    <div class="col-5">
                        <label for="courseInstructorEmail">Email<span class="requiredField"> *</span></label>
                        <input name = "courseInstructorEmail[]" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="75" class ="form-control" type="email" placeholder="E.g. jane.doe@ubc.ca" value="{{$syllabusInstructor->email}}" required>
                        <div class="invalid-tooltip">
                            Please enter the instructors email.
                        </div>
                    </div>

                    <div class="col-2">
                        <button type="button" class="btn btn-danger col" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete instructor" onclick="delInstructor(this)">Delete</button>
                    </div>
                </div>
            @endforeach 
        @else 
            <div class="instructor row g-3 align-items-end m-0 p-0">
                <div class="col-5">
                    <label for="courseInstructor">Name<span class="requiredField"> *</span></label>
                    <input name = "courseInstructor[]" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="75" class ="form-control" type="text" placeholder="E.g. Dr. J. Doe" required >
                    <div class="invalid-tooltip">
                    Please enter the course instructor.
                    </div>
                </div>

                <div class="col-5">
                    <label for="courseInstructorEmail">Email<span class="requiredField"> *</span></label>
                    <input name = "courseInstructorEmail[]" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="75" class ="form-control" type="email" placeholder="E.g. jane.doe@ubc.ca" required>
                    <div class="invalid-tooltip">
                        Please enter the instructors email.
                    </div>
                </div>

                <div class="col-2">
                    <button type="button" class="btn btn-danger col" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete instructor" onclick="delInstructor(this)">Delete</button>
                </div>
            </div>
        @endif

        <a id="addInstructorBtn" class="link-primary col-2" onclick="addInstructor()" style="cursor:pointer"><i class="bi bi-plus"></i> Add instructor</a>

        <!-- Course Contacts -->
        <div id="courseContacts" class="col-12"></div>

        <div class="col-12">
            <label for="otherCourseStaff"><h5 class="fw-bold">Other Instructional Staff</h5></label>
            <span class="requiredBySenate"></span>
            <p class="inputFieldDescription">{{$inputFieldDescriptions['otherCourseStaff']}}</p>
            <div id="formatStaff" class="collapsibleNotes btn-primary rounded-3"
                style="overflow:hidden;transition:height 0.3s ease-out;height:auto" data-collapsed="false">
                <i class="bi bi-exclamation-triangle-fill fs-5 pl-2 pr-2 pb-1"></i> <span class="fs-6">Place each entry
                    on a newline for the best formatting
                    results.</span>
            </div>
            <textarea oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="1000" id="otherCourseStaff"
                data-formatnoteid="formatStaff"
                placeholder="E.g. Professor, Dr. Phil, PhD Clinical Psychology, ...&#10;E.g. Instructor, Bill Nye, BS Mechanical Engineering, ..."
                name="otherCourseStaff" class="form-control " form="sylabusGenerator"
                spellcheck="true" style="height:125px;">{{ !empty($syllabus) ? $syllabus->other_instructional_staff : ''}}</textarea>
        </div>

        <!-- Course Instructor Biographical Statement -->
        <div class="col-12" id="courseInstructorBio"></div>
        <!-- Course Prerequisites -->
        <div class="col-12" id="coursePrereqs"></div>
        <!-- Course Corequisites -->
        <div class="col-12" id="courseCoreqs"></div>
        <!-- Course Structure -->
        <div class="col-12" id="courseStructure"></div>
        <!-- Course Format -->
        <div class="col-12" id="courseFormat"></div>
        <!-- Course Overview -->
        <div class="col-12" id="courseOverview"></div>



        <div class="col-12">
            <label for="learningOutcome"><h5 class="fw-bold">Learning Outcomes</h5></label>
            <span class="requiredBySenate"></span>
            <p class="inputFieldDescription">{{$inputFieldDescriptions['learningOutcomes']}}</p>
            <p class="inputFieldDescription"><i>Upon successful completion of this course, students will be able to ...</i></p>
            <div id="formatCLOs" class="collapsibleNotes btn-primary rounded-3" style="overflow:hidden;transition:height 0.3s ease-out;height:auto" data-collapsed="false">
                <i class="bi bi-exclamation-triangle-fill fs-5 pl-2 pr-2 pb-1"></i> <span class="fs-6">Place each entry on a newline for the best formatting results.</span>                                        
            </div>                                            
            <textarea oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="17500" id = "learningOutcome" data-formatnoteid="formatCLOs" placeholder="E.g. Define ... &#10;E.g. Classify ..." name = "learningOutcome" class ="form-control" type="date" style="height:125px;" form="sylabusGenerator" spellcheck="true">{{ !empty($syllabus) ? $syllabus->learning_outcomes : ''}}</textarea>
        </div>

        <div class="col-12">
            <label for="learningAssessments"><h5 class="fw-bold">Assessments of Learning</h5></label>
            <span class="requiredBySenate"></span>
            <p class="inputFieldDescription">{{$inputFieldDescriptions['learningAssessments']}}</p>
            <div id="formatAssessments" class="collapsibleNotes btn-primary rounded-3" style="overflow:hidden;transition:height 0.3s ease-out;height:auto" data-collapsed="false">
                <i class="bi bi-exclamation-triangle-fill fs-5 pl-2 pr-2 pb-1"></i> <span class="fs-6">Place each entry on a newline for the best formatting results.</span>                                        
            </div>                                            
            <textarea oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="10000" id = "learningAssessments" data-formatnoteid="formatAssessments" placeholder="E.g. Presentation, 25%, Dec 1, ... &#10;E.g. Midterm Exam, 25%, Sept 31, ..." name = "learningAssessments" class ="form-control" type="date" style="height:125px;" form="sylabusGenerator" spellcheck="true">{{ !empty($syllabus) ? $syllabus->learning_assessments : ''}}</textarea>
        </div>

        <div class="col-12">
            <label for="learningActivities"><h5 class="fw-bold">Learning Activities</h5></label>
            <span class="requiredBySenate"></span>
            <p class="inputFieldDescription">{{$inputFieldDescriptions['learningActivities']}}</p>
            <div id="formatActivities" class="collapsibleNotes btn-primary rounded-3" style="overflow:hidden;transition:height 0.3s ease-out;height:auto" data-collapsed="false">
                <i class="bi bi-exclamation-triangle-fill fs-5 pl-2 pr-2 pb-1"></i> <span class="fs-6">Place each entry on a newline for the best formatting results.</span>                                        
            </div>                                            
            <textarea oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="52431" id = "learningActivities" data-formatnoteid="formatActivities" placeholder="E.g. Class participation consists of clicker questions, group discussions ... &#10;E.g. Students are expected to complete class pre-readings ..."name = "learningActivities" class ="form-control" type="date" style="height:125px;" form="sylabusGenerator" spellcheck="true">{{ !empty($syllabus) ? $syllabus->learning_activities : ''}}</textarea>
        </div>

        <!-- course schedule table -->
        
        <div class="col mb-3">
            <label for="courseSchedule">
                <h5 class="fw-bold">Course Schedule</h5>
            </label>
            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Create Course Schedule Table">
                <button @if (!empty($syllabus)) @if ($courseScheduleTblRowsCount> 0) hidden @endif @endif id="createTableBtn" type="button" class="btn btn-light rounded-pill m-2" data-bs-toggle="modal" data-bs-target="#createCourseScheduleTblModal" style="font-color:#002145">
                    <i class="bi bi-plus"></i>
                    <span class="iconify-inline" data-icon="fluent:table-48-filled"></span>
                </button>
            </span>
            <p class="inputFieldDescription">{{$inputFieldDescriptions['courseSchedule']}}</p>

        </div>

        <!-- course schedule toolbar -->
        <div id="courseScheduleTblToolbar" class="row mb-1" @if (!empty($syllabus)) @if ($courseScheduleTblRowsCount <= 0) hidden @endif @else hidden @endif>
            <div class="col-12 text-center">
                <span title="Row Limit Reached!" data-bs-trigger="manual" data-bs-toggle="popover"
                    data-bs-placement="bottom" data-bs-content="You have reached the maximum number of rows allowed">
                    <button type="button" class="col-2 addRow btn m-0 p-0" style="background:none;border:none" data-side="top" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add row on top">
                        <i class="btn btn-light rounded-pill m-2 text-secondary bi bi-plus">
                            <span class="iconify-inline ml-1" data-icon="clarity:view-columns-line" data-rotate="270deg"></span>
                        </i>
                        <p style="font-size:12px" class="text-muted m-0">ADD ROW TOP</p>
                    </button>

                    <button type="button" class="col-2 addRow btn m-0 p-0" style="background:none;border:none" data-side="bottom" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add row on bottom">
                        <i class="btn btn-light rounded-pill m-2 text-secondary bi bi-plus">
                            <span class="iconify-inline ml-1" data-icon="clarity:view-columns-line" data-rotate="90deg"></span>
                        </i>
                        <p style="font-size:12px" class="text-muted m-0">ADD ROW BOTTOM</p>
                    </button>                    
                </span>

                <span title="Column Limit Reached!" data-bs-trigger="manual" data-bs-toggle="popover"
                    data-bs-placement="bottom" data-bs-content="You have reached the maximum number of columns allowed">
                    <button type="button" class="col-2 addCol btn m-0 p-0" style="background:none;border:none" data-side="left" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add column on left">
                        <i class="btn btn-light rounded-pill m-2 text-secondary bi bi-plus">
                            <span class="iconify-inline ml-1" data-icon="clarity:view-columns-line" data-rotate="180deg"></span>
                        </i>
                        <p style="font-size:12px" class="text-muted m-0">ADD COLUMN LEFT</p>
                    </button>  

                    <button type="button" class="col-2 addCol btn m-0 p-0" style="background:none;border:none" data-side="right" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add column on left">
                        <i class="btn btn-light rounded-pill m-2 text-secondary bi bi-plus">
                            <span class="iconify-inline ml-1" data-icon="clarity:view-columns-line"></span>
                        </i>
                        <p style="font-size:12px" class="text-muted m-0">ADD COLUMN RIGHT</p>
                    </button>  
                </span>

                <button id="delCols" type="button" class="col-2 btn m-0 p-0" style="background:none;border:none" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete column(s)">
                    <i class="btn btn-light rounded-pill m-2 text-danger bi bi-trash-fill">
                        <span class="iconify-inline ml-1" data-icon="fluent:column-triple-20-filled"></span>
                    </i>
                    <p style="font-size:12px" class="text-muted m-0">DELETE COLUMN(S)</p>
                </button>

                
                <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Table" class="col-2">
                    <button id="delTable" type="button" class="btn m-0 p-0" style="background:none;border:none" data-bs-toggle="modal" data-bs-target="#delCourseScheduleTbl">
                        <i class="btn btn-danger rounded-pill m-2 bi bi-trash-fill">
                            <span class="iconify-inline" data-icon="fluent:table-48-filled"></span>
                        </i>
                        <p style="font-size:12px" class="text-muted m-0">DELETE TABLE</p>
                    </button>                    
                </span>
            </div>
        </div>

        <!-- div where course schedule table is created from scratch  -->
        <div id="courseScheduleTblDiv">
            @if (!empty($syllabus))
                @if ($courseScheduleTblRowsCount > 0)
                    <table id="courseScheduleTbl" class="table table-light align-middle reorder-tbl-rows">
                        <thead>
                            <tr class="table-primary">
                                <th></th>
                                @foreach ($myCourseScheduleTbl['rows'][0] as $headerIndex => $header)
                                <th>
                                    <textarea name="courseScheduleTblHeadings[]" form="sylabusGenerator" type="text"
                                        class="form-control" spellcheck="true"
                                        placeholder="Column heading here ...">{{$header->val}}</textarea>
                                </th>
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($myCourseScheduleTbl['rows'] as $rowIndex => $row)
                            @if ($rowIndex != 0)
                            <tr>
                                <td class="align-middle fs-5">↕</td>
                                @foreach ($row as $colIndex => $data)
                                <td>
                                    <textarea name="courseScheduleTblRows[]" form="sylabusGenerator" type="text"
                                        class="form-control" spellcheck="true"
                                        placeholder="Data here ...">{{$data->val}}</textarea>
                                </td>
                                @endforeach
                                <td class="align-middle">
                                    <i class="bi bi-x-circle-fill text-danger fs-4 btn"
                                        onclick="delCourseScheduleRow(this)"></i>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif
        </div>

        <!-- Late Policy -->
        <div class="col-12">
            <label for="latePolicy"><h5 class="fw-bold">Late policy</h5></label>
            <p class="inputFieldDescription">{{$inputFieldDescriptions['latePolicy']}}</p>
            <textarea style="height:125px" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="10000" id="latePolicy"
                name="latePolicy" class="form-control" type="date" form="sylabusGenerator"
                spellcheck="true">{{ !empty($syllabus) ? $syllabus->late_policy : ''}}</textarea>
        </div>
        <!-- Course Missing Exam -->
        <div class="col-12">
            <label for="missingExam"><h5 class="fw-bold">Missed exam policy</h5></label>
            <textarea style="height:125px" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="10000" id="missingExam"
                name="missingExam" class="form-control" type="date" form="sylabusGenerator"
                spellcheck="true">{{ !empty($syllabus) ? $syllabus->missed_exam_policy : ''}}</textarea>
        </div>
        <!-- Course Missed Activity Policy -->
        <div class="col-12">
            <label for="missingActivity"><h5 class="fw-bold">Missed Activity Policy</h5></label>
            <p class="inputFieldDescription">{{$inputFieldDescriptions['missedActivityPolicy']}}</p>
            <textarea style="height:125px" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="10000" id="missingActivity"
                name="missingActivity" class="form-control" type="date" form="sylabusGenerator"
                spellcheck="true">{{ !empty($syllabus) ? $syllabus->missed_activity_policy : ''}}</textarea>
        </div>
        <!-- Course Passing Criteria -->
        <div class="col-12">
            <label for="passingCriteria"><h5 class="fw-bold">Passing/Grading criteria</h5></label>
            <textarea style="height:125px" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="10000" id="passingCriteria"
                name="passingCriteria" class="form-control" type="date" form="sylabusGenerator"
                spellcheck="true">{{ !empty($syllabus) ? $syllabus->passing_criteria : ''}}</textarea>
        </div>
        <!-- Course Learning Materials -->
        <div class="col-12">
            <label for="learningMaterials"><h5 class="fw-bold">Learning Materials</h5></label>
            <p class="inputFieldDescription">{{$inputFieldDescriptions['learningMaterials']}}</p>
            <textarea style="height:125px" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="10000"
                id="learningMaterials" name="learningMaterials" class="form-control" type="date" form="sylabusGenerator"
                spellcheck="true">{{ !empty($syllabus) ? $syllabus->learning_materials : ''}}</textarea>
        </div>
        <!-- Course Learning Resources -->
        <div class="col-12">
            <label for="learningResources"><h5 class="fw-bold">Learning Resources</h5></label>
            <span class="requiredBySenate"></span>
            <p class="inputFieldDescription">{{$inputFieldDescriptions['learningResources']}}</p>
            <textarea style="height:125px" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="30000"
                id="learningResources" name="learningResources" class="form-control" form="sylabusGenerator"
                spellcheck="true">{{ !empty($syllabus) ? $syllabus->learning_resources : ''}}</textarea>
        </div>

        <!-- learning analytics -->
        <div class="col-12" id="learningAnalytics"></div>

        <div class="col-12">
            <h5  class="fw-bold">Optional Statements</h5>
            <p class="inputFieldDescription">
                The below are suggested sections to include in your syllabus which communicate various resources on campus that support student success.
                <a href="https://senate.ubc.ca/okanagan/curriculum/forms" target="_blank" rel="noopener noreferrer"><i class="bi bi-box-arrow-up-right"></i> These resources are also available online for your reference.</a>
            </p>
            <div class="form-check m-4">
                <div class="row" id="optionalSyllabus"></div>
            </div>
        </div>
    </form>

    <div class="m-3">
        <div class="text-center row justify-content-center">
            <div class="col-2" style="max-width:10%">
                <button type="submit" form="sylabusGenerator" class="btn m-0 p-0" style="background:none;border:none" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Save my syllabus">
                    <i class="btn btn-light rounded-circle m-2 text-secondary bi bi-clipboard2-check-fill"></i>
                    <p style="font-size:12px" class="text-muted m-0">SAVE</p>
                </button>
            </div>
            <div class="col-2" style="max-width:10%">
                <button type="submit" name="download" value="pdf" form="sylabusGenerator"
                    class="btn m-0 p-0" style="background:none;border:none" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Save and download my syllabus as PDF">
                    <i class="text-danger bi-file-pdf-fill btn btn-light rounded-circle m-2"></i>
                    <p style="font-size:12px" class="text-muted m-0">PDF</p>
                </button>
            </div>
            <div class="col-2" style="max-width:10%">
                <button type="submit" name="download" value="word" form="sylabusGenerator"
                    class="btn m-0 p-0" style="background:none;border:none" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Save and Download syllabus as Word"><i
                        class="bi-file-earmark-word-fill text-primary btn btn-light rounded-circle m-2"></i></i>
                    <p style="font-size:12px" class="text-muted m-0">WORD</p>
                </button>
            </div>
            <div class="col-2" style="max-width:10%">
                <span data-bs-toggle="modal" data-bs-target="#importExistingCourse">
                    <button type="button" class="btn m-0 p-0" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="Import an existing course" style="background:none;border:none"><i
                            class="text-secondary bi bi-box-arrow-in-down-left btn btn-light rounded-circle m-2"></i>
                            <p style="font-size:12px" class="text-muted m-0">IMPORT</p>
                        </button>
                </span>
            </div>
    
            @if (!empty($syllabus))
                @include('modals.syllabusCollabsModal', ['syllabus' => $syllabus, 'user' => $user])
                <div class="col-2" style="max-width:10%">
                    <span data-bs-toggle="modal" data-bs-target="#addSyllabusCollaboratorsModal{{$syllabus->id}}">
                        <button type="button" class="btn m-0 p-0" style="background:none;border:none" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Add collaborators to my syllabus"><i
                                class="text-primary bi bi-people-fill btn btn-light rounded-circle m-2"></i>
                            <p style="font-size:12px" class="text-muted m-0">PEOPLE</p>
                        </button>
                    </span>
                </div>
        
                @include('modals.duplicateModal', ['syllabus' => $syllabus])
                <div class="col-2" style="max-width:10%">
                    <span data-bs-toggle="modal" data-bs-target="#duplicateConfirmation">
                        <button type="button" class="btn m-0 p-0" style="background:none;border:none" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Make a copy of my syllabus"><i
                                class="btn btn-light rounded-circle m-2 text-success bi bi-files"></i>
                                <p style="font-size:12px" class="text-muted m-0">COPY</p>
                        </button>
                    </span>
                </div>
        
                @include('modals.deleteModal', ['syllabus' => $syllabus])
                <div class="col-2" style="max-width:10%">
                    <span data-bs-toggle="modal" data-bs-target="#deleteSyllabusConfirmation">
                        <button type="button" class="btn m-0 p-0" style="background:none;border:none" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Delete my syllabus"><i class="btn btn-danger rounded-circle m-2 bi bi-trash-fill"></i>
                            <p style="font-size:12px" class="text-muted m-0">DELETE</p>
                        </button>
                    </span>
                </div>
            @endif
        </div>
    </div>  
</div>

<script type="application/javascript">
    $(document).ready(function () {

        $(function () {
            $('[data-bs-toggle="popover"]').popover()
        })

        $('[data-bs-toggle="tooltip"]').tooltip();


        // event listener on select term dropdown
        $('#courseSemester').on('change', function(event) { 
            // insert a text input if user selects other
            if ($('#courseSemester').val() == 'O') {
                $('#courseSemesterOther').html(`
                    <label class="form-label" for="courseSemesterOther">Other</label>
                    <input class="form-control" type="text" name="courseSemesterOther" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="49">
                    <div class="invalid-tooltip">
                        Please specify the course term.
                    </div>
                `);
            } else {
                // remove html for other course term input
                $('#courseSemesterOther').html('');
            }
        });


        // event listener on create course schedule submit form button
        $('#createCourseScheduleTblForm').on('submit', function(event) { 
            // prevent default submit procedure
            event.preventDefault();
            event.stopPropagation();
            var createCourseScheduleTblModal = bootstrap.Modal.getInstance(document.getElementById('createCourseScheduleTblModal'));
            // get course schedule table div
            var courseScheduleTblDiv = document.getElementById('courseScheduleTblDiv');
            // create table if it doesn't exist
            if (!document.getElementById('courseScheduleTbl')) {
                // get num rows 
                var numRows = event.target.elements.numRows.value;
                // get num cols
                var numCols = event.target.elements.numCols.value;
                // create <table> element
                var tbl = document.createElement('table');
                tbl.setAttribute('id', 'courseScheduleTbl');
                tbl.setAttribute('class', 'table align-middle reorder-tbl-rows table-light');
                // create <thead> element
                var tblHead = document.createElement('thead');
                // create <tbody> element
                var tblBody = document.createElement('tbody');
                // iterate over rows 
                for (let rowIndex = 0; rowIndex < parseInt(numRows) + 1; rowIndex++) {
                    // create <row> element
                    var row = document.createElement('tr');
                    if (rowIndex === 0) row.setAttribute('class', 'table-primary');
                    // iterate over cols

                    for (let colIndex = 0; colIndex < parseInt(numCols) + 1; colIndex++) {
                        
                        // create <textarea>
                        var inputCell = document.createElement('textarea');
                        inputCell.setAttribute('form', 'sylabusGenerator');
                        inputCell.setAttribute('type', 'text');
                        inputCell.setAttribute('class', 'form-control');
                        inputCell.setAttribute('spellcheck', 'true');
                        inputCell.setAttribute('maxlength', '1000');
                        inputCell.setAttribute('onpaste', 'validateMaxlength');
                        inputCell.setAttribute('oninput', 'validateMaxlength()');
                        // if first row, create and style <th> cells, otherwise create and style <td> cells
                        if (rowIndex === 0) {
                            // create <th> element
                            headerCell = document.createElement('th');
                            if (colIndex != 0) {
                                // set input attributes for column headers
                                inputCell.setAttribute('placeholder', 'Column heading here ...');
                                inputCell.setAttribute('name', 'courseScheduleTblHeadings[]');
                                headerCell.appendChild(inputCell);
                                // put inputCell in <th>
                                headerCell.appendChild(inputCell);
                            }
                            // put <th> in <row>                           
                            row.appendChild(headerCell);
                        } else {
                            // create <td> element 
                            var cell = document.createElement('td');
                            if (colIndex == 0) {
                                cell.setAttribute('class', 'align-middle fs-5 draggable');
                                cell.addEventListener('mousedown', mouseDownHandler);
                                cell.innerHTML = "↕";
                            } else {
                                // set input attributes for data cells
                                inputCell.setAttribute('placeholder', 'Data here ...');                        
                                inputCell.setAttribute('name', 'courseScheduleTblRows[]');
                                // put inputCell in <td>
                                cell.appendChild(inputCell);
                            }
                            // put <td> in <row>
                            row.appendChild(cell);
                        }
                    }
                    // add action cell to row if it is not the header row
                    if (rowIndex != 0) {
                        // create <td> element for row actions
                        var actionsCell = document.createElement('td');
                        // center row actions
                        actionsCell.setAttribute('class', 'align-middle');
                        // create delete action icon
                        var delAction = document.createElement('i');
                        // style delete action icon
                        delAction.setAttribute('class', 'bi bi-x-circle-fill text-danger fs-4 btn');
                        // add on click listener to del row
                        delAction.onclick = delCourseScheduleRow;                        
                        // put <i> in <td>
                        actionsCell.appendChild(delAction);
                        // put actions cell in <row>
                        row.appendChild(actionsCell);
                        // put <row> in <tbody>
                        tblBody.appendChild(row);
                    } else {
                        // create empty <td>
                        var actionColTdHeader = document.createElement('th');
                        // put <td> in <row>
                        row.appendChild(actionColTdHeader);
                        // put <tr> in <thead>
                        tblHead.appendChild(row);
                    }
                }
                // put <thead> in <table>
                tbl.appendChild(tblHead);
                // put <tbody> in <table> 
                tbl.appendChild(tblBody);
                // put <table> in course schedule table div
                courseScheduleTblDiv.appendChild(tbl);
                // show the course schedule table toolbar
                $('#courseScheduleTblToolbar').removeAttr('hidden');
                // hide create table btn
                $('#createTableBtn').attr('hidden', 'true');
            }

            createCourseScheduleTblModal.hide();

        });

        // event listener on delete course schedule button
        $('#delCourseScheduleBtn').on('click', function(event) {
            var courseScheduleTblDiv = document.getElementById('courseScheduleTblDiv');
            // remove all child nodes 
            $(courseScheduleTblDiv).empty();
            // show create a course schedule table button
            $('#createTableBtn').removeAttr('hidden');
            $('#courseScheduleTblToolbar').attr('hidden', 'true');

            var delCourseScheduleTblModal = bootstrap.Modal.getInstance(document.getElementById('delCourseScheduleTbl'));
            // close modal
            delCourseScheduleTblModal.hide();
        });


        // event listener on add col buttons
        $('.addCol').on('click', function (event) { 
            // get the course schedule table 
            var courseScheduleTbl = document.getElementById('courseScheduleTbl');
            // if course schedule table exists, add col to the side indicated by the button clicked
            if (courseScheduleTbl) {
                // get which side to add the col to 
                var side = event.currentTarget.dataset.side;
                // get the num of cols in the tbl 
                var numCols = courseScheduleTbl.rows[0].cells.length;
                // add col if there are less than 6 cols
                if (numCols < parseInt($('#courseScheduleTblColsCount').attr('max')) + 2) {  
                    // add a new <td> to each <row>
                    Array.from(courseScheduleTbl.rows).forEach((row, rowIndex) => {
                        // create a <textarea>
                        var inputCell = document.createElement('textarea');
                        inputCell.setAttribute('form', 'sylabusGenerator');
                        inputCell.setAttribute('type', 'text');
                        inputCell.setAttribute('class', 'form-control');
                        inputCell.setAttribute('spellcheck', 'true');
                        inputCell.setAttribute('maxlength', '1000');
                        inputCell.setAttribute('onpaste', 'validateMaxlength');
                        inputCell.setAttribute('oninput', 'validateMaxlength()');
                        // set input attributes for column headers, otherwise set input attributes for data cells
                        if (rowIndex == 0) {
                            inputCell.setAttribute('placeholder', 'Column heading here ...');
                            inputCell.setAttribute('name', 'courseScheduleTblHeadings[]');
                        } else {
                            inputCell.setAttribute('placeholder', 'Data here ...');                        
                            inputCell.setAttribute('name', 'courseScheduleTblRows[]');
                        }
                        // add column on the correct side
                        switch (side) {
                            case 'left':
                                // put <td> in <row> at the front (insert col on left)
                                if (rowIndex == 0) {
                                    headerCell = document.createElement('th');
                                    headerCell.appendChild(inputCell);
                                    row.cells[0].after(headerCell);
                                    // row.prepend(headerCell);
                                } else {
                                    newCell = row.insertCell(1);
                                    newCell.appendChild(inputCell);
                                }
                                break;
                            case 'right': 
                                // put <td> in <row> at the back (insert col on the right)
                                newCell = row.insertCell(numCols - 1);
                                // if header row, make sure new cell has <th> tags
                                if (rowIndex == 0) newCell.outerHTML = `<th>${inputCell.outerHTML}</th>`;
                                // add <textarea> to data cell
                                newCell.appendChild(inputCell);
                                // row.appendChild(cell);
                                break;
                        }
                    });
                } else {
                    // 
                    var popover = bootstrap.Popover.getInstance(event.currentTarget.parentNode);
                    popover.show();
                    // hide popover after 3 seconds
                    setTimeout(function() { popover.hide(); }, 3000);
                }
            }
        });

        // event listener on delete column(s) button in course schedule table toolbar
        // updates the delCols confirmation modal with info about the columns
        $('#delCols').on('click', function (event) {
            // get the course schedule table 
            var courseScheduleTbl = document.getElementById('courseScheduleTbl');
            // if table exists, update and show delCols confirmation modal 
            if (courseScheduleTbl) {
                // get modal for deleting cols
                var delColsModalEl = document.getElementById('delColsModal');
                var delColsModal = new bootstrap.Modal(delColsModalEl);
                // get div where cols should be listed
                var courseScheduleTblColsListDiv = document.getElementById('courseScheduleTblColsList');
                // empty the div where cols should be listed to refresh the list
                $(courseScheduleTblColsListDiv).empty();
                // get the column cells from the first row
                var cols = courseScheduleTbl.rows[0].cells;
                // foreach col create a checkbox with label and place it in the delColsModal 
                Array.from(cols).forEach((col, colIndex) => {
                    // only add relevant col headers to del cols modal
                    if (colIndex < cols.length - 1 && colIndex > 0) {
                        // <div> foreach <input> and <label>
                        var colDiv = document.createElement('div');
                        // add bootstrap form elements styling
                        colDiv.setAttribute('class', 'form-check form-check-inline');
                        // create, style and set attributes for <input> 
                        var colCheckbox = document.createElement('input');
                        colCheckbox.setAttribute('id', 'col-heading-' + (colIndex + 1).toString());
                        colCheckbox.setAttribute('type', 'checkbox');
                        colCheckbox.setAttribute('name', 'colIndex');
                        colCheckbox.setAttribute('class', 'form-check-input');
                        colCheckbox.setAttribute('value', colIndex.toString());
                        colCheckbox.setAttribute('maxlength', '1000');
                        colCheckbox.setAttribute('onpaste', 'validateMaxlength');
                        colCheckbox.setAttribute('oninput', 'validateMaxlength()');
                        // create, style and set attributes for <label>
                        var colLabel = document.createElement('label');
                        colLabel.setAttribute('for', 'col-heading-' + (colIndex + 1).toString());
                        colLabel.setAttribute('class', 'form-check-label');
                        colLabel.innerHTML = (col.firstElementChild.value.length === 0) ? 'Column #' + (colIndex).toString() : col.firstElementChild.value; 
                        // put <input> in <div>
                        colDiv.appendChild(colCheckbox);
                        // put <label> in <div>
                        colDiv.appendChild(colLabel);
                        // put inner <div> in outer <div> 
                        courseScheduleTblColsListDiv.appendChild(colDiv);
                    }
                });
                // show the delCols confirmation modal
                delColsModal.show();
            }
        });

        $('#delColsForm').on('submit', function (event) {
            // prevent default submit procedure
            event.preventDefault();
            event.stopPropagation(); 
            // get del cols confirmation modal   
            var delColsModal = bootstrap.Modal.getInstance(document.getElementById('delColsModal'));   
            // get the columns to delete from the del cols confirmation form 
            var colsToDelete = $(this).serializeArray().map((input, index) => {
                return input.value;
            });
            // sort colsToDelete in descending order to ensure cols with the greatest positions are deleted first. 
            colsToDelete.sort(function(a, b) {return b - a});
            // get the course schedule table 
            var courseScheduleTbl = document.getElementById('courseScheduleTbl');
            // if table exists, del specified cols
            if (courseScheduleTbl) {
                // iterate over table rows 
                Array.from(courseScheduleTbl.rows).forEach((row, rowIndex) => {
                    // iterate over columns to delete
                    colsToDelete.forEach((colToDelete) => {
                        // delete cells from every row
                        row.deleteCell(colToDelete);
                        
                    });
                });
            }
            delColsModal.hide();
        });

        $('.addRow').on('click', function (event) { 
            // get the course schedule table 
            var courseScheduleTbl = document.getElementById('courseScheduleTbl');

            // if course schedule table has been created 
            if (courseScheduleTbl) {
                // get which side to add the row to 
                var side = event.currentTarget.dataset.side;
                // get the number of cols in the tbl
                var numCols = courseScheduleTbl.rows[0].cells.length;
                console.log(numCols);
                // if num rows in the tbl is less than the max, add row
                if (courseScheduleTbl.rows.length < $('#courseScheduleTblRowsCount').attr('max')) {
                    // create <textarea>
                    var inputCell = document.createElement('textarea');
                    inputCell.setAttribute('form', 'sylabusGenerator');
                    inputCell.setAttribute('name', 'courseScheduleTblRows[]');
                    inputCell.setAttribute('type', 'text');
                    inputCell.setAttribute('class', 'form-control');
                    inputCell.setAttribute('spellcheck', 'true');
                    inputCell.setAttribute('maxlength', '1000');
                    inputCell.setAttribute('onpaste', 'validateMaxlength');
                    inputCell.setAttribute('oninput', 'validateMaxlength()');
                    // set placeholder values for <textarea>
                    inputCell.setAttribute('placeholder', 'Data here ...');
                    // switch on side to add row
                    switch (side) {
                        case 'top':
                            // add a row at the top
                            let topRow = courseScheduleTbl.tBodies[0].insertRow(0);
                            // add a cell for each col to the new row
                            for (let colIndex = 0; colIndex < numCols - 1; colIndex++) {
                                // create  <td> element 
                                var cell = document.createElement('td');
                                if (colIndex == 0) {
                                    cell.setAttribute('class', 'align-middle fs-5 draggable');
                                    cell.addEventListener('mousedown', mouseDownHandler);
                                    cell.innerHTML = "↕";
                                } else { 
                                    // put inputCell in <td>
                                    cell.appendChild(inputCell.cloneNode());
                                }
                                topRow.appendChild(cell);

                            }
                            // create <td> element for row actions
                            var actionsCell = document.createElement('td');
                            // center row actions
                            actionsCell.setAttribute('class', 'align-middle');
                            // create delete action icon
                            var delAction = document.createElement('i');
                            // style delete action icon
                            delAction.setAttribute('class', 'bi bi-x-circle-fill text-danger fs-4 btn');
                            // add on click listener to del row
                            delAction.onclick = delCourseScheduleRow;                        
                            // put <i> in <td>
                            actionsCell.appendChild(delAction);
                            // put actions cell in <row>
                            topRow.appendChild(actionsCell);
                            break;

                        case 'bottom':
                            // add a row at the bottom
                            let bottomRow = courseScheduleTbl.tBodies[0].insertRow(-1);
                            // add a cell for each col to the new row
                            for (let colIndex = 0; colIndex < numCols - 1; colIndex++) {
                                // clone input cell to add it to a row multiple times
                                var cell = document.createElement('td');
                                if (colIndex == 0) {
                                    cell.setAttribute('class', 'align-middle fs-5 draggable');
                                    cell.addEventListener('mousedown', mouseDownHandler);
                                    cell.innerHTML = "↕";
                                } else { 
                                    // put inputCell in <td>
                                    cell.appendChild(inputCell.cloneNode());
                                }
                                bottomRow.appendChild(cell);
                            }
                            // create <td> element for row actions
                            var actionsCell = document.createElement('td');
                            // center row actions
                            actionsCell.setAttribute('class', 'align-middle');
                            // create delete action icon
                            var delAction = document.createElement('i');
                            // style delete action icon
                            delAction.setAttribute('class', 'bi bi-x-circle-fill text-danger fs-4 btn');
                            // add on click listener to del row
                            delAction.onclick = delCourseScheduleRow;                        
                            // put <i> in <td>
                            actionsCell.appendChild(delAction);
                            // put actions cell in <row>
                            bottomRow.appendChild(actionsCell);
                            break;
                        default:
                            let row = courseScheduleTbl.insertRow();                
                    }
                } else {
                    var popover = bootstrap.Popover.getInstance(event.currentTarget.parentNode);
                    popover.show();
                    // hide popover after 3 seconds
                    setTimeout(function() { popover.hide(); }, 3000);
                }
            }
        });

        var syllabus = <?php echo json_encode($syllabus);?>;
        $('[data-bs-toggle="tooltip"]').tooltip();
        // add on change event listener to campus select 
        $('#campus').change(function(){
            onChangeCampus();
            });
        
        // use custom bootstrap input validation
        $('#sylabusGenerator').submit(function(event){
            var invalidFields = $('#sylabusGenerator :invalid');
            if (invalidFields.length > 0) {
                event.preventDefault();
                event.stopPropagation();
                $('html, body').animate({
                    scrollTop: $(invalidFields[0]).offset().top - 100,
                });
                $(this).addClass('was-validated');
            // all fields are valid
            } else {
                $(this).removeClass('was-validated');
            }
        });
        
        // add on click event listener to import course info button
        $('#importButton').click(importCourseInfo);
        // trigger campus dropdown change based on saved syllabus
        if (syllabus['campus'] === 'O') {
            $('#campus').val('O').trigger('change');
        } else if (syllabus['campus'] === 'V') {
            $('#campus').val('V').trigger('change');
        }
        // use saved class meeting days
        if (syllabus['class_meeting_days']) {
            // split class meeting days string into an array
            const classMeetingDays = syllabus['class_meeting_days'].split("/");
            // mark days included in classMeetingDays as checked

            if (classMeetingDays.includes('Mon')) {
                $('#monday').attr('checked', 'true');
            }
            if (classMeetingDays.includes('Tue')) {
                $('#tuesday').attr('checked', 'true');
            }
            if (classMeetingDays.includes('Wed')) {
                $('#wednesday').attr('checked', 'true');
            }
            if (classMeetingDays.includes('Thu')) {
                $('#thursday').attr('checked', 'true');
            }
            if (classMeetingDays.includes('Fri')) {
                $('#friday').attr('checked', 'true');
            }
			if (classMeetingDays.includes('Sat')) {
                $('#saturday').attr('checked', 'true');
            }
        }
        // use event delegation to show format note on focus in
        document.getElementById("sylabusGenerator").addEventListener('focusin', function (event) {
            var formatNoteId = event.target.dataset.formatnoteid;
            if (formatNoteId) {
                var note = document.querySelector('#' + formatNoteId);
                var isCollapsed = note.dataset.collapsed === 'true';

                if (isCollapsed) {
                    expandSection(note);
                    note.setAttribute('data-collapsed', 'false');
                } 
            }
        });
        
        // use event delegation to hide format note on focus out
        document.getElementById("sylabusGenerator").addEventListener('focusout', function (event) {
            var formatNoteId = event.target.dataset.formatnoteid;
            if (formatNoteId) {
                var note = document.querySelector('#' + formatNoteId);
                var isCollapsed = note.dataset.collapsed === 'true';

                if (!isCollapsed) {
                    collapseSection(note);
                    note.setAttribute('data-collapsed', 'true');
                }

            }
        });
        // update syllabus form with the campus specific info
        onChangeCampus();
    });

    // delete a course schedule row
    function delCourseScheduleRow(submitter) {
        // get delete row confirmation modal
        var delRowModalEl = document.getElementById('delRowModal');
        // instantiate new bootstrap modal
        var delRowModal = new bootstrap.Modal(delRowModalEl);
        // set on click listener for delete confirmation
        $('#delRowBtn').on('click', function (event) {
            // delete row
            (submitter.target) ? $(submitter.target).parents('tr').remove() : $(submitter).parents('tr').remove();
            // hide modal
            delRowModal.hide();
        });
        // show modal
        delRowModal.show();

    }

    function addInstructor() {
        instructorHTML =   `
        <div class="instructor row g-3 align-items-end m-0 p-0">
            <div class="col-5">
                <label for="courseInstructor">Name<span class="requiredField"> *</span></label>
                <input id = "courseInstructor" name = "courseInstructor[]" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="75" class ="form-control" type="text" placeholder="E.g. Dr. J. Doe" required>
                <div class="invalid-tooltip">
                    Please enter the course instructor.
                </div>
            </div>

            <div class="col-5">
                <label for="courseInstructorEmail">Email<span class="requiredField"> *</span></label>
                <input id = "courseInstructorEmail" name = "courseInstructorEmail[]" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="75" class ="form-control" type="email" placeholder="E.g. jane.doe@ubc.ca" required value="">
                <div class="invalid-tooltip">
                    Please enter the instructors email.
                </div>
            </div>
            
            <div class="col-2">
                <button type="button" class="btn btn-danger col" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete instructor" onclick="delInstructor(this)">Delete</button>
            </div>
        </div>`;

        $('#addInstructorBtn').before(instructorHTML);
    }

    function delInstructor(delInstructorBtn) {
        // at least 1 instructor is required
        if ($('.instructor').length > 1)
            delInstructorBtn.parentNode.parentNode.remove();
    }

    // Import course info into using GET AJAX call
    function importCourseInfo() {
        var course_id = $('input[name="importCourse"]:checked').val();
        $.ajax({
            type: "GET",
            url: "/syllabusGenerator/import/course",
            data: {course_id : course_id},
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
        }).done(function(data) {
            // get fields we want to populate
            var c_title_input = $('#courseTitle');
            var c_code_input = $('#courseCode');
            var c_num_input = $('#courseNumber');
            var c_del_input = $('#deliveryModality');
            var c_year_input = $('#courseYear');
            var c_term_input = $('#courseSemester');
            var a_method_input = $('#learningAssessments');
            var l_outcome_input = $('#learningOutcome');
            var l_activities_input = $('#learningActivities');
            // get saved data 
            var decode_data = JSON.parse(data);
            var c_title = decode_data['c_title'];
            var c_code = decode_data['c_code'];
            var c_num = decode_data['c_num'];
            var c_del = decode_data['c_del'];
            var c_year = decode_data['c_year'];
            var c_term = decode_data['c_term'];
            var a_methods = decode_data['a_methods'];
            var l_outcomes = decode_data['l_outcomes'];
            var l_activities = decode_data['l_activities'];
            // format saved data
            var a_methods_text = "";
            var l_outcomes_text = "";
            var l_activities_text = "";
            a_methods.forEach(element => {
                a_methods_text += element.a_method + " " + element.weight + "%\n";
            });
            for(var i = 0; i < l_outcomes.length; i++) {
                l_outcomes_text += (i+1) + ". " + l_outcomes[i].l_outcome + "\n";
            }
            for(var i = 0; i < l_activities.length; i++) {
                l_activities_text += l_activities[i].l_activity + "\n";
            }
            // import saved and formatted data
            c_title_input.val(c_title);
            c_code_input.val(c_code);
            c_num_input.val(c_num);
            c_del_input.val(c_del);

            c_year_input.val(c_year);
            c_term_input.val(c_term);
            a_method_input.val(a_methods_text);
            l_outcome_input.val(l_outcomes_text);
            l_activities_input.val(l_activities_text);
        });
    }

    function expandSection(element) {
        // get the height of the element's inner content, regardless of its actual size
        var sectionHeight = element.scrollHeight;
        
        // have the element transition to the height of its inner content
        element.style.height = sectionHeight + 'px';

        // when the next css transition finishes (which should be the one we just triggered)
        element.addEventListener('transitioned', function(e) {
            // remove this event listener so it only gets triggered once
            element.removeEventListener('transitioned', arguments.callee);
            
            // remove "height" from the element's inline styles, so it can return to its initial value
            element.style.height = null;
        });
        
        // mark the section as "currently not collapsed"
        element.setAttribute('data-collapsed', 'false');
    }

    function collapseSection(element) {
        // get the height of the element's inner content, regardless of its actual size
        var sectionHeight = element.scrollHeight;

        // temporarily disable all css transitions
        var elementTransition = element.style.transition;
        element.style.transition = '';
        
        // on the next frame (as soon as the previous style change has taken effect),
        // explicitly set the element's height to its current pixel height, so we 
        // aren't transitioning out of 'auto'
        requestAnimationFrame(function() {
            element.style.height = sectionHeight + 'px';
            element.style.transition = elementTransition;
            
            // on the next frame (as soon as the previous style change has taken effect),
            // have the element transition to height: 0
            requestAnimationFrame(function() {
            element.style.height = 0 + 'px';
            });
        });
        
        // mark the section as "currently collapsed"
        element.setAttribute('data-collapsed', 'true');
    }

    // Function changes optional verison of syllabus
    function onChangeCampus() {

        $('.courseInfo').tooltip(
            {
                selector: '.has-tooltip'
            }     
        );

        // list of vancouver syllabus resources
        var vancouverOptionalList = `
            @if (!isset($selectedVancouverSyllabusResourceIds)) 
                @foreach($vancouverSyllabusResources as $index => $vSyllabusResource)
                    <div class="col-6">
                        <input class="form-check-input " id="{{$vSyllabusResource->id_name}}" type="checkbox" name="vancouverSyllabusResources[{{$vSyllabusResource->id}}]" value="{{$vSyllabusResource->id_name}}" checked>
                        <label class="form-check-label mb-2" for="{{$vSyllabusResource->id_name}}">{{$vSyllabusResource->title}}</label>   
                    <div>
                @endforeach
            @else
                @foreach($vancouverSyllabusResources as $index => $vSyllabusResource)
                    <div class="col-6">
                        <input class="form-check-input" id="{{$vSyllabusResource->id_name}}" type="checkbox" name="vancouverSyllabusResources[{{$vSyllabusResource->id}}]" value="{{$vSyllabusResource->id_name}}" {{in_array($vSyllabusResource->id, $selectedVancouverSyllabusResourceIds) ? 'checked' : ''}}>
                        <label class="form-check-label  mb-2" for="{{$vSyllabusResource->id_name}}">{{$vSyllabusResource->title}}</label>   
                    </div>
                @endforeach
            @endif

            `;
        // list of okanagan syllabus resources
        var okanaganOptionalList = `
            @if (!isset($selectedOkanaganSyllabusResourceIds)) 
                @foreach($okanaganSyllabusResources as $index => $oSyllabusResource)
                    <div class="col-6">
                        <input class="form-check-input " id="{{$oSyllabusResource->id_name}}" type="checkbox" name="okanaganSyllabusResources[{{$oSyllabusResource->id}}]" value="{{$oSyllabusResource->id_name}}" checked>
                        <label class="form-check-label mb-2" for="{{$oSyllabusResource->id_name}}">{{$oSyllabusResource->title}}</label>   
                    </div>
                @endforeach
            @else
                @foreach($okanaganSyllabusResources as $index => $oSyllabusResource)
                    <div class="col-6 ">
                        <input class="form-check-input " id="{{$oSyllabusResource->id_name}}" type="checkbox" name="okanaganSyllabusResources[{{$oSyllabusResource->id}}]" value="{{$oSyllabusResource->id_name}}" {{in_array($oSyllabusResource->id, $selectedOkanaganSyllabusResourceIds) ? 'checked' : ''}}>
                        <label class="form-check-label mb-2" for="{{$oSyllabusResource->id_name}}">{{$oSyllabusResource->title}}</label>   
                    </div>
                @endforeach
            @endif
            `;

        var courseCredit = `
            <label for="courseCredit">Course Credit <span class="requiredField">*</span></label>
            <input maxlength="2" oninput="validateMaxlength()" onpaste="validateMaxlength()" name = "courseCredit" class ="form-control" type="number" min="0" step="1"placeholder="E.g. 3" required value="{{isset($vancouverSyllabus) ? $vancouverSyllabus->course_credit : ''}}">
            <div class="invalid-tooltip">
                Please enter the course course credits.
            </div>
            `;
        
        var officeLocation = `
            <label for="officeLocation">Office Location <span class="requiredField">*</span></label>
            <i class="bi bi-info-circle-fill has-tooltip"  data-bs-placement="right" title="{{$inputFieldDescriptions['officeLocation']}}"></i>
            <input maxlength="191" oninput="validateMaxlength()" onpaste="validateMaxlength()" name = "officeLocation" class ="form-control" type="text" placeholder="E.g. WEL 140" value="{{isset($vancouverSyllabus) ? $vancouverSyllabus->office_location : ''}}" required>
            <div class="invalid-tooltip">
                Please enter your office location.
            </div>

            `;

        var courseDescription = `
            <div class="col mb-3">
                <label for="courseDescription">Course Description</label>
                <i class="bi bi-info-circle-fill has-tooltip"  data-bs-placement="right" title="{{$inputFieldDescriptions['courseDescription']}}"></i>
                <textarea maxlength="7500" oninput="validateMaxlength()" onpaste="validateMaxlength()"  name = "courseDescription" class ="form-control" type="date" form="sylabusGenerator">{{isset($vancouverSyllabus) ? $vancouverSyllabus->course_description : ''}}</textarea>
            </div>
            `;

        var courseContacts = `
            <label for="courseContacts"><h5 class="fw-bold">Contacts</h5></label>
            <span class="requiredBySenate"></span>
            <p class="inputFieldDescription">{{$inputFieldDescriptions['courseContacts']}}</p>
            <div id="formatContacts" class="collapsibleNotes btn-primary rounded-3" style="overflow:hidden;transition:height 0.3s ease-out;height:auto" data-collapsed="false">
                <i class="bi bi-exclamation-triangle-fill fs-5 pl-2 pr-2 pb-1"></i> <span class="fs-6">Place each entry on a newline for the best formatting results.</span>                                        
            </div>                                            
            <textarea style="height:125px" maxlength="7500" oninput="validateMaxlength()" onpaste="validateMaxlength()"  id="courseContacts" data-formatnoteid="formatContacts" name = "courseContacts" placeholder="E.g. Professor, Jane Doe, jane.doe@ubc.ca, +1 234 567 8900, ... &#10;Teaching Assistant, John Doe, john.doe@ubc.ca, ..."class ="form-control" type="date" form="sylabusGenerator">{{isset($vancouverSyllabus) ? $vancouverSyllabus->course_contacts : ''}}</textarea>
            `;

        var coursePrereqs = `
                <label for="coursePrereqs"><h5 class="fw-bold">Course Prerequisites</h5></label>
                <span class="requiredBySenate"></span>
                <p class="inputFieldDescription">{{$inputFieldDescriptions['coursePrereqs']}}</p>
                <div id="formatPrereqs" class="collapsibleNotes btn-primary rounded-3" style="overflow:hidden;transition:height 0.3s ease-out;height:auto" data-collapsed="false">
                    <i class="bi bi-exclamation-triangle-fill fs-5 pl-2 pr-2 pb-1"></i> <span class="fs-6">Place each entry on a newline for the best formatting results.</span>                                        
                </div>                                            
                <textarea style="height:125px" maxlength="7500" oninput="validateMaxlength()" onpaste="validateMaxlength()"  id="coursePrereqs" data-formatnoteid="formatPrereqs"name = "coursePrereqs" placeholder="E.g. CPSC 210 or EECE 210 or CPEN 221 &#10;E.g. CPSC 121 or MATH 220"class ="form-control" type="text" form="sylabusGenerator" >{{isset($vancouverSyllabus) ? $vancouverSyllabus->course_prereqs : ''}}</textarea>
            `;

        var courseCoreqs = `
                <label for="courseCoreqs"><h5 class="fw-bold">Course Corequisites</h5></label>
                <span class="requiredBySenate"></span>
                <p class="inputFieldDescription">{{$inputFieldDescriptions['courseCoreqs']}}</p>
                <div id="formatCoreqs"class="collapsibleNotes btn-primary rounded-3" style="overflow:hidden;transition:height 0.3s ease-out;height:auto" data-collapsed="false" >
                    <i class="bi bi-exclamation-triangle-fill fs-5 pl-2 pr-2 pb-1"></i> <span class="fs-6">Place each entry on a newline for the best formatting results.</span>                                        
                </div>                                            
                <textarea style="height:125px" maxlength="7500" oninput="validateMaxlength()" onpaste="validateMaxlength()"  id = "courseCoreqs" data-formatnoteid="formatCoreqs"placeholder="E.g. CPSC 107 or CPSC 110 &#10;E.g. CPSC 210" name = "courseCoreqs" class ="form-control" type="text" form="sylabusGenerator">{{isset($vancouverSyllabus) ? $vancouverSyllabus->course_coreqs : ''}}</textarea>
            `;
        var courseInstructorBio = `
            <label for="courseInstructorBio"><h5 class="fw-bold">Course Instructor Biographical Statement</h5></label>
            <p class="inputFieldDescription">{{$inputFieldDescriptions['instructorBioStatement']}}</p>
            <textarea style="height:125px" maxlength="7500" oninput="validateMaxlength()" onpaste="validateMaxlength()"  id = "courseInstructorBio" name = "courseInstructorBio" class ="form-control" form="sylabusGenerator" spellcheck="true">{{isset($vancouverSyllabus) ? $vancouverSyllabus->instructor_bio : ''}}</textarea>
            
            `;     
        
        var courseStructure = `
                <label for="courseStructure"><h5 class="fw-bold">Course Structure</h5></label>
                <span class="requiredBySenate"></span>
                <p class="inputFieldDescription">{{$inputFieldDescriptions['courseStructure']}}</p>
                <textarea maxlength="7500" style="height:125px" oninput="validateMaxlength()" onpaste="validateMaxlength()"  name = "courseStructure" class ="form-control" type="text" form="sylabusGenerator" spellcheck="true">{{isset($vancouverSyllabus) ? $vancouverSyllabus->course_structure : ''}}</textarea>
            `;

        var learningAnalytics = `
                <label for="learningAnalytics"><h5 class="fw-bold">Learning Analytics</h5></label>
                <p class="inputFieldDescription">{{$inputFieldDescriptions['learningAnalytics']}}</p>
                <textarea style="height:125px" maxlength="7500" oninput="validateMaxlength()" onpaste="validateMaxlength()"  id="learningAnalytics" name = "learningAnalytics" class ="form-control" type="text" form="sylabusGenerator">{{isset($vancouverSyllabus) ? $vancouverSyllabus->learning_analytics : ''}}</textarea>
            `;
        var courseFormat = `
                <label for="courseFormat"><h5 class="fw-bold">Course Format</h5></label>
                <textarea style="height:125px" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="7500" name = "courseFormat" class ="form-control" type="text" form="sylabusGenerator" spellcheck="true">{{ isset($okanaganSyllabus) ? $okanaganSyllabus->course_format: ''}}</textarea>
            `;
        var courseOverview = `
                <label for="courseOverview"><h5 class="fw-bold">Course Overview, Content and Objectives</h5></label>
                <textarea style="height:125px" oninput="validateMaxlength()" onpaste="validateMaxlength()" maxlength="7500" name = "courseOverview" class ="form-control" type="text" form="sylabusGenerator" spellcheck="true">{{ isset($okanaganSyllabus) ? $okanaganSyllabus->course_overview : ''}}</textarea>
            `;

        var requiredBySenateLabel = `
            <span class="d-inline-block has-tooltip ml-2 mr-2" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="This section is required in your syllabus under Vancouver Senate policy V-130">
                <button type="button" class="btn btn-danger btn-sm mb-2 disabled" style="font-size:10px;">Required by policy</button> 
            </span>
            `;
        
        // get campus select element
        var campus = $('#campus');
        // check if its value is 'V'
        if(campus.val() == 'V'){
            // add data specific to vancouver campus
            $('#optionalSyllabus').html(vancouverOptionalList);
            $('#courseCredit').html(courseCredit);
            $('#officeLocation').html(officeLocation);
            $('#courseContacts').html(courseContacts);
            $('#courseContacts').removeClass('m-0 p-0');
            $('#coursePrereqs').html(coursePrereqs);
            $('#coursePrereqs').removeClass('m-0 p-0');
            $('#courseCoreqs').html(courseCoreqs);
            $('#courseCoreqs').removeClass('m-0 p-0');
            $('#courseStructure').html(courseStructure);
            $('#courseStructure').removeClass('m-0 p-0');
            $('#courseInstructorBio').html(courseInstructorBio);
            $('#courseInstructorBio').removeClass('m-0 p-0');
            $('#courseDescription').html(courseDescription);
            $('#learningAnalytics').html(learningAnalytics);
            $('.requiredBySenate').html(requiredBySenateLabel);

            // remove data specific to okanangan campus
            $('#courseFormat').empty();
            $('#courseFormat').addClass('m-0 p-0');
            $('#courseOverview').empty();
            $('#courseOverview').addClass('m-0 p-0');

        }
        else
        {
            // add data specific to okanagan campus
            $('#optionalSyllabus').html(okanaganOptionalList);
            $('#courseFormat').html(courseFormat);
            $('#courseFormat').removeClass('m-0 p-0');
            $('#courseOverview').html(courseOverview);
            $('#courseOverview').removeClass('m-0 p-0');

            // remove data specific to vancouver campus
            $('#courseCredit').empty();
            $('#officeLocation').empty();
            $('#courseContacts').empty();
            $('#courseContacts').addClass('m-0 p-0');
            $('#coursePrereqs').empty();
            $('#coursePrereqs').addClass('m-0 p-0');
            $('#courseCoreqs').empty();
            $('#courseCoreqs').addClass('m-0 p-0');
            $('#courseStructure').empty();
            $('#courseStructure').addClass('m-0 p-0');
            $('#courseInstructorBio').empty();
            $('#courseInstructorBio').addClass('m-0 p-0');
            $('#courseDescription').empty();
            $('#learningAnalytics').empty();
            $('.requiredBySenate').empty();
        }

        var formatNotes = document.querySelectorAll('.collapsibleNotes').forEach(function(note) {
            // collapse sections when document is ready
            var isCollapsed = note.dataset.collapsed === 'true';
            if (!isCollapsed) {
                collapseSection(note);
            }
        });
    }
    
    //This method is used to make sure that the proper amount of characters are entered so it doesn't exceed the max character limits
    function validateMaxlength(e){
        //Whitespaces are counted as 1 but character wise are 2 (\n).
        var MAX_LENGTH = event.target.getAttribute("maxlength");
        var currentLength = event.target.value.length;
        var whiteSpace = event.target.value.split(/\n/).length;
        if((currentLength+(whiteSpace))>MAX_LENGTH)
        { 
            //Goes to MAX_LENGTH-(whiteSpace)+1 because it starts at 1
            event.target.value = event.target.value.substr(0,MAX_LENGTH-(whiteSpace)+1);	        
        }
    } 
</script>
<!-- Include script to reorder table rows-->
<script src="{{ asset('js/drag_drop_tbl_row.js') }}"></script>
<!-- Include stylesheet to style reorder table rows -->
<link rel="stylesheet" href="{{ asset('css/drag_drop_tbl_row.css' ) }}">
@endsection