@extends('layout.app')

@section('title')
Save Project Assignment
@endsection

@section('head')
<script src="js/project-assignment.js"></script>
@endsection

@section('content')

@php
$selectedEmployeeId = Session::get("selectedEmployeeId");
$selectedEmployeeName = Session::get("selectedEmployeeName");
$selectedProjectName = Session::get("selectedProjectName");
$selectedStartDate = Session::get("selectedStartDate");
$selectedEndDate = Session::get("selectedEndDate");

$selectedOldEmployeeId = old('employee_id');
$selectedOldEmployeeName = old('employee_name');
$selectedOldProjectName = old('project_name');
$selectedOldStartDate = old('start_date');
$selectedOleEndDate = old('end_date');
@endphp
{{$selectedProjectName}}
<div class="card-container">
    <div class="card">
        @if ($successMessage = Session::get("success"))
        <div id="myDiv"></div>
        <div class="alert alert-success hide-message">
            <ul>
                <li>{{ $successMessage }}</li>
            </ul>
        </div><br />
        @endif

        @if ($errorMessage = Session::get("saveError"))
        <div class="alert alert-danger hide-message">
            <ul>
                <li>{{ $errorMessage }}</li>
            </ul>
        </div><br />
        @endif
        @if(count($employees) < 1 && count($currentProjects) < 1) <h3 style="text-align:center">Please fill Employee and Project datas first.</h3>
            <a class="btn btn-primary" href="show-all-pages">Go Home</a>

            @else
            <a href="/show-all-pages">
                <i class="fa fa-times fa-x" style="color:red"></i>
            </a>
            <div class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="display-8">{{__('messages.projects_assignments_save_form_title')}}</h1>
                        <div>
                            @if ($errors->has('add_project_name'))
                            <div id="myDiv" class="add-new-project-form-reload"></div>
                            @endif
                            <form method="post" action="/save-projects-assignments" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group mt-3 mb-2">
                                    <label class="project-assignment-require" for="">{{__('messages.projects_assignments_employee_id')}}</label>
                                    <select class="form-select form-select-lg mb-3" id="emp-id-select" name="employee_id" aria-label=".form-select-lg example">
                                        <option value="">{{__('messages.employees_choose')}}</option>
                                        @foreach ($employees as $employee)
                                        <option value="{{$employee->id}}" {{(($selectedEmployeeId ?? $selectedOldEmployeeId) == $employee->id) ? 'selected' : ''}}>{{$employee->employee_id}}</option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                    <div class="text-danger mt-1 hide">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">{{__('messages.projects_assignments_employee_name')}}</label>
                                    <input type="text" class="form-control input" name="employee_name" value='{{$selectedEmployeeName ?? $selectedOldEmployeeName}}' disabled />
                                    <input type="hidden" id="emp-name" name="employee_name" value="{{($selectedEmployeeName ?? $selectedOldEmployeeName) ?? ''}}" />
                                </div>

                                <div class="form-group mt-3">
                                    <label class="project-assignment-require" for="">{{__('messages.projects_assignments_start_date')}}</label>
                                    <input type="date" id="emp-start-date" class="form-control input" placeholder="Start Date" name="start_date" value="{{($selectedStartDate ?? $selectedOldStartDate) ?? ''}}"  {{count($currentProjects) < 1 ? 'disabled' : ''}}/>
                                </div>
                                @error('start_date')
                                <div class="text-danger mt-1 hide">{{ $message }}</div>
                                @enderror

                                <div class="form-group mt-3">
                                    <label class="project-assignment-require" for="">{{__('messages.projects_assignments_end_date')}}</label>
                                    <input type="date" id="emp-end-date" class="form-control input" placeholder="End Date" name="end_date" value="{{($selectedEndDate ?? $selectedOleEndDate) ?? ''}}"  {{count($currentProjects) < 1 ? 'disabled' : ''}}/>
                                </div>
                                @error('end_date')
                                <div class="text-danger mt-1 hide">{{ $message }}</div>
                                @enderror

                                <div class="form-group mt-3 mb-2">
                                    <label class="project-assignment-require" for="">{{__('messages.projects_assignments_project')}}</label>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <select class="form-select form-select-lg mb-3 col-md-8" id="emp-project-select" name="project_name" aria-label=".form-select-lg example" {{count($currentProjects) < 1 ? 'disabled' : ''}}>
                                                <option value=''>{{__('messages.employees_choose')}}</option>
                                                @foreach ($currentProjects as $currentProject)
                                                <option value="{{$currentProject->id}}" {{ ((Session::has("selectedProjectName") && selectedProjectName  == $currentProject->name) || (old('project_name') == $currentProject->id))  ? 'selected' : ''}}>
                                                    {{$currentProject->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('project_name')
                                            <div class="text-danger mt-1 hide">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm">
                                            <i class="fa-solid fa-minus" id="project-delete" name="show-alert-msg" style="color: #3128c8;"></i>
                                        </div>
                                        <div class="col-sm">
                                            <i class="fa-solid fa-plus" id="project-add" style="color: #3128c8;"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="project-assignment-require" for="">{{__('messages.projects_assignments_documentations')}}</label>
                                    <div id="drop-area">
                                        <span class="drop-message">Drag and drop files here or click to select</span>
                                        <input type="file" id="file-input" name="files[]" multiple>
                                    </div>
                                    @error('files')
                                    <div class="text-danger mt-1 hide">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="submit" class="btn btn-primary mt-3 me-2">{{__('messages.save_button')}}</button>
                                    <button type="reset" class="btn btn-danger mt-3 ms-3">{{__('messages.reset_button')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
    </div>
</div>

@include('project-assignment.delete')
@include('project-assignment.add-new')
@endsection
@section('footer')
<script>
    if (document.getElementById('myDiv').classList.contains('add-new-project-form-reload')) {
        console.log("here save form reload");
        reloadAddNewProjectForm();
    }
</script>
@endsection