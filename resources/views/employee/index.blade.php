@extends('layout.app')

@section('template-content')
@php
$careerParts = [];
$levels = [];
foreach($employees as $employee) {
array_push($careerParts, $employee->career_part);
array_push($levels, $employee->level);
}
$careerParts = array_map("unserialize", array_unique(array_map("serialize", $careerParts)));
$levels = array_map("unserialize", array_unique(array_map("serialize", $levels)));
@endphp
<div class="row list-container">
  <div class="col-sm-12">
    <div id="parent">
      @if ($errors->any())
      <div id="myDiv" class="save-form-reload"></div>
      @endif

      @if ($updateDenine = Session::get("update-denine"))
      <div class="alert alert-danger hide-message">
        <ul>
          <li>{{ $updateDenine }}</li>
        </ul>
      </div><br />
      @endif

      @if ($successMessage = Session::get("success"))
      <div id="myDiv"></div>
      <div class="alert alert-success hide-message">
        <ul>
          <li>{{ $successMessage }}</li>
        </ul>
      </div><br />
      @endif

      @if (isset($saveSuccess))
      <div id="myDiv"></div>
      <div class="alert alert-success hide-message">
        <ul>
          <li>{{ $saveSuccess }}</li>
        </ul>
      </div><br />
      @endif

      @if ($errorMessage = Session::get("saveError"))
      <div id="myDiv" class="save-form-reload"></div>
      <div class="alert alert-success hide-message">
        <ul>
          <li>{{ $errorMessage }}</li>
        </ul>
      </div><br />
      @endif

      <h1 class="display-8">{{__('messages.employees_title')}}</h1>
      <div class="inline-container" style="{{ count($employees) <= 0 ? 'display: none;' : '' }}">
        <form style="display:inline">
          <div class="box">
            <a href="{{ str_replace('show-all-pages', 'employees/download-pdfs', request()->fullUrl()) }}" name="pdf" class="btn btn-outline-primary" style="border-radius: 50px; {{ count($employees) <= 0 ? 'display: none;' : '' }}" {{count($employees) <= 0 ? 'display:none' : ''}}>PDF <i class="fa fa-download"></i></a>
          </div>
          <div class="box" name="excel-btn">
            <a href="{{ str_replace('show-all-pages', 'employees/download-excels', request()->fullUrl()) }}" class="btn btn-outline-primary" style="border-radius: 50px; {{ count($employees) <= 0 ? 'display: none;' : '' }}">Excel <i class="fa fa-download"></i></a>
          </div>

          <div class="box">
            <select id="career-part-select" class="form-select search-select-box" name="career_part" aria-label=".form-select-lg example">
              <option value="">{{__('messages.employees_search_career')}}</option>
              @foreach ($careerParts as $uniqueCareerPart)
              <option value="{{$uniqueCareerPart['careerPartKey']}}" {{(request()->get('career_part') == $uniqueCareerPart['careerPartKey'])  ? 'selected' : ''}}>{{$uniqueCareerPart['careerPartValue']}}</option>
              @endforeach
            </select>
          </div>

          <div class="box">
            <select class="form-select search-select-box" id="level-select" name="level" aria-label=".form-select-lg example">
              <option value="">{{__('messages.employees_search_level')}}</option>
              @foreach ($levels as $uniqueLevel)
              <option value="{{$uniqueLevel['levelKey']}}" {{(request()->get('level') == $uniqueLevel['levelKey'])  ? 'selected' : ''}}>{{$uniqueLevel['levelValue']}}</option>
              @endforeach
            </select>
          </div>
          <div class="box">
            <input type="text" class="form-control form-input" name="search" placeholder="{{__('messages.employees_search_id')}}" value="{{request()->search ?? ''}}" maxlength="5" style="width:300px">
          </div>
          <div class="box">
            <!-- <button type="submit"><i class="fa fa-search search-icon" aria-hidden="true"></i></button> -->
            <!-- <i class="fa fa-search search-icon" aria-hidden="true"></i> -->
            <button type="submit" class="fa fa-search search-icon" aria-hidden="true" style="background: #12e8e8;width: 25px;height: 35px;"></button>
          </div>
        </form>
      </div>

      <div class="mt-3 mb-3" style="float:right">
        <a class="btn btn-primary" id="save">{{__('messages.employees_new')}}</a>
      </div>


    <div class="row">
      <div class="col-sm-2 mt-3">
        <div class="form-check">
          @php
          /**
          * concat sortColumn and sort to fullUrl for sorting
          * if sortColumn already exit in fullUrl replace existing sortColumn and sort with new sortColumn and sort
          * if not exit, check fullUrl exit other parameters. If not exit, concat "?"
          * if already exit, concat "&" behind other parameters
          */
          $url = request()->fullUrl();
          $sortParam = 'sortColumn=updated_at';
          /**
          * check sortColumn parameter exit or not.
          */
          if (strpos($url, 'sortColumn=') !== false) {
          $url = preg_replace('/sortColumn=[^&]+/', 'sortColumn=updated_at', $url);
          $url = preg_replace('/sort=[^&]+/', 'sort=asc', $url);
          } else {
          $url .= (parse_url($url, PHP_URL_QUERY) ? '&' : '?') . $sortParam . '&sort=asc';
          }
          @endphp
          <!-- <i class="fa fa-sort-up fa-lg" style="color: #8297ea;"></i> <a href="{{ $url }}" class="btn btn-outline-primary" style="border-radius: 50px; {{ count($employees) <= 0 ? 'display: none;' : '' }}"> Updated_at</a> -->
          <i class="fa fa-sort-up fa-lg" style="color: #8297ea;  {{ (count($employees) <= 0) ? 'display: none;' : '' }} {{ (request()->sortColumn == null ) ? '' : ((request()->sortColumn == 'updated_at' && request()->sort == 'asc') ? 'display:none' : '') }} "> <a href="{{ $url }}" class="btn btn-outline-primary" style="border-radius: 50px;"> updated_at</a></i>
          
        </div>
        <div class="form-check mt-1">
          @php
          /**
          * concat sortColumn and sort to fullUrl for sorting
          * if sortColumn already exit in fullUrl replace existing sortColumn and sort with new sortColumn and sort
          * if not exit, check fullUrl exit other parameters. If not exit, concat "?"
          * if already exit, concat "&" behind other parameters
          */
          $urlDesc = request()->fullUrl();
          $sortParam = 'sortColumn=updated_at';

          if (strpos($urlDesc, 'sortColumn=') !== false) {
          $urlDesc = preg_replace('/sortColumn=[^&]+/', 'sortColumn=updated_at', $urlDesc);
          $urlDesc = preg_replace('/sort=[^&]+/', 'sort=desc', $urlDesc);
          } else {
          $urlDesc .= (parse_url($urlDesc, PHP_URL_QUERY) ? '&' : '?') . $sortParam . '&sort=desc';
          }
          @endphp
          <i class="fa fa-sort-desc fa-lg" style="color: #8297ea; {{ count($employees) <= 0 ? 'display: none;' : '' }} {{(request()->sortColumn == null || request()->sortColumn == 'created_at' ) ? 'display:none' : ''}} {{ (request()->sortColumn == 'updated_at' && request()->sort == 'desc') ? 'display:none' : '' }}"> <a href="{{ $urlDesc }}" class="btn btn-outline-primary" style="border-radius: 50px;"> Updated_at</a></i>

        </div>
      </div>
      <div class="col-sm-4 mt-3">
        <div class="form-check">
          @php
          /**
          * concat sortColumn and sort to fullUrl for sorting
          * if sortColumn already exit in fullUrl replace existing sortColumn and sort with new sortColumn and sort
          * if not exit, check fullUrl exit other parameters. If not exit, concat "?"
          * if already exit, concat "&" behind other parameters
          */
          $url = request()->fullUrl();
          $sortParam = 'sortColumn=created_at';
          /**
          * check sortColumn parameter exit or not.
          */
          if (strpos($url, 'sortColumn=') !== false) {
          $url = preg_replace('/sortColumn=[^&]+/', 'sortColumn=created_at', $url);
          $url = preg_replace('/sort=[^&]+/', 'sort=asc', $url);
          } else {
          $url .= (parse_url($url, PHP_URL_QUERY) ? '&' : '?') . $sortParam . '&sort=asc';
          }
          @endphp
          <i class="fa fa-sort-up fa-lg" style="color: #8297ea;  {{ (count($employees) <= 0) ? 'display: none;' : '' }} {{ (request()->sortColumn == null || request()->sortColumn == 'updated_at') ? '' : ((request()->sortColumn == 'created_at' && request()->sort == 'asc') ? 'display:none' : '') }} "> <a href="{{ $url }}" class="btn btn-outline-primary" style="border-radius: 50px; {{ count($employees) <= 0 ? 'display: none;' : '' }}"> Created_at</a></i>

        </div>
        <div class="form-check mt-1">
          @php
          /**
          * concat sortColumn and sort to fullUrl for sorting
          * if sortColumn already exit in fullUrl replace existing sortColumn and sort with new sortColumn and sort
          * if not exit, check fullUrl exit other parameters. If not exit, concat "?"
          * if already exit, concat "&" behind other parameters
          */
          $urlDesc = request()->fullUrl();
          $sortParam = 'sortColumn=created_at';

          if (strpos($urlDesc, 'sortColumn=') !== false) {
          $urlDesc = preg_replace('/sortColumn=[^&]+/', 'sortColumn=created_at', $urlDesc);
          $urlDesc = preg_replace('/sort=[^&]+/', 'sort=desc', $urlDesc);
          } else {
          $urlDesc .= (parse_url($urlDesc, PHP_URL_QUERY) ? '&' : '?') . $sortParam . '&sort=desc';
          }
          @endphp
          <i class="fa fa-sort-desc fa-lg" style="color: #8297ea; {{ count($employees) <= 0 ? 'display: none;' : '' }} {{(request()->sortColumn == null || request()->sortColumn == 'updated_at' ) ? 'display:none' : ((request()->sortColumn == 'created_at' && request()->sort == 'desc') ? 'display:none' : '') }}"> <a href="{{ $urlDesc }}" class="btn btn-outline-primary" style="border-radius: 50px;"> Created_at</a></i>

        </div>
      </div>
    </div>

    <div class="mt-3 mb-3">
      <p>{{__('messages.employees_paginate_total')}} {{$employees->total()}} - {{__('messages.employees_paginate_current')}} {{ $employees->currentPage() }} of {{ $employees->lastPage() }}</p>
    </div>

    <table id="employee-table" class="table table-bordered">
      <thead>
        <tr style="background:#82e4ee;">
          <th>{{__('messages.employees_no')}}</th>
          <th>{{__('messages.employees_id')}}</th>
          <th>{{__('messages.employees_name')}}</th>
          <th>{{__('messages.employees_email')}}</th>
          <th>{{__('messages.employees_career')}}</th>
          <th>{{__('messages.employees_level')}}</th>
          <th>{{__('messages.employees_phone')}}</th>
          <th style="width:200px">{{__('messages.employees_actions')}}</th>
        </tr>
      </thead>

      @if(count($employees) <= 0) 
          <tbody>
            <tr style="text-align:center">
              <td colspan="8"><i class="fa fa-regular fa-empty-set" style="color: #4871bb;"></i><font style="color:red">Employee Informations is Empty.</font></td>
            </tr>
          </tbody>
      @else
      <tbody>
        @foreach ($employees as $employee)
        <tr data-toggle="tooltip" data-placement="top" data-html="true" title="Created By: {{$employee->created_by}} Created At: {{$employee->created_at}}">
          <td>{{ $loop->iteration }}</td>
          <input type="hidden" id="employeeId" name="employeeId" value="{{$employee->id}}">
          <td>{{$employee->employee_id}}</td>
          <td>{{ $employee->name }}</td>
          <td>{{ $employee->email }}</td>
          <td name="careerPartCell" data-career="{{ $employee->career_part['careerPartKey'] }}">{{ $employee->career_part["careerPartValue"] }}</td>
          <td name="levelCell" data-level="{{ $employee->level['levelKey'] }}">{{ $employee->level["levelValue"] }}</td>
          <td>{{ $employee->phone }}</td>
          <td>
            <a href="show-detail-pages?employee_id={{$employee->id}}"><i class="fa-regular fa-eye fa-xl ms-2" data-toggle="tooltip" data-placement="top" title="{{__('messages.employees_detail')}}" style="color:#244a26"></i></a>
            <a class="ms-4" href="show-edit-pages?employee_id={{$employee->id}}"><i class="fas fa-edit fa-xl ms-2" data-toggle="tooltip" data-placement="top" title="{{__('messages.employees_edit')}}" style="color:blue"></i></a>
            <a class="ms-4" name="show-alert-msg" onclick="showAlertMessage(this)"><i class="fa fa-trash fa-xl ms-2" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{__('messages.employees_delete')}}" style="color:red"></i></a>
          </td>
        </tr>
        @endforeach
      </tbody>
    @endif
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
      {!! $employees->links() !!}
    </div>
  </div>
  @include('employee.create')
</div>
</div>

<div class="alert-box-container">
  <div class="alart-box-card">
    <div class="alert-msg-name mt-4">Are you sure want to delete?</div>
    <form method="post" action="delete-employees">
      @method('DELETE')
      @csrf
      <div class="d-flex justify-content-center align-items-center">
        <input type="hidden" id="delete_emp_id" name="employee_id" value="" />
        <button type="submit" name="alert_msg_delete" class="btn btn-danger mt-3 me-2">Delete</button>
        <button type="reset" name="alert_msg_cancel" class="btn btn-primary mt-3 ms-3">Cancel</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('footer')
<script>
  if (document.getElementById('myDiv').classList.contains('save-form-reload')) {
    console.log("here save form reload");
    reloadSaveForm();
  }
</script>
@endsection