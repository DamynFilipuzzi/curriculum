@extends('layouts.app')

@section('content')
<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('courses.wizard.header')

            <div class="card ">

                <div>
                    <a href="{{route('courses.pdf', $course->course_id)}}">
                        <button class="btn btn-sm btn-primary mt-3 mb-3 col-3 float-right mr-5" onclick="{{route('courses.pdf', $course->course_id)}}">
                            Download PDF ⭳
                        </button>
                    </a>
                </div>

                <p class="ml-5 mr-5 form-text text-muted">You can review	and	download the mapped course here. To edit information, select from the numbered tabs above.
                    Click finish only when you have completed the mapping process.</p>



                <div class="card ml-5 mr-5 mt-3 mb-5">


                    <div class="card-header font-weight-bold">
                        {{$course->course_code}}{{$course->course_num}}: Course Learning Outcomes/Competencies
                    </div>


                    <div class="card-body ml-5 mr-5">
                        The course learning outcomes used in this course are listed below.
                        <table class="table table-bordered table-sm  mt-3">

                            @if(count($l_outcomes)<1)
                                <tr>
                                    <th class="table-light">There are no course learning outcomes set for this course.</th>
                                </tr>

                            @else

                                <tr>
                                    <th class="table-light"></th>
                                    <th class="table-light">Course Learning Outcomes</th>
                                </tr>
                                    @for($i = 0; $i < count($l_outcomes); $i++)
                                        <tr>
                                            <td style="width:5%" >{{$i+1}}</td>
                                            <td>
                                                <b>{{$l_outcomes[$i]->clo_shortphrase}}</b><br>
                                                {{$l_outcomes[$i]->l_outcome}}

                                            </td>
                                        </tr>
                                    @endfor

                            @endif

                        </table>

                    </div>

                    <div class="card-header font-weight-bold">
                        {{$course->course_code}}{{$course->course_num}}: Student Assessment Methods
                    </div>


                    <div class="card-body ml-5 mr-5">
                        Student assessment methods used in this course are listed below.
                        <table class="table table-bordered table-sm  mt-3">

                            @if(count($a_methods)<1)
                                <tr>
                                    <th class="table-light">There are no student assessment methods set for this course.</th>
                                </tr>

                            @else

                                <tr>
                                    <th class="table-light"></th>
                                    <th class="table-light">Student Assesment Methods</th>
                                    <th class="table-light">Weight</th>
                                </tr>
                                    @for($i = 0; $i < count($a_methods); $i++)
                                        <tr>
                                            <td style="width:5%" >{{$i+1}}</td>
                                            <td>{{$a_methods[$i]->a_method}}</td>
                                            <td>{{$a_methods[$i]->weight}}%</td>
                                        </tr>
                                    @endfor

                            @endif

                        </table>

                    </div>

                    <div class="card-header font-weight-bold">
                        {{$course->course_code}}{{$course->course_num}}: Teaching and Learning Activities
                    </div>


                    <div class="card-body ml-5 mr-5">
                        Teaching and Learning Activities used in this course are listed below

                        <table class="table table-bordered table-sm mt-3">

                            @if(count($l_activities)<1)
                                <tr>
                                    <th>There are no teaching and learning activities set for this course.</th>
                                </tr>


                            @else

                                <tr>
                                    <th class="table-light"></th>
                                    <th class="table-light">Teaching and Learning Activities</th>
                                </tr>
                                @for($i=0; $i<count($l_activities); $i++)

                                    <tr>
                                        <td style="width:5%" >{{$i+1}}</td>
                                        <td>{{$l_activities[$i]->l_activity}}</td>
                                    </tr>

                                @endfor

                            @endif
                        </table>

                    </div>

                    <div class="card-header font-weight-bold">
                        {{$course->course_code}}{{$course->course_num}}: Curriculum Alignment Table
                    </div>


                    <div class="card-body ml-5 mr-5">

                        <table class="table table-bordered table-sm mt-3">

                            @if(count($l_outcomes)<1)
                                <tr>
                                    <th class="table-light">There are no course learning outcomes set for this course.</th>
                                </tr>

                            @else

                                <tr>
                                    <th class="table-light"></th>
                                    <th class="table-light">Course Learning Outcomes</th>
                                    <th class="table-light">Student Assessment Method</th>
                                    <th class="table-light">Teaching and Learning Activity</th>
                                </tr>
                                    @for($i = 0; $i < count($l_outcomes); $i++)
                                        <tr>
                                            <td style="width:5%" >{{$i+1}}</td>
                                            <td>{{$l_outcomes[$i]->l_outcome}}</td>
                                            <td>
                                                @foreach($outcomeAssessments as $oa)
                                                    @if($oa->l_outcome_id == $l_outcomes[$i]->l_outcome_id )
                                                        {{$oa->a_method}}<br>

                                                    @endif

                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($outcomeActivities as $oa)
                                                    @if($oa->l_outcome_id == $l_outcomes[$i]->l_outcome_id )
                                                        {{$oa->l_activity}}<br>

                                                    @endif

                                                @endforeach

                                            </td>
                                        </tr>
                                    @endfor

                            @endif

                        </table>

                    </div>

                    <div class="card-header font-weight-bold">
                        @if($course->program_id == 1 ?? $course->program_id == 2 ?? $course->program_id == 3 )
                            BC {{$program->program}}
                        @else
                            {{$program->program}}
                        @endif
                    </div>

                    <div class="card-body ml-5 mr-5 mt-3">

                        <table class="table table-bordered table-sm mt-3">

                            @if(count($pl_outcomes)<1)
                                <tr>
                                    <th class="table-light">There are no program learning outcomes set for this course.</th>
                                </tr>

                            @else

                                <tr>
                                    <th class="table-light"></th>
                                    <th class="table-light">Standards</th>
                                    @if(count($ploCategories)>0)
                                        <th class="table-light">PLO Category</th>
                                    @endif
                                </tr>
                                    @for($i = 0; $i < count($pl_outcomes); $i++)
                                        <tr>
                                            <td style="width:5%" >{{$i+1}}</td>
                                            <td>
                                                <b>{{$pl_outcomes[$i]->plo_shortphrase}}</b><br>
                                                {{$pl_outcomes[$i]->pl_outcome}}

                                            </td>
                                            @if(count($ploCategories)>0)
                                                @if(isset($pl_outcomes[$i]->category->plo_category))
                                                    <td>{{$pl_outcomes[$i]->category->plo_category}}</td>
                                                @else
                                                    <td>Uncategorised</td>
                                                @endif
                                            @endif
                                        </tr>
                                    @endfor

                            @endif

                        </table>

                    </div>


                    <div class="card-header font-weight-bold">
                        {{$course->course_code}}{{$course->course_num}}: Outcome Maps
                    </div>


                    <div class="card-body ml-5 mr-5">

                        @if(count($mappingScales)>0)
                            The following are the mapping scale levels used to indicate the degree to which a program-level learning outcome is addressed by a particular course outcome.

                            <div class="container row mt-3 mb-2">
                                <div class="col">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Mapping Scale</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($mappingScales as $ms)

                                                <tr>

                                                    <td>
                                                        <div style="background-color:{{$ms->colour}}; height: 10px; width: 10px;"></div>
                                                        {{$ms->title}}<br>
                                                        ({{$ms->abbreviation}})
                                                    </td>
                                                    <td>
                                                        {{$ms->description}}
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else

                            <table class="table table-bordered table-sm">
                                <tr>
                                    <th class="table-light">There are no mapping scale levels set for this program.</th>
                                </tr>
                            </table>

                        @endif

                        This chart shows the alignment of course outcomes to program-level learning outcomes (or Ministry Standards).

                        <table  class="table table-bordered table-sm mt-3">

                            @if(count($outcomeMaps)<1)
                                <tr>
                                    <th  class="table-light">Course learning outcomes have not been mapped to program learning outcomes for this course.</th>
                                </tr>

                            @else

                                <tr>
                                    <th  class="table-light">Course Outcomes</th>
                                    <th  class="table-light"colspan="{{count($pl_outcomes)}}">Program Learning Outcomes</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    @for($i = 0; $i < count($pl_outcomes); $i++)

                                        <td style="height:0; vertical-align: bottom; text-align: left;">
                                            <span style="writing-mode: vertical-rl; transform: rotate(180deg);">
                                                @if(isset($pl_outcomes[$i]->plo_shortphrase))
                                                    {{$i+1}}.<br>
                                                    {{$pl_outcomes[$i]->plo_shortphrase}}
                                                @else
                                                    PLO {{$i+1}}
                                                @endif

                                            </span>
                                        </td>

                                    @endfor
                                </tr>

                                @for($i = 0; $i < count($l_outcomes); $i++)

                                    <tr>

                                        <td style="max-width:0; height: 50px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" >
                                            @if(isset($l_outcomes[$i]->clo_shortphrase))
                                                {{$i+1}}. {{$l_outcomes[$i]->clo_shortphrase}}
                                            @else
                                                CLO {{$i+1}}
                                            @endif
                                        </td>

                                        @for($j = 0; $j < count($pl_outcomes); $j++)
                                            @foreach ($outcomeMaps as $om)
                                                @if( $om->pl_outcome_id == $pl_outcomes[$j]->pl_outcome_id && $om->l_outcome_id == $l_outcomes[$i]->l_outcome_id )
                                                    <td @foreach($mappingScales as $ms) @if($ms->abbreviation == $om->map_scale_value) style="background-color:{{$ms->colour}}" @endif @endforeach class="text-center align-middle" >
                                                        <span @if($om->map_scale_value == 'A') style="color:white" @endif>
                                                            {{$om->map_scale_value}}
                                                        </span>
                                                    </td>
                                                @endif
                                            @endforeach

                                        @endfor
                                    </tr>
                                @endfor

                            @endif

                        </table>

                    </div>

                    <div class="card-header font-weight-bold">
                        {{$course->course_code}}{{$course->course_num}}: Optional alignment to UBC and Ministry priorities
                    </div>

                    <div class="card-body ml-5 mr-5">
                        Optional alignment to UBC and Ministry priorities are listed below.

                        <table class="table table-bordered table-sm mt-3">

                            @if(count($optional_PLOs)<1)
                                <tr>
                                    <th class="table-light">There are no Optional alignment to UBC and Ministry priorities for this course.</th>
                                </tr>
                            @else

                                <tr>
                                    <th class="table-light"></th>
                                    <th class="table-light">Optional alignment to UBC and Ministry priorities</th>
                                </tr>
                                    @foreach ($optional_PLOs as $index => $optional_Plo)
                                        <tr>
                                            <td style="width:5%" >{{$index+1}}</td>
                                            <td>{{$optional_Plo->custom_PLO}}</td>
                                        </tr>
                                    @endforeach

                            @endif
                            </table>
                    </div>

                </div>
                <p class="form-text text-center text-muted">
                    If you have finished mapping this course. Click the finish button to save your work.
                </p>

                <div class="card-footer">
                    <a href="{{route('courseWizard.step5', $course->course_id)}}">
                        <button class="btn btn-sm btn-primary mt-3 col-3 float-left">⬅ Program Outcome Mapping</button>
                    </a>
                    <a href="{{route('courses.submit', $course->course_id)}}">
                        <button class="btn btn-sm btn-success mt-3 col-3 float-right"> Finish</button>
                    </a>


                </div>

            </div>

        </div>





    </div>



</div>

<script type="application/javascript">
    $(document).ready(function () {

      $("form").submit(function () {
        // prevent duplicate form submissions
        $(this).find(":submit").attr('disabled', 'disabled');
        $(this).find(":submit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

      });
    });
  </script>


@endsection
