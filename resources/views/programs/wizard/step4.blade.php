@extends('layouts.app')

@section('content')
<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('programs.wizard.header')

            <div class="card">
                <h3 class="card-header wizard" >
                    Program Overview
                </h3>

                <div class="card-body m-2">
                    <div class="card">
                        <h3 class="card-header" >
                            Courses to PLOs Frequency Distribution 
                        </h3>
                        
                        <!-- Program Learning Outcomes -->
                        <div class="card-body">
                            <h5 class="card-title">
                                Program Learning Outcomes
                            </h5>

                            @if ( count($plos) < 1)
                                <div class="alert alert-warning wizard">
                                    <i class="bi bi-exclamation-circle-fill"></i>There are no program learning outcomes for this program.                  
                                </div>
                            @else
                                <table class="table table-light table-bordered table" style="width: 95%; margin: auto; table-layout:auto;">
                                    <tr class="table-primary">
                                        <th colspan="1">#</th>
                                        <th class="text-left" colspan="1">Program Learning Outcome</th>
                                    </tr>
                                    <tbody>
                                        @foreach ($plos as $i => $plo)
                                            <tr>
                                                <td class="text-center align-middle">{{$i + 1}}</td>
                                                <td>
                                                    <span style="font-weight: bold;">{{$plo->plo_shortphrase}}</span><br>
                                                    {{$plo->pl_outcome}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <!-- Mapping scales -->
                            <div class="card-body">
                                <h5 class="card-title">
                                    Mapping Scale
                                </h5>
                                @if ( count($mappingScales) < 1) 
                                    <div class="alert alert-warning wizard">
                                        <i class="bi bi-exclamation-circle-fill"></i>A mapping scale has not been set for this program.                  
                                    </div>
                                @else 
                                    <p>The mapping scale indicates the degree to which a program learning outcome is addressed by a course learning outcome.</p>
                                    <table class="table table-bordered table-sm" style="width: 95%; margin: auto; table-layout:auto;">
                                        <tr class="table-primary">
                                            <th class="text-left" colspan="2">Mapping Scale</th>
                                        </tr>
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
                                @endif
                            </div>
                    
            
                        <!-- frequency distribution table -->
                        <div class="card-body">
                            <h5 class="card-title">
                                Courses to PLOs Frequency Distribution Table
                            </h5>
                            @if( count($programCourses) < 1 )
                                <div class="alert alert-warning wizard">
                                    <i class="bi bi-exclamation-circle-fill pr-2 fs-5"></i>There are no Courses set for this program yet.                    
                                </div>
                            @else
                                <p>The courses to PLOs frequency distribution table provides a simplified way to view the strongest correlation between CLOs to PLOs for each course in the program.</p>

                                <table class="table table-bordered table-sm" style="width: 95%; margin:auto; table-layout: fixed; border: 1px solid white; color: black;">
                                    <tr class="table-primary">
                                        <th colspan='1'>Courses</th>
                                        <th class="text-left" colspan='{{ count($plos) }}'>Program-level Learning Outcomes</th>
                                    </tr>
                                    <tr>
                                        <th colspan='1' style="background-color: rgba(0, 0, 0, 0.03);"></th>
                                        @foreach($ploCategories as $plo)
                                            @if ($plo->plo_category != NULL)
                                                @if ($plo->plos->count() > 0) 
                                                    <th colspan='{{ $plosPerCategory[$plo->plo_category_id] }}' style="background-color: rgba(0, 0, 0, 0.03);">{{$plo->plo_category}}</th>
                                                @endif
                                            @endif
                                        @endforeach
                                        <!-- Heading appended at the end, if there are Uncategorized PLOs  -->
                                        @if($hasUncategorized)
                                            <th colspan="{{$numUncategorizedPLOS}}" style="background-color: rgba(0, 0, 0, 0.03);">Uncategorized PLOs</th>
                                        @endif
                                    </tr>

                                    <tr>
                                        <th colspan='1' style="background-color: rgba(0, 0, 0, 0.03);"></th>
                                        <!-- Categorized PLOs -->
                                        @foreach($ploProgramCategories as $plo)
                                            @if ($plo->plo_category != NULL)
                                                <th style="background-color: rgba(0, 0, 0, 0.03);">{{$plo->plo_shortphrase}}</th>
                                            @endif
                                        @endforeach
                                        <!-- Uncategorized PLOs -->
                                        @foreach($plos as $plo)
                                            @if ($plo->plo_category == NULL)
                                                <th style="background-color: rgba(0, 0, 0, 0.03);">{{$plo->plo_shortphrase}}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <!-- Show all courses associated to the program -->
                                    @foreach($programCourses as $course)
                                        <tr>
                                            <th colspan="1" style="background-color: rgba(0, 0, 0, 0.03);">
                                            {{$course->course_title}}
                                            <br>
                                            {{$course->course_code}} {{$course->course_num}} {{$course->section}}
                                            <br>
                                            {{$course->semester}} {{$course->year}}
                                        </th>
                                            <!-- Frequency distribution from each course -->
                                            <!-- For Each Categorized PLO -->
                                            @foreach($ploProgramCategories as $index => $plo)
                                                @if ($plo->plo_category != NULL)
                                                <!-- Check if ['pl_outcome_id']['course_id'] are in the array -->
                                                    @if(isset($testArr[$plo->pl_outcome_id][$course->course_id]))
                                                        <!-- Check if a Tie is present -->
                                                        @if(isset($testArr[$plo->pl_outcome_id][$course->course_id]['map_scale_value_tie']))
                                                            <td class="text-center align-middle" style="background:repeating-linear-gradient(45deg, transparent, transparent 8px, #ccc 8px, #ccc 16px), linear-gradient( to bottom, #fff, #999);" data-toggle="tooltip" data-html="true" data-bs-placement="right" title="@foreach($testArr[$plo->pl_outcome_id][$course->course_id]['frequencies'] as $index => $freq) {{$index}}: {{$freq}}<br> @endforeach">
                                                                <span style="color: black;">
                                                                    <span style="font-weight: bold;">Tie:</span><br>
                                                                    {{$testArr[$plo->pl_outcome_id][$course->course_id]['map_scale_value']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td class="text-center align-middle" style="background-color: {{ $testArr[$plo->pl_outcome_id][$course->course_id]['colour'] }};" data-toggle="tooltip" data-html="true" data-bs-placement="right" title="@foreach($testArr[$plo->pl_outcome_id][$course->course_id]['frequencies'] as $index => $freq) {{$index}}: {{$freq}}<br> @endforeach">
                                                                <span style="color: black;">
                                                                    {{$testArr[$plo->pl_outcome_id][$course->course_id]['map_scale_value']}}
                                                                </span>
                                                            </td>
                                                        @endif

                                                    @else
                                                        <td class="text-center align-middle" style="background-color: white;">
                                                            Incomplete
                                                        </td>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <!-- For Each Uncategorized PLO-->
                                            @foreach($plos as $plo)
                                                @if ($plo->plo_category == NULL)
                                                    <!-- Check if ['pl_outcome_id']['course_id'] are in the array -->
                                                    @if(isset($testArr[$plo->pl_outcome_id][$course->course_id]))
                                                        <!-- Check if a Tie is present -->
                                                        @if(isset($testArr[$plo->pl_outcome_id][$course->course_id]['map_scale_value_tie']))
                                                            <td class="text-center align-middle" style="background:repeating-linear-gradient( 45deg, transparent, transparent 10px, #ccc 10px, #ccc 20px), linear-gradient( to bottom, #eee, #999);" data-toggle="tooltip" data-html="true" data-bs-placement="right" title="@foreach($testArr[$plo->pl_outcome_id][$course->course_id]['frequencies'] as $index => $freq) {{$index}}: {{$freq}}<br> @endforeach">
                                                                <span style="color: black;">
                                                                    <span style="font-weight: bold;">Tie:</span><br>
                                                                    {{$testArr[$plo->pl_outcome_id][$course->course_id]['map_scale_value']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td class="text-center align-middle" style="background-color: {{ $testArr[$plo->pl_outcome_id][$course->course_id]['colour'] }};" data-toggle="tooltip" data-html="true" data-bs-placement="right" title="@foreach($testArr[$plo->pl_outcome_id][$course->course_id]['frequencies'] as $index => $freq) {{$index}}: {{$freq}}<br> @endforeach">
                                                                <span style="color: black;">
                                                                    {{$testArr[$plo->pl_outcome_id][$course->course_id]['map_scale_value']}}
                                                                </span>
                                                            </td>
                                                        @endif

                                                    @else
                                                        <td class="text-center align-middle" style="background-color: white;">
                                                            Incomplete
                                                        </td>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </table>
                        </div>  
                            @endif
                    </div>
            </div>
        </div>
    </div>
        <!-- end Courses to PLOs frequency Distribution card -->

            <div class="card-footer">
                <div class="card-body mb-4">
                    <a href="{{route('programWizard.step3', $program->program_id)}}">
                        <button class="btn btn-sm btn-primary col-3 float-left"><i class="bi bi-arrow-left mr-2"></i> Courses</button>
                    </a>
                </div>
            </div> 
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        // Enables functionality of tool tips
        $('[data-toggle="tooltip"]').tooltip({html:true});

    $("form").submit(function () {
        // prevent duplicate form submissions
        $(this).find(":submit").attr('disabled', 'disabled');
        $(this).find(":submit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

    });
    });
</script>

<style>

.tooltip-inner {
    text-align: left;
}
th, td {
    border: 1px solid white;
    color: black;
    
}
th {
        text-align: center;
}
.table-primary th, .table-primary td, .table-primary thead th, .table-primary tbody + tbody {
    border-color: white;
}

</style>

@endsection
