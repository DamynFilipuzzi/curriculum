@extends('layouts.app')

@section('content')

<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('programs.wizard.header')

            <div class="card">

                <div class="card-body">
                    <p class="form-text text-muted">
                        The mapping scale is the scale that will be used to indicate the degree to which a program-level
                        learning outcome is addressed by a course outcome, or the degree of alignment between the
                        course outcome and program-level learning outcome.
                    </p>

                    <div class="row mb-3 container">
                        <div class="float-left">
                            <!-- Show default mapping scale button  -->
                            <button type="button" class="btn btn-outline-secondary btn-sm mr-2" style="width: 250px" data-toggle="modal" data-target=".bd-example-modal-lg">Show Default Mapping Scale</button>
                            
                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Default Mapping Scale</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">Maping Scale</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td scope="row"><div style="background-color:#80bdff; height: 10px; width: 10px;"></div>Introduced (I)</td>
                                                        <td>Key ideas, concepts or skills related to the learning outcome are demonstrated at an introductory level. 
                                                            Learning activities focus on basic knowledge, skills, and/or competencies and entry-level complexity.</td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td scope="row"><div style="background-color:#1aa7ff; height: 10px; width: 10px;"></div>Developing (D)</td>
                                                        <td>Learning outcome is reinforced with feedback; students demonstrate the outcome at an increasing level of proficiency. 
                                                            Learning activities concentrate on enhancing and strengthening existing knowledge and skills as well as expanding complexity.</td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td scope="row"><div style="background-color:#0065bd; height: 10px; width: 10px;"></div>Advanced (A)</td>
                                                        <td>Students demonstrate the learning outcomes with a high level of independence, expertise and sophistication expected upon graduation. 
                                                            Learning activities focus on and integrate the use of content or skills in multiple.</td>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                          </div>
                                          
                                       
                                    </div>
                                </div>
                            </div>
                            
                        </div>


                        <div class="float-left">


                            <form action="{{route('mappingScale.default')}}" method="POST" >
                                @csrf
                                <input type="hidden" class="form-check-input" name="program_id" value="{{$program->program_id}}">
                                <button type="submit" style="width:250px; background-color:#002145;color:white;" class="btn btn-secondary btn-sm float-left"> + Use the Default Mapping Scale Levels</button>
                            </form>

                            <form action="{{route('mappingScale.default2')}}" method="POST" >
                                @csrf
                                <input type="hidden" class="form-check-input" name="program_id" value="{{$program->program_id}}">   
                                <button type="submit" style="width:250px; background-color:#002145;color:white;" class="btn btn-secondary btn-sm "> + Use the Other Mapping Scale Levels</button>
                            </form>

                        </div>
                        
                    </div>

                    <div id="plos">
                        <div class="row">
                            <div class="col">
                                <table class="table table-borderless">

                                    @if(count($mappingScales)<1) 
                                        <tr class="table-active">
                                            <th colspan="2">There are no mapping scale levels set for this program project.</th>
                                        </tr>

                                    @else

                                        <tr class="table-active">
                                            <th colspan="4">Mapping Scale</th>
                                        </tr>
                                        
                                            @foreach($mappingScales as $ms)
                                            
                                            <tr>
                                                
                                                <td style="width:20%">
                                                    <div style="background-color:{{$ms->colour}}; height: 10px; width: 10px;"></div>
                                                    {{$ms->title}}<br>
                                                    ({{$ms->abbreviation}})
                                                </td>
                                                <td>
                                                    {{$ms->description}}
                                                </td>
                                                <td style="width:5%" >
                                                    @if($ms->map_scale_id !== 1 && $ms->map_scale_id !== 2 && $ms->map_scale_id !== 3 && $ms->map_scale_id !== 4 && $ms->map_scale_id !== 5 && $ms->map_scale_id !== 6 && $ms->map_scale_id !== 7)
                                                        <button type="button" class="btn btn-secondary btn-sm float-right" data-toggle="modal" style="width:60px;" data-target="#editMSModal{{$ms->map_scale_id}}">
                                                            Edit
                                                        </button>
                                                    @endif

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="editMSModal{{$ms->map_scale_id}}" tabindex="-1" role="dialog" aria-labelledby="editMSModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editMSModalLabel">Edit Mapping Scale Level</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <form method="POST"
                                                                    action="{{ action('MappingScaleController@update', $ms->map_scale_id) }}">
                                                                    @csrf
                                                                    {{method_field('PUT')}}

                                                                    <div class="modal-body">
                                                                        <div class="form-group row">
                                                                            <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
                                
                                                                            <div class="col-md-8">
                                                                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{$ms->title}}" required autofocus>
                                
                                                                                @error('title')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <label for="abbreviation" class="col-md-4 col-form-label text-md-right">Abbreviation</label>
                                
                                                                            <div class="col-md-8">
                                                                                <input id="abbreviation" type="text" class="form-control @error('abbreviation') is-invalid @enderror" name="abbreviation" value="{{$ms->abbreviation}}" maxlength="5" required autofocus>
                                
                                                                                @error('abbreviation')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <label for="colour" class="col-md-4 col-form-label text-md-right">Colour</label>
                                
                                                                            <div class="col-md-8">
                                                                                <input id="colour" type="color" class="form-control @error('colour') is-invalid @enderror" name="colour" value="{{$ms->colour}}" required autofocus list="colours">
                                                                                <datalist id="colours">
                                                                                    <option value="#494444">
                                                                                    <option value="#726f6f">
                                                                                    <option value="#8b8989">
                                                                                    <option value="#bbbbbb">
                                                                                    <option value="#aaaaaa">

                                                                                    <option value="#011f4b">
                                                                                    <option value="#03396c">
                                                                                    <option value="#005b96">
                                                                                    <option value="#6497b1">
                                                                                    <option value="#b3cde0">

                                                                                    <option value="#991101">
                                                                                    <option value="#c23210">
                                                                                    <option value="#d65f59">
                                                                                    <option value="#ff8ab3">
                                                                                    <option value="#ffd0c2">

                                                                                    <option value="#009c1a">
                                                                                    <option value="#22b600">
                                                                                    <option value="#26cc00">
                                                                                    <option value="#7be382">
                                                                                    <option value="#d2f2d4">

                                                                                    <option value="#7f6b00">
                                                                                    <option value="#ccac00">
                                                                                    <option value="#ffd700">
                                                                                    <option value="#ffeb7f">
                                                                                    <option value="#fff7cc">
                                                                                </datalist>

                                                                                @error('colour')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
                                
                                                                            <div class="col-md-8">
                                                                                <textarea id="description" class="form-control" @error('description') is-invalid @enderror rows="3" name="description" required autofocus>{{$ms->description}}
                                                                                </textarea>
                                
                                                                                @error('description')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" class="form-check-input" name="program_id" value="{{$program->program_id}}">

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary col-2 btn-sm" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary col-2 btn-sm">Save</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                               
                                                    
                                                </td>
                                                <td style="width:5%" >
                                                    <form action="{{route('mappingScale.destroy', $ms->map_scale_id)}}" method="POST" class="float-right ml-2">
                                                        @csrf
                                                        {{method_field('DELETE')}}
                                                        <input type="hidden" class="form-check-input" name="program_id" value="{{$program->program_id}}">
                                                        <button type="submit" style="width:60px" class="btn btn-danger btn-sm ">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>



                                            @endforeach

                                       

                                    @endif
                                </table>
                            </div>

                        </div>
                    </div>

                    <button type="button" class="btn btn-primary btn-sm col-3 mt-3 float-right" data-toggle="modal"
                        data-target="#addMSModal" style="background-color:#002145;color:white;">
                        ＋ Add My Own Mapping Scale Level
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="addMSModal" tabindex="-1" role="dialog"
                        aria-labelledby="addMSModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addMSModalLabel">Add a Mapping Scale Level</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form method="POST" action="{{ action('MappingScaleController@store') }}">
                                    @csrf

                                    <div class="modal-body">

                                        <div class="form-group row">
                                            <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>

                                            <div class="col-md-8">
                                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" required autofocus>

                                                @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="abbreviation" class="col-md-4 col-form-label text-md-right">Abbreviation</label>

                                            <div class="col-md-8">
                                                <input id="abbreviation" type="text" class="form-control @error('abbreviation') is-invalid @enderror" name="abbreviation" maxlength="5" required autofocus>

                                                @error('abbreviation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="colour" class="col-md-4 col-form-label text-md-right">Colour</label>

                                            <div class="col-md-8">
                                                <input id="colour" type="color" class="form-control @error('colour') is-invalid @enderror" name="colour" required autofocus list="colours">
                                                <datalist id="colours">
                                                    <option value="#494444">
                                                    <option value="#726f6f">
                                                    <option value="#8b8989">
                                                    <option value="#bbbbbb">
                                                    <option value="#aaaaaa">

                                                    <option value="#011f4b">
                                                    <option value="#03396c">
                                                    <option value="#005b96">
                                                    <option value="#6497b1">
                                                    <option value="#b3cde0">

                                                    <option value="#991101">
                                                    <option value="#c23210">
                                                    <option value="#d65f59">
                                                    <option value="#ff8ab3">
                                                    <option value="#ffd0c2">

                                                    <option value="#009c1a">
                                                    <option value="#22b600">
                                                    <option value="#26cc00">
                                                    <option value="#7be382">
                                                    <option value="#d2f2d4">

                                                    <option value="#7f6b00">
                                                    <option value="#ccac00">
                                                    <option value="#ffd700">
                                                    <option value="#ffeb7f">
                                                    <option value="#fff7cc">
                                                </datalist>

                                                @error('colour')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                                            <div class="col-md-8">
                                                
                                                <textarea id="description" class="form-control" @error('description') is-invalid @enderror rows="3" name="description" required autofocus>
                                                </textarea>

                                                @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <input type="hidden" class="form-check-input" name="program_id" value="{{$program->program_id}}">

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

                </div>

                <div class="card-footer">
                    <a href="{{route('programWizard.step1', $program->program_id)}}"><button
                            class="btn btn-sm btn-primary mt-3 col-3 float-left"><i class="bi bi-arrow-left ml-2"></i> Program Learning Outcomes</button></a>

                    <a href="{{route('programWizard.step3', $program->program_id)}}"><button
                            class="btn btn-sm btn-primary mt-3 col-3 float-right">Courses <i class="bi bi-arrow-right ml-2"></i></button></a>
                </div>


            </div>
        </div>


    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
  
      $("form").submit(function () {
        // prevent duplicate form submissions
        $(this).find(":submit").attr('disabled', 'disabled');
        $(this).find(":submit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
  
      });
    });
  </script>

@endsection