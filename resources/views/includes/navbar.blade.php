  <!-- Navbar -->
  <div class="container">
    <nav class="row navbar navbar-expand-lg  navbar-light bg-white" id="home">
    <a href="{{ route('home') }}" class="navbar-logo-pealip">
        <img src="{{ asset('frontend/images/trip.png') }}" alt="logo">
    </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb"
            aria-controls="navb" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navb">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mx-md-2">
                    <a class="nav-link active" href="#home">Home </a>
                </li>
                <li class="nav-item mx-md-2 ">
                    <a class="nav-link" href="#popular">Paket Travel</a>
                </li>
                <li class="nav-item mx-md-2">
                    <a class="nav-link" href="#testimonialHeading">Testimonial</a>
                </li>

            </ul>
            @if (Auth::user() && Auth::user()->is_admin == 1)
                @auth
                    <ul class="navbar-nav ml-auto mr-3">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link p-0 nav-avatar" id="navbarDropdown" role="button" data-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" style="width: 45px !important;" alt="user" class="rounded-circle mr-2" style="width: 50px; height: 50px;" />
                                Hi, {{ Auth::user()->name }} <i class="fas fa-caret-down ms-1"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item disabled mb-2" href="#">
                                        {{ Auth::user()->userid }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-fw fa-tachometer-alt me-1 text-black-50"></i>
                                        Dashboard</a></li>
                            </ul>
                        </li>
                    </ul>
                @endauth
            @else
                @auth
                    <ul class="navbar-nav ml-auto mr-3">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link p-0 nav-avatar" id="navbarDropdown" role="button" data-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" style="width: 45px !important;" alt="user" class="rounded-circle mr-2" style="width: 50px; height: 50px;" />
                                Hi, {{ Auth::user()->name }} <i class="fas fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item disabled mb-2" href="#">
                                        {{ Auth::user()->userid }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                        <i class="fas fa-fw fa-tachometer-alt me-1 text-black-50"></i>
                                        Dashboard</a></li>
                            </ul>
                        </li>
                    </ul>
                @endauth
            @endif
            
            @guest
                <!-- mobile Button Masuk -->
                <form action="#" class="form-inline d-sm-block d-lg-none">
                    @csrf
                    <div class="container col-10">
                    <button class="btn btn-block btn-login-mobile my-2 my-sm-0" type="button" onclick="event.preventDefault(); location.href='{{ url('login') }}';">
                            Masuk
                        </button>
                    </div>
                </form>
                <!-- desktop Button Masuk -->
                <form action="#" class="form-inline my-2 my-lg-0 d-none d-lg-block">
                    @csrf
                <button class="btn btn-login btn-navbar-right my-2 my-sm-0 px-4" type="button" onclick="event.preventDefault(); location.href='{{ url('login') }}';">
                        Masuk
                    </button>
                </form>
            @endguest

            @auth
                <!-- mobile Button Masuk -->
                <form action="{{ url('logout') }}" class="form-inline d-sm-block d-lg-none" method="POST">
                    @csrf
                    <div class="container col-10">
                    <button class="btn btn-block btn-login-mobile my-2 my-sm-0" type="submit">
                            Keluar
                        </button>
                    </div>
                </form>
                <!-- desktop Button Masuk -->
                <form action="{{ url('logout') }}" class="form-inline my-2 my-lg-0 d-none d-lg-block" method="POST">
                    @csrf
                <button class="btn btn-login btn-navbar-right my-2 my-sm-0 px-4" type="submit">
                        Keluar
                    </button>
                </form> 
            @endauth
        </div>
    </nav>
  </div>