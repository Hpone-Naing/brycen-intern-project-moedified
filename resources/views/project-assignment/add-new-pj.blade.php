@extends('layout.template-ui')
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @if ($successMessage = Session::get("success"))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{$successMessage}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errorMessage = Session::get("saveError"))
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{$errorMessage}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add New</span> Assignment</h4>

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">

            <!-- Basic with Icons -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">

                    </div>
                    <div class="card-body">
                        <form method="post" action="/save-projects-assignments" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-message">Employee ID</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <select class="form-select" id="emp-id-select" name="employee_id" aria-label="Default select example">
                                            <option value="">Choose</option>
                                            @foreach ($employees as $employee)
                                            <option value="{{$employee->id}}">{{$employee->employee_id}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label require-field" for="basic-icon-default-fullname">Employee Name</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" id="basic-icon-default-fullname" name="employee_name" placeholder="Name" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-message">Project Name</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <select class="form-select" id="emp-project-select" name="project_name" aria-label="Default select example">
                                            <option value=''>Choose</option>
                                            @foreach ($currentProjects as $currentProject)
                                            <option value="{{$currentProject->id}}">
                                                {{$currentProject->name}}
                                            </option>
                                            @endforeach
                                        </select>

                                        <a type="button" class="btn btn-icon rounded-pill btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#addProjectModel">
                                            <i class="fa-solid fa-plus" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{__('messages.employees_delete')}}"></i>
                                        </a>
                                        <a type="button" id="project-delete" class="btn btn-icon rounded-pill btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#deleteProjectModel">
                                            <i class="fa-solid fa-minus" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{__('messages.employees_delete')}}"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label require-field" for="basic-icon-default-email">Start Date</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                        <input type="date" id="basic-icon-default-email" name="start_date" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-icon-default-email2" />
                                    </div>
                                    <div class="form-text">You can use letters, numbers & periods</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-phone">End Date</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                                        <input type="date" id="basic-icon-default-phone" name="end_date" class="form-control phone-mask" placeholder="0912345678" aria-label="0912345678" aria-describedby="basic-icon-default-phone2" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-phone">Documentations</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                                        <input type="file" name="files[]" multiple />
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Project Modal -->
        <div class="modal fade" id="addProjectModel" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Add New Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="save-projects">
                            @csrf
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Project Name</label>
                                    <input type="text" name="add_project_name" class="form-control" placeholder="Enter Project Name" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <!--/ Add Project Model -->

        <!-- Delete Project Modal -->
        <div class="modal fade" id="deleteProjectModel" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Choose Delete Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="delete-projects">
                            @method('DELETE')
                            @csrf
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Project Name:</label>
                                    <select class="form-select" id="delete-project-select" name="delete_project" aria-label="Default select example">
                                    </select>
                                </div>
                            </div>
                        <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Delete Project Model -->

    </div>
    <!-- / Content -->
    @include('ui.footer')
</div>
<!-- Content wrapper -->
@endsection