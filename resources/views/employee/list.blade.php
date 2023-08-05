@extends('layout.template-ui')
@section('search')
@php
$loggedInUserRole = request()->session()->get('logedinEmployeeRole');
$loggedInUserId = request()->session()->get('logedinEmployeeId')
@endphp
<form>
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <i class="bx bx-search fs-4 lh-0"></i>
            <input type="text" class="form-control border-0 shadow-none" placeholder="Search." aria-label="Search." />
            <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#basicModal">
                Advance Search
            </button>
        </div>
    </div>

</form>
@endsection
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
        <p>Total Employees: {{$employees->total()}} - current page: {{ $employees->currentPage() }} of {{ $employees->lastPage() }}</p>
        <!-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Basic Tables</h4> -->
        <!-- Bordered Table -->
        <div class="card">
            <h5 class="card-header">Employee List</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-8 mb-8 d-flex justify-content-left mb-2">
                            <ul class="nav nav-tabs nav-fill" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                                        <i class="tf-icons bx bx-home"></i> Home
                                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">3</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="false">
                                        <i class="tf-icons bx bx-user"></i> Profile
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages" aria-selected="false">
                                        <i class="tf-icons bx bx-message-square"></i> Messages
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-4 col-md-12 col-4 mb-4 d-flex justify-content-end mb-2">
                            <!-- screen size width greater than 428px-->
                            <a href="#" class="btn rounded-pill btn-outline-primary me-2 original-btn btn-sm">
                                <span class="fa fa-file-download" style="color: #5278be;"></span>&nbsp; Excel
                            </a>
                            <a href="#" class="btn rounded-pill btn-outline-primary original-btn btn-sm">
                                <span class="fa fa-file-download" style="color: #5278be;"></span>&nbsp; PDF
                            </a>
                            <!-- !! screen size width greater than 428px !!-->

                            <!-- screen size width lower than 428px-->
                            <a href="#" class="btn btn-icon btn-outline-primary me-2 btn-sm icon-btn">
                                <span class="fa fa-file-download"></span>
                            </a>
                            <a href="#" class="btn btn-icon btn-outline-primary me-2 btn-sm icon-btn">
                                <span class="fa fa-file-download"></span>
                            </a>

                            <!-- <a href="#" class="icon-btn">
                                <span class="fa fa-file-download"></span>
                            </a>
                            <a href="#" class="icon-btn">
                                <span class="fa fa-file-download" style="color: #5278be;"></span>
                            </a> -->
                            <!-- !! screen size width lower than 428px !!-->
                        </div>
                    </div>
                    <table class="table table-bordered table-hover table-scroll">
                        <thead class="table-secondary">
                            <tr>
                                <th class="fixed">No</th>
                                <th class="fixed">ID</th>
                                <th class="fixed">Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Career Path</th>
                                <th>Level</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        @if(count($employees) <= 0) <tbody>
                            <tr style="text-align:center">
                                <td colspan="8">
                                    <font style="color:red">Employee Informations is Empty.<a href="list">&nbsp;<i class="fa fa-refresh" aria-hidden="true" style="color:red"></i></a></font>
                                </td>
                            </tr>
                            </tbody>
                            @else
                            <tbody>
                                @foreach ($employees as $employee)
                                <tr data-toggle="tooltip" data-placement="top" data-html="true" title="Created By: {{$employee->created_by}} Created At: {{$employee->created_at}}">
                                    <td class="fixed">{{ $loop->iteration }}</td>
                                    <input type="hidden" id="employeeId" name="employeeId" value="{{$employee->id}}">
                                    <td class="fixed">{{$employee->employee_id}}</td>
                                    <td class="fixed">{{ $employee->name }}</td>
                                    <td>{{ ($loggedInUserRole >= 2 || $loggedInUserId == $employee->employee_id) ? $employee->email : '*****'}}</td>
                                    <td>{{ ($loggedInUserRole >= 2 || $loggedInUserId == $employee->employee_id) ? $employee->phone : '*****'}}</td>
                                    <td name="careerPartCell" data-career="{{ $employee->career_part['careerPartKey'] }}">{{ ($loggedInUserRole >= 2 || $loggedInUserId == $employee->employee_id) ?  $employee->career_part["careerPartValue"] : '*****'}}</td>
                                    <td name="levelCell" data-level="{{ $employee->level['levelKey'] }}">{{ ($loggedInUserRole >= 2 || $loggedInUserId == $employee->employee_id) ?  $employee->level["levelValue"] : '*****'}}</td>
                                    <td style="{{ ($loggedInUserRole < 2) ? 'display:none' : '' }}">
                                        <a href="detail-pages?employee_id={{$employee->id}}"><i class="fa-regular fa-eye fa-xl ms-2" data-toggle="tooltip" data-placement="top" title="{{__('messages.employees_detail')}}" style="color:#244a26"></i></a>
                                        <a class="ms-4" href="edit-pages?employee_id={{$employee->id }}" style="{{ ($loggedInUserRole < 3) ? 'display:none' : '' }}"><i class="fas fa-edit fa-xl ms-2" data-toggle="tooltip" data-placement="top" title="{{__('messages.employees_edit')}}" style="color:blue"></i></a>
                                        <a type="button" class="ms-4" data-bs-toggle="modal" data-bs-target="#modalCenter{{$employee->id}}" style="{{ ($loggedInUserRole < 3) ? 'display:none' : '' }}">
                                            <i class="fa fa-trash fa-xl ms-2" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{__('messages.employees_delete')}}" style="color:red"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            @endif
                    </table>
                </div>
            </div>
        </div>
        <!--/ Bordered Table -->
        <!-- Delete Modal -->
        <div class="modal fade" id="modalCenter{{$employee->id ?? ''}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to delete this employee?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <form method="POST" action="delete-employees">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="employee_id" value="{{ $employee->id ?? ''}}">
                            <button type="submit" class="btn btn-primary">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Delete Modal -->

        <!-- Advance Search Modal -->
        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Advance Search</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameBasic" class="form-label">Id</label>
                                    <input type="text" id="nameBasic" name="employee_id" class="form-control" placeholder="Enter Id" />
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="emailBasic" class="form-label">Name</label>
                                    <input type="text" id="emailBasic" name="name" class="form-control" placeholder="Enter name" />
                                </div>
                                <div class="col mb-0">
                                    <label for="dobBasic" class="form-label">Email</label>
                                    <input type="text" id="dobBasic" name="email" class="form-control" placeholder="Enter email" />
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="emailBasic" class="form-label">Nrc</label>
                                    <input type="text" id="emailBasic" name="nrc" class="form-control" placeholder="Enter nrc" />
                                </div>
                                <div class="col mb-0">
                                    <label for="dobBasic" class="form-label">Address</label>
                                    <input type="text" id="dobBasic" name="address" class="form-control" placeholder="Enter address" />
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="emailBasic" class="form-label">Career Path</label>
                                    <select class="form-select" id="exampleFormControlSelect1" name="career_part" aria-label="Default select example">
                                        <option value="">Choose</option>
                                        <option value="1">Font End</option>
                                        <option value="2">Back End</option>
                                        <option value="3">Full Stack</option>
                                        <option value="4">Mobile</option>
                                    </select>
                                </div>
                                <div class="col mb-0">
                                    <label for="dobBasic" class="form-label">Level</label>
                                    <select class="form-select" id="exampleFormControlSelect1" name="level" aria-label="Default select example">
                                        <option value="">Choose</option>
                                        <option value="1">Begineer</option>
                                        <option value="2">Junior Engineer</option>
                                        <option value="3">Engineer</option>
                                        <option value="4">Senior Engineer</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Search</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- Advance Search Model -->
    </div>
    <!-- / Content -->

    @include('ui.footer')
</div>
<!-- Content wrapper -->
@endsection