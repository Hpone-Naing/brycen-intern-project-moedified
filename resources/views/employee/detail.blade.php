@extends('layout.app')

@section('title')
Employee Detail
@endsection

@section('head')
@endsection

@section('content')
<div class="card-container">
    <div class="card">
        <a href="/show-all-pages" style="position: relative; right: 10px;">
            <i class="fa fa-times fa-x" style="color:red"></i>
        </a>
        <div class="content">
            <h1 class="display-8 me-5 edit-form-title" name="form-title">{{__('messages.employees_detail_form_title')}}</h1>

            <div class="row">
                <div class="col-sm-12">
                    <div>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                        @endif
                        <div class="form-group d-flex justify-content-center align-items-center">
                            <label class="file-input">
                                <div id="preview"><img src="{{ asset('employee-photo/' . ($employee->image ?? old('image'))) }}" alt="" style="top:0px; left:0px" /></div>
                                </input>
                            </label>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-2 col-2">
                                <label for="">Name:</label>
                            </div>
                            <div class="col-md-7 col-7">
                                <p>{{$employee->name}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-5">
                            <div class="col-md-2 col-2">
                                <label for="">Nrc:</label>
                            </div>
                            <div class="col-md-7 col-7">
                                <p>{{$employee->nrc}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-5">
                            <div class="col-md-2 col-2">
                                <label for="">Phone:</label>
                            </div>
                            <div class="col-md-7 col-7">
                                <p>{{$employee->phone}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-5">
                            <div class="col-md-2 col-2">
                                <label for="">Email:</label>
                            </div>
                            <div class="col-md-7 col-7">
                                <p>{{$employee->email}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-5">
                            <div class="col-md-2 col-2">
                                <label for="">Address:</label>
                            </div>
                            <div class="col-md-7 col-7">
                                <p>{{$employee->address}}</p>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-2 col-2">

                                <label>Gender:</label>
                            </div>
                            <div class="col-md-7 col-7">
                                <p>{{$employee->gender}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-5">
                            <div class="col-md-3 col-3">
                                <label>Date of Birth:</label>
                            </div>
                            <div class="col-md-5 col-5">
                                <p>{{$employee->date_of_birth}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-5">
                            <div class="col-md-3 col-3">
                                <label for="">Language:</label>
                            </div>
                            <div class="col-md-7 col-7">
                                <p>{{$employee->language}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-5">
                            <div class="col-md-3 col-3">
                                <label for="">Career Part:</label>
                            </div>
                            <div class="col-md-7 col-7">
                                <p>{{$employee->career_part["careerPartValue"]}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-5" style="{{ count($employee->projects) <= 0 ? 'opacity: 0;' : '' }}">
                            <ul>Project Name:
                                @foreach ($employee->projects as $project)
                                <li class="mt-4">{{$project->name}}</li>
                                <div class="row mt-1">
                                    <div class="col-md-3 col-3">
                                        <label for="">Start Date:</label>
                                    </div>
                                    <div class="col-md-7 col-7">
                                        <p>{{$project->pivot->start_date}}</p>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-md-3 col-3">
                                        <label for="">End Date:</label>
                                    </div>
                                    <div class="col-md-7 col-7">
                                        <p>{{$project->pivot->end_date}}</p>
                                    </div>
                                </div>
                                <ol style="display:flex"> Documentations
                                    @foreach ($employee->employeesProjects as $employeesProject)
                                        @foreach ($employeesProject->documentations as $documentation)
                                        @php
                                        $fileNames = explode('.',$documentation->file_name);
                                        $fileExtension = $fileNames[count($fileNames)-1];
                                        @endphp
                                                <li class="mt-3 ms-4" style="{{($project->id == $employeesProject->project_id) ? '' : 'display:none;'}}">
                                                    <a href="{{ route('download', ['file' => $documentation->file_name]) }}">
                                                        <i class="{{ ($fileExtension == 'xlsx' || $fileExtension == 'xls') ? 'fas fa-file-excel fa-4x' : (($fileExtension == 'jpg' || $fileExtension == 'png' || $fileExtension == 'jpeg' || $fileExtension == 'gif') ? 'fa fa-file-image fa-4x' : ( ($fileExtension == 'pdf') ? 'fa fa-file-pdf fa-4x' : 'fa-solid fa-file fa-4x' )) }}" data-toggle="tooltip" data-placement="top" title="{{ $documentation->file_name }}" style="color: blue;"></i>
                                                    </a>
                                                </li>
                                        @endforeach
                                    @endforeach
                                </ol>
                                @endforeach
                            </ul>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
@endsection