
@extends('layouts.app')

@section('content')

<div class="card mt-4">
    <!-- header -->
    <div class="card-header wizard ">
        <h4>
            {{$syllabus->course_title}}, {{$syllabus->course_code}} {{$syllabus->course_num}}
        </h4>
    </div>
    <!-- body -->
    <div class="card-body">
        <!-- land acknowledgement -->
        @if (in_array($vancouverSyllabusResources[0]->id, $selectedVancouverSyllabusResourceIds))
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>{{strtoupper($vancouverSyllabusResources[0]->title)}}</h6>
            </div>
            <p>We acknowledge that the UBC Vancouver campus is situated within the traditional, ancestral and unceded territory of the Musqueam.</p>
        </div>
        @endif
        <!-- course information -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>COURSE INFORMATION</h6>
            </div>
            <table class="table table-bordered">
                <tr class="table-secondary">
                    <th class="w-50">Course Title</th>
                    <th class="w-25">Course Code, Number</th>
                    <th class="w-25">Credit Value</th>
                </tr>
                <tbody>
                    <tr>
                        <td>{{$syllabus->course_title}}</td>
                        <td>
                            {{$syllabus->course_code}}
                            {{$syllabus->course_num}}
                        </td>
                        <td>{{$vancouverSyllabus->course_credit}}</td>
                    </tr>
                </tbody>
            </table>
            <p><b>Campus:</b> @if ($syllabus->campus == 'V') Vancouver @else Okanagan @endif</p>
            <p><b>Faculty:</b> {{$syllabus->faculty}}</p>
            <p><b>Department:</b> {{$syllabus->department}}</p>
            <p><b>Instructor(s):</b> {{$syllabusInstructors}}</p>
            <p><b>Office Location
                <span>
                    <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['officeLocation']}}"></i>
                </span>
                </b> 
                {{$vancouverSyllabus->office_location}}
            </p>
            <p><b>Duration:</b> {{$syllabus->course_term}} {{$syllabus->course_year}}</p>
            @switch($syllabus->delivery_modality)
                @case('M')
                    <p><b>Delivery Modality:</b> Multi-Access</p>
                    @break
                @case('I')
                    <p><b>Delivery Modality:</b> In-Person</p>
                    @break
                @case('B')
                    <p><b>Delivery Modality:</b> Hybrid</p>
                    @break
                @default
                    <p><b>Delivery Modality:</b> Online</p>
            @endswitch
            <p><b>Class Location:</b> {{$syllabus->course_location}}</p>
            <p><b>Class Days:</b> {{$syllabus->class_meeting_days}}</p>
            <p><b>Class Hours:</b> {{$syllabus->class_start_time}} - {{$syllabus->class_end_time}}</p>
            <p><b>Office Hours                     
                <span>
                    <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['officeHours']}}"></i>
                </span>
                </b> 
                {{$syllabus->office_hours}}
            </p>
        </div>
        <!-- course prerequisites -->
        <div class="mb-4">
            <div class="vSyllabusHeader2">
                <h6>
                    PREREQUISITES
                    <span>
                        <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['coursePrereqs']}}"></i>
                        <span class="d-inline-block has-tooltip " tabindex="0" data-toggle="tooltip" data-bs-placement="top" title="This section is required in your syllabus by Vancouver Senate policy V-130">
                            <button type="button" class="btn btn-danger btn-sm mb-1 disabled" style="font-size:10px;">Required by policy</button> 
                        </span>
                    </span>
                </h6>
            </div>
            <table class="table table-light table-borderless">
                <thead>
                    <tr class="table-primary">
                        <th style="width:5%"></th>
                        <th>Course prerequisite</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (explode(PHP_EOL, $syllabus->course_prereqs) as $index => $coursePreReq)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$coursePreReq}}</td>
                        </tr>
                    @endforeach                                               
                </tbody>
            </table>                                    
        </div>
        <!-- course corequisites -->
        <div class="mb-4">
            <div class="vSyllabusHeader2">
                <h6>
                    COREQUISITES
                    <span>
                        <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['courseCoreqs']}}"></i>
                        <span class="d-inline-block has-tooltip " tabindex="0" data-toggle="tooltip" data-bs-placement="top" title="This section is required in your syllabus by Vancouver Senate policy V-130">
                            <button type="button" class="btn btn-danger btn-sm mb-1 disabled" style="font-size:10px;">Required by policy</button> 
                        </span>
                    </span>
                </h6>
            </div>
            <table class="table table-light table-borderless">
                <thead>
                    <tr class="table-primary">
                        <th style="width:5%"></th>
                        <th>Course corequisite</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (explode(PHP_EOL, $syllabus->course_coreqs) as $index => $courseCoReq)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$courseCoReq}}</td>
                        </tr>
                    @endforeach                                               
                </tbody>
            </table>                                    
        </div>
        <!-- course contacts -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>
                    CONTACTS
                    <span>
                        <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['courseContacts']}}"></i>
                        <span class="d-inline-block has-tooltip " tabindex="0" data-toggle="tooltip" data-bs-placement="top" title="This section is required in your syllabus by Vancouver Senate policy V-130">
                            <button type="button" class="btn btn-danger btn-sm mb-1 disabled" style="font-size:10px;">Required by policy</button> 
                        </span>
                    </span>
                </h6>
            </div>
            <table class="table table-light table-borderless">
                <thead>
                    <tr class="table-primary">
                        <th style="width:5%"></th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (explode(PHP_EOL, $syllabus->contacts) as $index => $contact)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$contact}}</td>
                        </tr>
                    @endforeach                                               
                </tbody>
            </table>                                    
        </div>
        <!-- course instructor biographical statement -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>COURSE INSTRUCTOR BIOGRAPHICAL STATEMENT
                    <span>
                        <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['instructorBioStatement']}}"></i>
                    </span>
                </h6>
            </div>
            <p>{{$vancouverSyllabus->instructor_bio}}</p>
        </div>
        <!-- other instructional staff -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>
                    OTHER INSTRUCTIONAL STAFF
                    <span>
                        <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['otherCourseStaff']}}"></i>
                        <span class="d-inline-block has-tooltip " tabindex="0" data-toggle="tooltip" data-bs-placement="top" title="This section is required in your syllabus by Vancouver Senate policy V-130">
                            <button type="button" class="btn btn-danger btn-sm disabled mb-1" style="font-size:10px;">Required by policy</button> 
                        </span>
                    </span>
                </h6>
            </div>
            <table class="table table-light table-borderless">
                <thead>
                    <tr class="table-primary">
                        <th style="width:5%"></th>
                        <th>Other Instructional Staff</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (explode(PHP_EOL, $syllabus->other_instructional_staff) as $index => $staff)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$staff}}</td>
                        </tr>
                    @endforeach                                               
                </tbody>
            </table>                                    
        </div>
        <!-- course structure -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>
                    COURSE STRUCTURE
                    <span>
                        <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['courseStructure']}}"></i>
                        <span class="d-inline-block has-tooltip " tabindex="0" data-toggle="tooltip" data-bs-placement="top" title="This section is required in your syllabus by Vancouver Senate policy V-130">
                            <button type="button" class="btn btn-danger btn-sm mb-1 disabled" style="font-size:10px;">Required by policy</button> 
                        </span>
                    </span>
                </h6>
            </div>
            <p>{{$vancouverSyllabus->course_structure}}</p>
        </div>
        <!-- schedule of topics -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>
                    SCHEDULE OF TOPICS
                    <span>
                        <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['courseSchedule']}}"></i>
                        <span class="d-inline-block has-tooltip " tabindex="0" data-toggle="tooltip" data-bs-placement="top" title="This section is required in your syllabus by Vancouver Senate policy V-130">
                            <button type="button" class="btn btn-danger btn-sm mb-1 disabled" style="font-size:10px;">Required by policy</button> 
                        </span>
                    </span>
                </h6>
            </div>
            <p>{{$vancouverSyllabus->course_schedule}}</p>
            <br>
            <!-- course schedule table  -->
            <div id="courseScheduleTblDiv" class="row">

                @if (!empty($syllabus))
                    @if ($myCourseScheduleTbl['rows']->count() > 0)
                    <div>
                        <table id="courseScheduleTbl" class="table \" style="width:100%">
                            <tbody>
                                @foreach ($myCourseScheduleTbl['rows'] as $rowIndex => $row)
                                    <!-- table header -->
                                    @if ($rowIndex == 0)
                                        <tr class="table-primary fw-bold">
                                            @foreach ($row as $headerIndex => $header)
                                            <td>
                                                {{$header->val}}
                                            </td>
                                            @endforeach
                                        </tr>
                                    @else
                                        <tr>
                                            @foreach ($row as $colIndex => $data)
                                            <td>
                                                {{$data->val}}
                                            </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                @endif
            </div>
        </div>
        <!--  learning outcomes -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>
                    LEARNING OUTCOMES
                    <span>
                        <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['learningOutcomes']}}"></i>
                        <span class="d-inline-block has-tooltip " tabindex="0" data-toggle="tooltip" data-bs-placement="top" title="This section is required in your syllabus by Vancouver Senate policy V-130">
                            <button type="button" class="btn btn-danger btn-sm disabled mb-1" style="font-size:10px;">Required by policy</button> 
                        </span>
                    </span>
                </h6>
            </div>
            <p style="color:gray"><i>Upon successful completion of this course, students will be able to...</i></p>
            <table class="table table-light table-borderless">
                <thead>
                    <tr class="table-primary">
                        <th style="width:5%"></th>
                        <th>Learning Outcome</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (explode(PHP_EOL, $syllabus->learning_outcomes) as $index => $learningOutcome)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$learningOutcome}}</td>
                        </tr>
                    @endforeach                                               
                </tbody>
            </table>                                    
        </div>
        <!--  learning activities -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>
                    LEARNING ACTIVITIES
                    <span>
                        <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['learningActivities']}}"></i>
                        <span class="d-inline-block has-tooltip " tabindex="0" data-toggle="tooltip" data-bs-placement="top" title="This section is required in your syllabus by Vancouver Senate policy V-130">
                            <button type="button" class="btn btn-danger btn-sm mb-1 disabled" style="font-size:10px;">Required by policy</button> 
                        </span>
                    </span>
                </h6>
            </div>
            <table class="table table-light table-borderless">
                <thead>
                    <tr class="table-primary">
                        <th style="width:5%"></th>
                        <th>Teaching and Learning Activity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (explode(PHP_EOL, $syllabus->learning_activities) as $index => $learningActivity)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$learningActivity}}</td>
                        </tr>
                    @endforeach                                               
                </tbody>
            </table>  
        </div>                                  
        <!--  learning materials -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>
                    LEARNING MATERIALS
                    <span>
                        <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['learningMaterials']}}"></i>
                        <span class="d-inline-block has-tooltip " tabindex="0" data-toggle="tooltip" data-bs-placement="top" title="This section is required in your syllabus by Vancouver Senate policy V-130">
                            <button type="button" class="btn btn-danger btn-sm mb-1 disabled" style="font-size:10px;">Required by policy</button> 
                        </span>
                    </span>
                </h6>
            </div>
            <table class="table table-light table-borderless">
                <thead>
                    <tr class="table-primary">
                        <th style="width:5%"></th>
                        <th>Learning Material</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (explode(PHP_EOL, $syllabus->learning_materials) as $index => $learningMaterials)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$learningMaterials}}</td>
                        </tr>
                    @endforeach                                               
                </tbody>
            </table>                                    
        </div>
        <!--  assessments of learning -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>
                    ASSESSMENTS OF LEARNING
                    <span>
                        <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['learningAssessments']}}"></i>
                        <span class="d-inline-block has-tooltip " tabindex="0" data-toggle="tooltip" data-bs-placement="top" title="This section is required in your syllabus by Vancouver Senate policy V-130">
                            <button type="button" class="btn btn-danger btn-sm mb-1 disabled" style="font-size:10px;">Required by policy</button> 
                        </span>
                    </span>
                </h6>
            </div>
            <table class="table table-light table-borderless">
                <thead>
                    <tr class="table-primary">
                        <th style="width:5%"></th>
                        <th>Learning Assessment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (explode(PHP_EOL, $syllabus->learning_assessments) as $index => $learningAssessments)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$learningAssessments}}</td>
                        </tr>
                    @endforeach                                               
                </tbody>
            </table>                                    
        </div>
        <!--  course alignment table -->
        @if (isset($courseAlignment))
            <div class="mb-4">
                <div class="vSyllabusHeader">
                    <h6>
                        COURSE ALIGNMENT
                    </h6>
                </div>
                <table class="table table-light table-bordered" >
                    <thead>
                        <tr class="table-primary">
                            <th class="w-50">Course Learning Outcome</th>
                            <th>Student Assessment Method</th>
                            <th>Teaching and Learning Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courseAlignment as $clo)
                            <tr>
                                <td scope="row">
                                    <b>{{$clo->clo_shortphrase}}</b><br>
                                    {{$clo->l_outcome}}
                                </td>
                                <td>{{$clo->assessmentMethods->implode('a_method', ', ')}}</td>
                                <td>{{$clo->learningActivities->implode('l_activity', ', ')}}</td>
                            </tr>   
                        @endforeach                 
                    </tbody>
                </table>
            </div>
        @endif

        @if (isset($outcomeMaps))
            @foreach ($outcomeMaps as $programId => $outcomeMap)
                <div class="vSyllabusHeader mt-4 mb-4">
                    <h6>
                        {{strtoupper($outcomeMap["program"]->program)}}
                    </h6>
                </div>
                @if ($outcomeMap['program']->mappingScaleLevels->count() < 1)
                        <div class="alert alert-warning wizard">
                            <i class="bi bi-exclamation-circle-fill"></i>A mapping scale has not been set for this program.                  
                        </div>
                @else 
                    <table class="table table-bordered table-light">
                        <thead>
                            <tr class="table-primary">
                                <th colspan="2">Mapping Scale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($outcomeMap['program']->mappingScaleLevels as $mappingScale)
                                <tr>
                                    <td>
                                        <div style="background-color:{{$mappingScale->colour}};height: 10px; width: 10px;"></div>
                                        {{$mappingScale->title}}<br>
                                        ({{$mappingScale->abbreviation}})
                                    </td>
                                    <td>
                                        {{$mappingScale->description}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if (isset($outcomeMap['outcomeMap']) > 0)
                    <div style="overflow: auto;">
                        <table class="table table-bordered table-light">
                            <thead>
                                <tr class="table-primary">
                                    <th colspan="1" class="w-auto">CLO</th>
                                    <th colspan="{{$outcomeMap['program']->programLearningOutcomes->count()}}">Program Learning Outcome</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th></th>
                                    @foreach ($outcomeMap['program']->ploCategories as $category)
                                        @if ($category->plos->count() > 0)
                                            <th class="table-active w-auto" colspan="{{$category->plos->count()}}" style="min-width:5%; white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{$category->plo_category}}</th>  
                                        @endif          
                                    @endforeach
                                    @if ($outcomeMap['program']->programLearningOutcomes->where('plo_category_id', null)->count() > 0)
                                        <th class="table-active w-auto text-center" colspan="{{$outcomeMap['program']->programLearningOutcomes->where('plo_category_id', null)->count()}}" style="min-width:5%; white-space:nowrap;overflow:hidden;text-overflow:ellipsis">Uncategorized PLOs</th>
                                    @endif
                                </tr> 
                                <tr>
                                    <td></td>
                                    @foreach ($outcomeMap['program']->ploCategories as $category)
                                        @if ($category->plos->count() > 0)
                                            @foreach ($category->plos as $plo)
                                                <td style="height:0; text-align: left;">
                                                    @if ($plo->plo_shortphrase)
                                                        {{$plo->plo_shortphrase}}
                                                    @else 
                                                        {{$plo->pl_outcome}}
                                                    @endif
                                                </td>
                                            @endforeach
                                        @endif
                                    @endforeach
                                    @if ($outcomeMap['program']->programLearningOutcomes->where('plo_category_id', null)->count() > 0)
                                        @foreach ($outcomeMap['program']->programLearningOutcomes->where('plo_category_id', null) as $uncategorizedPLO)
                                            <td style="height:0; text-align: left;">
                                                @if ($uncategorizedPLO->plo_shortphrase)
                                                    {{$uncategorizedPLO->plo_shortphrase}}
                                                @else 
                                                    {{$uncategorizedPLO->pl_outcome}}
                                                @endif
                                            </td>
                                        @endforeach
                                    @endif
                                </tr>
                                @foreach ($outcomeMap['clos'] as $clo) 
                                    <tr>
                                        <td class="w-auto"> 
                                            @if (isset($clo->clo_shortphrase))
                                                {{$clo->clo_shortphrase}}
                                            @else 
                                                {{$clo->l_outcome}}
                                            @endif
                                        </td>
                                        @foreach ($outcomeMap['program']->ploCategories as $category)
                                            @if ($category->plos->count() > 0)
                                                @foreach ($category->plos as $plo)
                                                    <td class="text-center align-middle" style="background-color:{{$outcomeMap['outcomeMap'][$plo->pl_outcome_id][$clo->l_outcome_id]->colour}}">{{$outcomeMap['outcomeMap'][$plo->pl_outcome_id][$clo->l_outcome_id]->abbreviation}}</td>
                                                @endforeach
                                            @endif
                                        @endforeach
                                        @if ($outcomeMap['program']->programLearningOutcomes->where('plo_category_id', null)->count() > 0)
                                            @foreach ($outcomeMap['program']->programLearningOutcomes->where('plo_category_id', null) as $uncategorizedPLO)
                                                <td class="text-center align-middle" style="background-color:{{$outcomeMap['outcomeMap'][$uncategorizedPLO->pl_outcome_id][$clo->l_outcome_id]->colour}}">{{$outcomeMap['outcomeMap'][$uncategorizedPLO->pl_outcome_id][$clo->l_outcome_id]->abbreviation}}</td>
                                            @endforeach
                                        @endif                                
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach
        @endif

        <!--  passing criteria -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>PASSING/GRADING CRITERIA</h6>
            </div>
            <p>{{$syllabus->passing_criteria}}</p>
        </div>
        <!--  late policy -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>LATE POLICY
                    <span>
                        <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['missedActivityPolicy']}}"></i>
                    </span>
                </h6>
            </div>
            <p>{{$syllabus->late_policy}}</p>
        </div>
        <!--  missed exam policy -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>MISSED EXAM POLICY</h6>
            </div>
            <p>{{$syllabus->missed_exam_policy}}</p>
        </div>
        <!--  missed activity policy -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>MISSED ACTIVITY POLICY
                    <span>
                        <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['missedActivityPolicy']}}"></i>
                    </span>
                </h6>
            </div>
            <p>{{$syllabus->missed_activity_policy}}</p>
        </div>
        <!--  university policies -->
        <div class="mb-4">
            <div class="vSyllabusHeader">
                <h6>UNIVERSITY POLICIES</h6>
            </div>
            <p>UBC provides resources to support student learning and to maintain healthy lifestyles but recognizes that sometimes crises arise and so there are additional resources to access including those for survivors of sexual violence. UBC values respect for the person and ideas of all members of the academic community. Harassment and discrimination are not tolerated nor is suppression of academic freedom. UBC provides appropriate accommodation for students with disabilities and for religious observances. UBC values academic honesty and students are expected to acknowledge the ideas generated by others and to uphold the highest academic standards in all of their actions.
                
            Details of the policies and how to access support are available on the <a href="https://senate.ubc.ca/policies-resources-support-student-success" target="_blank" rel="noopener noreferrer">UBC Senate website</a>.</p>
        </div>
        <!-- other course policies -->
        <div class="mb-4">
            <div class="vSyllabusHeader mb-4">
                <h6>OTHER COURSE POLICIES</h6>
            </div>
            <!-- learning analytics -->
            <div class="mb-4">
                <div class="vSyllabusHeader2">
                    <h6>LEARNING ANALYTICS
                        <span>
                            <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['learningAnalytics']}}"></i>
                        </span>
                    </h6>
                </div>
                <p>{{$vancouverSyllabus->learning_analytics}}</p>
            </div>
            <!-- learning resources -->
            <div class="mb-4">
                <div class="vSyllabusHeader2">
                    <h6>LEARNING RESOURCES
                        <span>
                            <i class="bi bi-info-circle-fill text-dark" data-toggle="tooltip" data-bs-placement="top" title="{{$inputFieldDescriptions['learningResources']}}"></i>
                        </span>
                    </h6>
                </div>
                <p>{{$syllabus->learning_resources}}</p>
            </div>
            @foreach ($vancouverSyllabusResources as $index => $resource) 
                @if (in_array($resource->id, $selectedVancouverSyllabusResourceIds) && $index != 0)
                <div class="mb-4">
                    <div class="vSyllabusHeader2">
                        <h6>{{strtoupper($resource->title)}}</h6>
                    </div>
                    @switch ($resource->id_name)
                        @case('academic')
                        <!-- academic integrity statement -->
                        <p>The academic enterprise is founded on honesty, civility, and integrity. As members of this enterprise, all students are expected to know, understand, and follow the codes of conduct regarding academic integrity. At the most basic level, this means submitting only original work done by you and acknowledging all sources of information or ideas and attributing them to others as required. This also means you should not cheat, copy, or mislead others about what is your work. Violations of academic integrity (i.e., misconduct) lead to the breakdown of the academic enterprise, and therefore serious consequences arise and harsh sanctions are imposed. For example, incidences of plagiarism or cheating may result in a mark of zero on the assignment or exam and more serious consequences may apply if the matter is referred to the President’s Advisory Committee on Student Discipline. Careful records are kept in order to monitor and prevent recurrences. A more detailed description of academic integrity, including the University’s policies and procedures, may be found in the Academic Calendar.</p>
                        @break

                        @case('disability')

                        <p class="text-center">UBC provides appropriate accommodation for students with disabilities. <br>
                        <ul style=“list-style-type:square”>
                            <li><a href="https://students.ubc.ca/about-student-services/centre-for-accessibility" target="_blank" rel="noopener noreferrer">Centre for Accessibility</a></li>
                            <li><a href="http://www.calendar.ubc.ca/vancouver/index.cfm?tree=3,34,0,0">Academic Calendar language concerning Accommodation for Students with Disabilities</a></li>
                            <li><a href="https://universitycounsel.ubc.ca/policies/disability-accommodation-policy/">Joint Board and Senate Policy LR7: Disability Accommodation</a></li>
                        </ul>
                        </p>
                        @break

                        @case('concession')
                        <p>In accordance with <a href="https://senate.ubc.ca/sites/senate.ubc.ca/files/downloads/va_V-135.1_Academic-Concession_20200415.pdf">UBC Policy V135</a>, academic concessions are generally granted when students are facing an unexpected situation or circumstance that prevents them from completing graded work or exams. Students may request an academic concession for unanticipated changes in personal responsibilities that create a conflict, medical circumstances, or compassionate grounds.
                        <br>
                        <br>
                        In accordance with <a href="https://senate.ubc.ca/sites/senate.ubc.ca/files/downloads/va_V-135.1_Academic-Concession_20200415.pdf">UBC Policy V135</a>, Section 10, students’ requests for academic concession should be made as early as reasonably possible, in writing to their instructor or academic advising office or equivalent in accordance with the procedures for <a href="https://senate.ubc.ca/sites/senate.ubc.ca/files/downloads/va_V-135.1_Academic-Concession_20200415.pdf">Policy V135</a> and those set out by the student’s faculty/school. The requests should clearly state the grounds for the concession and the anticipated duration of the conflict and or hindrance to academic work. In some situations, this self-declaration is sufficient, but the submission of supporting documentation may be required along with, or following, the self-declaration.
                        </p>
                        @break

                        @case('support')
                        <p>UBC provides resources to support student learning and to maintain healthy lifestyles but recognizes that sometimes crises arise and so there are additional resources to access including those for survivors of sexual assault.
                        <br>
                        <ul style=“list-style-type:square”>
                            <li><a href="https://students.ubc.ca/enrolment/academic-learning-resources">Central Resource to Support Student Learning</a></li>
                            <li><a href="https://students.ubc.ca/health">Central Resource for Student Health </a>and <a href="https://students.ubc.ca/health/accessing-crisis-support-services">Crisis Support.</a></li>
                            <li>Resources for the prevention of sexual violence and for support for survivors: <a href="https://svpro.ubc.ca/">UBC SVPRO </a>and <a href="https://www.amssasc.ca/">AMS SASC</a></li>
                            <li><a href="http://www.calendar.ubc.ca/vancouver/">Academic Calendar language concerning seeking Academic Concessions</a> if academic work is disrupted by ill health, medical issues, on compassionate grounds or if conflicting responsibilities arise during a course</li>
                        </ul>
                        </p>
                        @break

                        @case('harass')
                        <p>UBC values respect for the person and ideas of all members of the academic community. Harassment and discrimination are not tolerated nor is suppression of academic freedom.
                        <br>
                        <ul style=“list-style-type:square”>
                            <li><a href="http://www.calendar.ubc.ca/vancouver/index.cfm?tree=3,33,87,0,">Academic Calendar language concerning Freedom from Harrassment and Discrimination</a></li>
                            <li><a href="https://universitycounsel.ubc.ca/policies/discrimination-policy/">Board of Governors Policy SC7: Discrimination</a></li>
                            <li><a href="http://www.calendar.ubc.ca/vancouver/index.cfm?tree=3,33,0,0">Academic Calendar Language Concerning Academic Freedom</a></li>
                        </ul>
                        </p>
                        @break

                        @case('religious')
                        <p>UBC provides appropriate accommodation for students for religious, spiritual and cultural observances. <br>
                        <ul style=“list-style-type:square”>
                            <li><a href="http://www.calendar.ubc.ca/vancouver/">Academic Calendar language concerning Religious observances</a></li>
                            <li><a href="https://senate.ubc.ca/religious-holidays-observances/">Religious Observances</a></li>
                        </ul>
                        </p>
                        @break

                        @case('honesty')
                        <p>UBC values academic honesty and students are expected to acknowledge the ideas generated by others and to uphold the highest academic standards in all of their actions <br>
                        <ul style=“list-style-type:square”>
                            <li><a href="http://www.calendar.ubc.ca/vancouver/index.cfm?tree=3,286,0,0#15620">Academic Calendar language concerning Academic Honesty and Standards</a></li>
                            <li><a href="http://www.calendar.ubc.ca/vancouver/index.cfm?tree=3,54,0,0">Academic Calendar language concerning Student Conduct and Discipline</a></li>
                        </ul>
                        </p>
                        @break

                    @endswitch
                </div>
                @endif
            @endforeach
        </div>
    </div>
    <!-- footer -->
    <div class="card-footer p-4">
            <button class="btn btn-primary dropdown-toggle m-2 col-4 float-right" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Download
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <li>
                    <form method="POST" action="{{ action('SyllabusController@download', [$syllabus->id, 'pdf']) }}">
                    @csrf        
                        <button type="submit" name="download" value="pdf" class="dropdown-item" type="button">
                            <i class="bi-file-pdf-fill text-danger"></i> PDF
                        </button>
                    </form>
                </li>
                <li>
                    <form method="POST" action="{{ action('SyllabusController@download', [$syllabus->id, 'word']) }}">
                    @csrf        
                        <button type="submit" name="download" value="word" class="dropdown-item" type="button">
                            <i class="bi-file-earmark-word-fill text-primary"></i> Word
                        </button>
                    </form>
                </li>
            </ul>
            
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function () {

        $('[data-toggle="tooltip"]').tooltip();
    });

</script>

@endsection

