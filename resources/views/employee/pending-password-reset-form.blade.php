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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pending Password Reset Request</span> Employees</h4>
        <div class="row">
            <div class="col-lg-12 col-md-12 order-1">
                <div class="row">
                    @foreach( $pendingEmployeeList as $pendingEmployee )
                    <div class="col-lg-4 col-md-12 col-4 mb-4">
                        <div class="card" data-bs-toggle="modal" data-bs-target="#passwordResetMemberModel{{$pendingEmployee->passwordRequestEmployeeId}}">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0 ">
                                        <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded bg-danger" />
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">{{$pendingEmployee->passwordRequestEmployeeName}}</span>
                                <h3 class="card-title mb-2"></h3>
                            </div>
                        </div>
                    </div>
                    <!-- Member Password Reset Modal -->
                    <div class="modal fade" id="passwordResetMemberModel{{$pendingEmployee->passwordRequestEmployeeId}}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Reset Password Request Employee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="members-passwords-reset">
                                        @csrf
                                        <input type="hidden" name="request_id" value="{{$pendingEmployee->passwordRequestEmployeeId}}">
                                        <input type="hidden" name="heigher_level_id" value="{{$pendingEmployee->heighLevelEmployeeId}}">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameWithTitle" class="form-label">Employee Id</label>
                                                <input type="text" name="request_employee_id" class="form-control" value="{{$pendingEmployee->passwordRequestEmployeeEmployeeId}}" readonly />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameWithTitle" class="form-label">Employee Name</label>
                                                <input type="text" name="request_employee_name" class="form-control" value="{{$pendingEmployee->passwordRequestEmployeeName}}" readonly />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameWithTitle" class="form-label">Employee Email</label>
                                                <input type="text" name="request_employee_email" class="form-control" value="{{$pendingEmployee->passwordRequestEmployeeEmail}}" readonly />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameWithTitle" class="form-label">Your Email</label>
                                                <input type="text" name="heigher_level_employee_email" class="form-control" value="{{$pendingEmployee->heighLevelEmployeeEmail}}" readonly />
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col mb-3 form-password-toggle">
                                                <label for="nameWithTitle" class="form-label">Reset Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="password" class="form-control" name="reset_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--/ Member Password Reset Model -->
                    @endforeach
                    
                </div>
            </div>


        </div>
    </div>
    <!-- / Content -->

    @include('ui.footer')
</div>
<!-- Content wrapper -->
@endsection