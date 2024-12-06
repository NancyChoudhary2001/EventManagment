<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Dropdown</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
     .fa-user-icon {
      font-size: 24px;
      color: #6c757d; /* Muted color */
      background-color: #dee2e6; /* Light gray background */
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
</head>
<body>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('dashboard')}}" class="nav-link">{{ __('lang.home') }}</a>
      </li>
    </ul>
  
    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto">
      <!-- Language Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link  btn" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-solid fa-flag"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
          <li><a class="dropdown-item" href="/setlang/En">English</a></li>
          <li><a class="dropdown-item" href="/setlang/Fr">French</a></li>
          <li><a class="dropdown-item" href="/setlang/KO">Korean</a></li>
        </ul>
      </li>
  
      <!-- Profile Dropdown -->
<li class="nav-item dropdown ms-3">
  <a href="#" class="nav-link d-flex align-items-center" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
    <!-- User's Name -->
    <span class="me-2">
      {{ Auth::user()->first_name ?? 'Guest' }} {{ Auth::user()->last_name ?? '' }}
    </span>
    <!-- Profile Picture or Default Icon -->
    @if(Auth::user() && Auth::user()->profile_picture)
      <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
    @else
      <div class="fa-user-icon">
        <i class="fa-solid fa-user"></i>
      </div>
    @endif
  </a>
  <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser">
    <li>
      <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
        <i class="fa-solid fa-user me-2"></i> Profile
      </a>
    </li>
    <li>
      <a class="dropdown-item d-flex align-items-center" href="{{ route('signout')}}">
        <i class="fa-solid fa-right-from-bracket me-2"></i> Sign Out
      </a>
    </li>
  </ul>
</li>

    </ul>
  </nav>
  
</body>