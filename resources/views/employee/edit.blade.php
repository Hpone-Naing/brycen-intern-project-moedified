@extends('layout.app')

@section('title')
Edit Employee
@endsection

@section('head')
@endsection

@section('content')
@php
    $employeeCareerPart = $employee->career_part;
    $employeeLevel  = $employee->level;
    $employeeLanguages = explode(" ", $employee->language);
    $employeeProgrammingLanguages = json_decode($employee->programmingLanguages, true);
    $employeeProgrammingLanguageId = array_column($employeeProgrammingLanguages, 'id');

    $selectedCareerPart = old('career_part');
    $selectedLevel = old('level');
    $selectedLanguages = old('languages', []);
    $selectedProgrammingLanguages = old('programming_languages', []);
@endphp

<div class="form-card-container">
    <div class="edit-form-card" id="save-form">
        <a href="show-all-pages">
                <i class="fa fa-times fa-x" style="color:red"></i>
        </a>
        <div class="content">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="display-8" name="form-title"></h1>
                    <div>
                        @if (isset($saveError))
                        <div class="alert alert-danger hide-message">
                            <ul>
                                <li>{{ $saveError }}</li>
                            </ul>
                        </div><br />
                        @endif

                        <form id="save-create" method="post" action="/update-employees/{{$employee->id}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group d-flex justify-content-center align-items-center">
                                <label class="file-input">
                                    <span class="file-input-label">Choose Image</span>
                                    <input id="file-upload" type="file" name="image" data-image="{{$employee->image ?? old('image') }}" onchange="loadPhoto(event)">
                                        <!-- <div id="preview"><img src="employee-photo/{{$employee->image ?? old('image') }}" alt="Image" /></div> -->
                                        <div id="preview"><img src="{{ asset('employee-photo/' . ($employee->image ?? old('image'))) }}" alt="Image"></div>
                                    </input>
                                </label>
                                @error('image')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mt-4">
                                <input type="text" class="form-control input" name="employee_id" value="{{ $employee->employee_id }}" disabled />
                                <input type="hidden" id="employee_id" name="employee_id" value="{{ $employee->id }}">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control input" placeholder="Name" name="name" value="{{$employee->name}}" max="50" onkeyup="checkValidName(event);"/>
                                <span id="nameErr" style="color:red"></span>
                                @error('name')
                                <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control input" placeholder="NRC" name="nrc" value="{{$employee->nrc ?? old('nrc') }}" />
                                @error('nrc')
                                <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control input" placeholder="Phone Number" name="phone" value="{{$employee->phone ?? old('phone') }}" />
                                @error('phone')
                                <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control input" placeholder="Email" name="email" value="{{$employee->email ?? old('email') }}" />
                                @error('email')
                                <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-2">
                                <label>Gender:</label>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" value="1" checked {{($employee->gender ?? old('gender')) == 1 ? 'checked' : '' }} />
                                            <label class="form-check-label">Male</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" value="2" {{($employee->gender ?? old('gender')) == 2 ? 'checked' : '' }} />
                                            <label class="form-check-label">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="date" class="form-control input" placeholder="Date of Birth" name="date_of_birth" value="{{$employee->date_of_birth ?? old('date_of_birth') }}" />
                                @error('date_of_birth')
                                <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <textarea class="form-control input" placeholder="Address" name="address">{{$employee->address ?? old('address') }}</textarea>
                                @error('address')
                                <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label>Language:</label>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="languages[]" value="1" {{ in_array(1, ($employeeLanguages ?? old('languages', []))) ? 'checked' : '' }}>
                                            <label class="form-check-label">English</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="languages[]" value="2" {{ in_array(2,  ($employeeLanguages ?? old('languages', []))) ? 'checked' : '' }}>
                                            <label class="form-check-label">Japan</label>
                                        </div>
                                    </div>
                                    @error('languages')
                                        <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label>Programming Language:</label>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="programming_languages[]" value="1" {{ in_array(1, ($employeeProgrammingLanguageId ?? old('programming_languages', []))) ? 'checked' : '' }}>
                                            <label class="form-check-label">C++</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="programming_languages[]" value="4" {{ in_array(4, ($employeeProgrammingLanguageId ?? old('programming_languages', []))) ? 'checked' : '' }}>
                                            <label class="form-check-label">React</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="programming_languages[]" value="2" {{ in_array(2, ($employeeProgrammingLanguageId ?? old('programming_languages', []))) ? 'checked' : '' }}>
                                            <label class="form-check-label">Java</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="programming_languages[]" value="5" {{ in_array(5, ($employeeProgrammingLanguageId ?? old('programming_languages', []))) ? 'checked' : '' }}>
                                            <label class="form-check-label">Android</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="programming_languages[]" value="3" {{ in_array(3, ($employeeProgrammingLanguageId ?? old('programming_languages', []))) ? 'checked' : '' }}>
                                            <label class="form-check-label">PHP</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="programming_languages[]" value="6" {{ in_array(6, ($employeeProgrammingLanguageId ?? old('programming_languages', []))) ? 'checked' : '' }}>
                                            <label class="form-check-label">Laravel</label>
                                        </div>
                                    </div>
                                    @error('programming_languages')
                                        <div class="alert alert-danger hide">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mt-3 mb-2">
                                <label for="">Career Part: &nbsp; &nbsp;</label>
                                <select class="form-select form-select-lg mb-3" name="career_part" aria-label=".form-select-lg example">
                                    <option value="1" {{($employeeCareerPart ?? $selectedCareerPart) == 1 ? 'selected' : '' }}>Font End</option>
                                    <option value="2" {{($employeeCareerPart ?? $selectedCareerPart) == 2 ? 'selected' : '' }}>Back End</option>
                                    <option value="3" {{($employeeCareerPart ?? $selectedCareerPart) == 3 ? 'selected' : '' }}>Full Stack</option>
                                    <option value="4" {{($employeeCareerPart ?? $selectedCareerPart) == 4 ? 'selected' : '' }}>Mobile</option>
                                </select>
                                @error('career_part')
                                        <div class="alert alert-danger hide">{{ $message->first('career_part') }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3 mb-2">
                                <label for="">Level: &nbsp; &nbsp;</label>
                                <select class="form-select form-select-lg mb-3" name="level" aria-label=".form-select-lg example">
                                    <option value="1" {{($employeeLevel ?? old('level')) == 1 ? 'selected' : '' }}>Begineer</option>
                                    <option value="2" {{($employeeLevel ?? old('level')) == 2 ? 'selected' : '' }}>Junineer Engineer</option>
                                    <option value="3" {{($employeeLevel ?? old('level')) == 3 ? 'selected' : '' }}>Engineer</option>
                                    <option value="4" {{($employeeLevel ?? old('level')) == 4 ? 'selected' : '' }}>Senior Engineer</option>
                                </select>
                                @error('level')
                                        <div class="alert alert-danger hide">{{ $message->first('level') }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary mt-3 me-2">Save</button>
                                <button type="reset" class="btn btn-danger mt-3 ms-3">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footer')
@endsection