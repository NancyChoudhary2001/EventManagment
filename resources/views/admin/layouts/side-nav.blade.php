<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    {{-- <a href="index3.html" class="brand-link">
      <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a> --}}

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <a href="#" class="nav-link d-flex align-items-center" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- Profile Picture or Default Icon -->
            @if(Auth::user() && Auth::user()->profile_picture)
                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover; margin-right: 10px;">
            @else
                <div class="fa-user-icon me-2">
                    <i class="fa-solid fa-user"></i>
                </div>
            @endif
            
            <!-- User's Name -->
            <span>
                {{ Auth::user()->first_name ?? 'Guest' }} {{ Auth::user()->last_name ?? '' }}
            </span>
        </a>
    </div>
    

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open"> 
          
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                {{__('lang.dashboard')}}
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('index') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-users"></i>
              <p>
                {{__('lang.user')}}
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('branch')}}" class="nav-link">
              <i class="nav-icon fa-solid fa-code-branch"></i>
              <p>
                {{__('lang.branch')}}
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('events')}}" class="nav-link">
              <i class="nav-icon fa-solid fa-calendar-days"></i>
              <p>
                {{__('lang.event')}}
              </p>
            </a>
          </li>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>