
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Bahawal Waraich">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Blog - 880114</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <style> 
    body {
    padding-top: 54px;
    }
    @media (min-width: 992px) {
    body {
        padding-top: 56px;
    }
    }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="/">Laravel Blog</a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
             @if (Route::has('login'))
                    @auth
                    <li class="nav-item">
                         <a class="nav-link" href="{{ url('/home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" href="{{ route('posts') }}">News</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                        Log out
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                     </li>
                     @else
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('posts') }}">News</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('register') }}">Register</a>
                         </li>
                     @endauth
             @endif
          </ul>
        </div>
      </div>
    </nav>

  <div id="app">
     @yield('content')
  </div>

  <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Laravel Blog - Bahawal Waraich (880114)</p>
      </div>
    </footer>
        <script src="{{ asset('js/app.js') }}"></script>

  </body>
</html>
