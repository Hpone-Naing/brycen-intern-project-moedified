@extends('layout.template-ui')
@section('content')
@php
$loggedInUserRole = request()->session()->get('logedinEmployeeRole');
@endphp
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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add New</span> Employees</h4>

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">

            <!-- Basic with Icons -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">

                    </div>
                    <div class="card-body">
                        <form method="post" action="/save-employees" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">ID</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" id="basic-icon-default-fullname" name="employee_id" value="{{$autoGenerateEmployeeId}}" placeholder="ID" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label require-field" for="basic-icon-default-fullname">Password</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    @error('password')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label require-field" for="basic-icon-default-fullname">Name</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" id="basic-icon-default-fullname" name="name" placeholder="Name" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                    </div>
                                    @error('name')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label require-field" for="basic-icon-default-fullname">NRC</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" id="basic-icon-default-fullname" name="nrc" placeholder="NRC" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                    </div>
                                    @error('nrc')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label require-field" for="basic-icon-default-email">Email</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                        <input type="text" id="basic-icon-default-email" name="email" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-icon-default-email2" />
                                        <span id="basic-icon-default-email2" class="input-group-text">@example.com</span>
                                    </div>
                                    @error('email')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">You can use letters, numbers & periods</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-phone">Phone No</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                                        <input type="text" id="basic-icon-default-phone" name="phone" class="form-control phone-mask" placeholder="0912345678" aria-label="0912345678" aria-describedby="basic-icon-default-phone2" />
                                    </div>
                                    @error('phone')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-phone">Gender</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="1" checked />
                                            <label class="form-check-label" for="inlineRadio1">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="2" />
                                            <label class="form-check-label" for="inlineRadio1">Female</label>
                                        </div>
                                    </div>
                                    @error('gender')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-phone">Date of Birth</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                                        <input type="date" name="date_of_birth" id="basic-icon-default-phone" class="form-control phone-mask" placeholder="Date of Birth" aria-label="Date of Birth" aria-describedby="basic-icon-default-phone2" />
                                    </div>
                                    @error('date_of_birth')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-message">Address</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-message2" class="input-group-text"><i class="bx bx-comment"></i></span>
                                        <textarea id="basic-icon-default-message" class="form-control" name="address" placeholder="Hi, Do you have a moment to talk Joe?" aria-label="Hi, Do you have a moment to talk Joe?" aria-describedby="basic-icon-default-message2"></textarea>
                                    </div>
                                    @error('address')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-phone">Employment Type</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="employment_type" id="inlineRadio1" value="1" checked />
                                            <label class="form-check-label" for="inlineRadio1">Probation</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="employment_type" id="inlineRadio1" value="2" />
                                            <label class="form-check-label" for="inlineRadio1">Parmanent</label>
                                        </div>
                                    </div>
                                    @error('employment_type')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-message">Role</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <select class="form-select" id="exampleFormControlSelect1" name="role" aria-label="Default select example">
                                            <option value="">Choose</option>
                                            <option value="1">User</option>
                                            <option value="2">Admin</option>
                                            <option value="3" style="{{ ($loggedInUserRole < 3) ? 'display:none' : '' }}">Manager</option>
                                            <option value="4" style="{{ ($loggedInUserRole < 4) ? 'display:none' : '' }}">General Manager</option>
                                        </select>
                                    </div>
                                    @error('role')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-message">Language</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="languages[]" value="1" />
                                            <label class="form-check-label" for="inlineCheckbox1">English</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="languages[]" value="2" />
                                            <label class="form-check-label" for="inlineCheckbox1">Japan</label>
                                        </div>
                                    </div>
                                    @error('languages')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-message">Programming Language</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="programming_languages[]" value="1" />
                                            <label class="form-check-label" for="inlineCheckbox1">C++</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="programming_languages[]" value="2" />
                                            <label class="form-check-label" for="inlineCheckbox1">Java</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="programming_languages[]" value="3" />
                                            <label class="form-check-label" for="inlineCheckbox1">PHP</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="programming_languages[]" value="4" />
                                            <label class="form-check-label" for="inlineCheckbox1">React</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="programming_languages[]" value="5" />
                                            <label class="form-check-label" for="inlineCheckbox1">Android</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="programming_languages[]" value="6" />
                                            <label class="form-check-label" for="inlineCheckbox1">Laravel</label>
                                        </div>
                                    </div>
                                    @error('programming_languages')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-message">Career Path</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <select class="form-select" id="exampleFormControlSelect1" name="career_part" aria-label="Default select example">
                                            <option value="">Choose</option>
                                            <option value="1">Font End</option>
                                            <option value="2">Back End</option>
                                            <option value="3">Full Stack</option>
                                            <option value="4">Mobile</option>
                                        </select>
                                    </div>
                                    @error('career_part')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label require-field" for="basic-icon-default-message">Level</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <select class="form-select" id="exampleFormControlSelect1" name="level" aria-label="Default select example">
                                            <option value="">Choose</option>
                                            <option value="1">Begineer</option>
                                            <option value="2">Junior Engineer</option>
                                            <option value="3">Engineer</option>
                                            <option value="4">Senior Engineer</option>
                                        </select>
                                    </div>
                                    @error('level')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
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
    </div>
    <!-- / Content -->

    @include('ui.footer')
</div>
<!-- Content wrapper -->
@endsection