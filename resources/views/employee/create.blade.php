@php
    $selectedCareerPart = old('career_part');
@endphp
<div class="form-card-container">
    <div class="form-card" id="save-form">
        <div id="window-close" width="30" height="30">
            <i class="fa fa-times fa-x" style="color:red"></i>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="display-8" name="form-title"></h1>
                    <div>
                        @if ($errorMessage = Session::get("saveError"))
                        <div class="alert alert-danger hide-message">
                            <ul>
                                <li>{{ $errorMessage }}</li>
                            </ul>
                        </div><br />
                        @endif

                        <form id="save-create" method="post" action="/save-employees" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group d-flex justify-content-center align-items-center">
                                <label class="file-input">
                                    <span class="file-input-label">Choose Image</span>
                                    <input type="hidden" id="imageData" name="image_file" value=""/>
                                    <input id="file-upload" type="file" name="image" data-image="{{ old('image') }}" onchange="loadPhoto(event)">
                                        <div id="preview"><img src="{{ old('image') }}" alt="Image" /></div>
                                    </input>
                                </label>
                                @error('image')
                                    <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mt-4">
                                <input type="text" class="form-control input" name="employee_id" disabled />
                                <input type="hidden" id="employee_id" name="employee_id" value="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control input" placeholder="Name" name="name" value="{{ old('name') }}" max="50" onkeyup="checkValidName(event);"/>
                                <span id="nameErr" style="color:red"></span>
                                @error('name')
                                <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control input" placeholder="NRC" name="nrc" value="{{ old('nrc') }}" />
                                @error('nrc')
                                <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control input" placeholder="Phone Number" name="phone" value="{{ old('phone') }}" />
                                @error('phone')
                                <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control input" placeholder="Email" name="email" value="{{ old('email') }}" />
                                @error('email')
                                <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-2">
                                <label>Gender:</label>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" value="1" checked {{ old('gender') == 1 ? 'checked' : '' }} />
                                            <label class="form-check-label">Male</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" value="2" {{ old('gender') == 2 ? 'checked' : '' }} />
                                            <label class="form-check-label">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="date" class="form-control input" placeholder="Date of Birth" name="date_of_birth" value="{{ old('date_of_birth') }}" />
                                @error('date_of_birth')
                                <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <textarea class="form-control input" placeholder="Address" name="address">{{ old('address') }}</textarea>
                                @error('address')
                                <div class="alert alert-danger hide">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label>Language:</label>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="languages[]" value="1" {{ in_array(1, old('languages', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label">English</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="languages[]" value="2" {{ in_array(2, old('languages', [])) ? 'checked' : '' }}>
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
                                            <input class="form-check-input" type="checkbox" name="programming_languages[]" value="1" {{ in_array(1, old('programming_languages', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label">C++</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="programming_languages[]" value="4" {{ in_array(4, old('programming_languages', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label">React</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="programming_languages[]" value="2" {{ in_array(2, old('programming_languages', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label">Java</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="programming_languages[]" value="5" {{ in_array(5, old('programming_languages', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label">Android</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="programming_languages[]" value="3" {{ in_array(3, old('programming_languages', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label">PHP</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="programming_languages[]" value="6" {{ in_array(6, old('programming_languages', [])) ? 'checked' : '' }}>
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
                                    <option value="1" {{ $selectedCareerPart == 1 ? 'selected' : '' }}>Font End</option>
                                    <option value="2" {{ $selectedCareerPart == 2 ? 'selected' : '' }}>Back End</option>
                                    <option value="3" {{ $selectedCareerPart == 3 ? 'selected' : '' }}>Full Stack</option>
                                    <option value="4" {{ $selectedCareerPart == 4 ? 'selected' : '' }}>Mobile</option>
                                </select>
                                @error('career_part')
                                        <div class="alert alert-danger hide">{{ $message->first('career_part') }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3 mb-2">
                                <label for="">Level: &nbsp; &nbsp;</label>
                                <select class="form-select form-select-lg mb-3" name="level" aria-label=".form-select-lg example">
                                    <option value="1" {{ old('level') == 1 ? 'selected' : '' }}>Begineer</option>
                                    <option value="2" {{ old('level') == 2 ? 'selected' : '' }}>Junineer Engineer</option>
                                    <option value="3" {{ old('level') == 3 ? 'selected' : '' }}>Engineer</option>
                                    <option value="4" {{ old('level') == 4 ? 'selected' : '' }}>Senior Engineer</option>
                                </select>
                                @error('level')
                                        <div class="alert alert-danger hide">{{ $message->first('level') }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary mt-3 me-2">Save</button>
                            </div>
                        </form>
                        <button class="btn btn-danger mt-3 ms-3" onclick="clearFileInput();">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
