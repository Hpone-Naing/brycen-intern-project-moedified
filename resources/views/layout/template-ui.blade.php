@extends('layout.app')
@section('template-content')
@php
$loggedInUserRole = request()->session()->get('logedinEmployeeRole');
@endphp
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    <!-- Menu -->

    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
      <div class="app-brand demo">
        <a href="index" class="app-brand-link">
          <img src="assets/img/favicon/favicon.png" width="30">
          <span class="app-brand-logo demo">
          </span>
          <span class="app-brand-text demo menu-text fw-bolder ms-2">E&P Management</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
          <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
      </div>

      <div class="menu-inner-shadow"></div>

      <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item active">
          <a href="index" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
          </a>
        </li>

        <li class="menu-header small text-uppercase">
          <span class="menu-header-text">Employees</span>
        </li>
        <li class="menu-item">


        <li class="menu-item">
          <a href="list" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">List</div>
          </a>
        </li>

        <li class="menu-item">
          <a href="add-new" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">Add New</div>
          </a>
        </li>
        </li>

        <!-- Components -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Project Assignment</span></li>
        <!-- Cards -->
        <li class="menu-item">
          <a href="create-project-assignments" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">Add New</div>
          </a>
        </li>

        <li class="menu-header small text-uppercase"><span class="menu-header-text">Request Password Reset</span></li>
        <!-- Cards -->
        <li class="menu-item">
          <a href="pending-reset-password-list-form" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">Pending List
              <!-- <span class="badge badge-center rounded-pill bg-danger"></span> -->

            </div>
          </a>
        </li>

      </ul>
    </aside>
    <!-- / Menu -->

    <!-- Layout container -->
    <div class="layout-page">
      <!-- Navbar -->
      <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
          <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
          </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
          <!-- Search -->
          @yield('search')

          <!-- /Search -->

          <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
              <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                  <img src="/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item" href="#">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-online">
                          <img src="/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <span class="fw-semibold d-block">{{request()->session()->get('logedinEmployeeName')}}</span>
                        <small class="text-muted">
                          @php
                          $role = '';
                          $roleId = request()->session()->get('logedinEmployeeRole');
                          switch ($roleId) {
                          case 1:
                          $role = "Employee";
                          break;
                          case 2:
                          $role = "Admin";
                          break;
                          case 3:
                          $role = "Manager";
                          break;
                          case 4:
                          $role = "General Manager";
                          break;
                          default:
                          $role = "Guess";
                          break;
                          }
                          @endphp

                          {{$role}}
                        </small>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <div class="dropdown-divider"></div>
                </li>

                <li>
                  <a class="dropdown-item" href="logout">
                    <i class="bx bx-power-off me-2"></i>
                    <span class="align-middle">Log Out</span>
                  </a>
                </li>
              </ul>
            </li>
            <!--/ User -->
          </ul>
        </div>
      </nav>

      @yield('content')
    </div>
    <!-- / Layout page -->
  </div>

  <!-- Overlay -->
  <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

@endsection