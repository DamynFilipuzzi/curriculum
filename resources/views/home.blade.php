@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div style="width: 100%;border-bottom: 1px solid #DCDCDC">
        <h2 style="float: left;">My Dashboard</h2>
        </div>

        <div class="col-md-12" style="display: flex">

                <div class="card shadow rounded" style="float: left;width:24%;margin:20px;border-style: solid;
                border-color: #6495ED;">
                    <div class="card-body" style="background-color:#6495ED;">
                        <span style="color: white;font-size:24px;">
                        My Programs
                        </span>
                    </div>

                    <div class="card-footer" style="padding:0%;">
                        <a class="nav-link" href="{{ route('programs.index') }}" style="color: #6495ED">
                            Active and in progress courses &#10141;</a>
                    </div>
                </div>

                <div class="card shadow rounded" style="float: left;width:25%;margin:20px;border-style: solid;
                border-color: #4169E1;">
                    <div class="card-body" style="background-color: #4169E1;">
                        <span style="color: white;font-size:24px;">
                        My Courses
                        </span>
                    </div>

                    <div class="card-footer" style="padding:0%;margin-left:3px">
                        <a class="nav-link" href="{{ route('courses.index') }}" style="color: #4169E1">
                            Active and in progress programs &#10141;</a>
                    </div>
                </div>

                <div class="card shadow rounded" style="float: left;width:24%;margin:20px;border-style: solid;
                border-color: #32CD32;">
                    <div class="card-body" style="background-color: #32CD32;">
                        <span style="color: white;font-size:24px;">
                        Registration Invite
                        </span>
                    </div>

                    <div class="card-footer" style="padding:0%;margin-left:3px">
                        <a class="nav-link" href="{{ route('requestInvitation') }}" style="color: #32CD32">
                            Invite somebody to the website &#10141;</a>
                    </div>
                </div>


        </div>
    </div>
</div>
@endsection
