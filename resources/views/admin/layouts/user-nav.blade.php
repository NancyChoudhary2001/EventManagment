<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
  <a class="navbar-brand mb-3" href="#">EventHub</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto align-items-center">
      <li class="nav-item me-3">
        <a class="nav-link" href="{{ route('eventuser') }}">Home</a>
      </li>
      <li class="nav-item me-3">
        <a class="nav-link" href="{{ route('user.events') }}">Events</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="dropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="me-2">
            {{ Auth::user()->first_name ?? 'Guest' }} {{ Auth::user()->last_name ?? '' }}
          </span>
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
            <a class="dropdown-item d-flex align-items-center" href="{{ route('userprofile.edit') }}">
              <i class="fa-solid fa-user me-2"></i> Profile
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('usersignout') }}">
              <i class="fa-solid fa-right-from-bracket me-2"></i> Sign Out
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>