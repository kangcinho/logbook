<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="sidebar-toggle text-light mr-3"><i class="fa fa-bars"></i></a>

    <a class="navbar-brand" href="#"><i class="fa fa-code-menu"></i> Log Book Puri Bunda</a>

    @if(Auth::check())
      <div class="navbar-collapse collapse">
          <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                      <i class="fa fa-user"></i> {{ Auth::user()->name.' | '.Auth::user()->username}}
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item fas fa-user-secret" href="{{ url('changePassword') }}"> Change Password</a>
                      <a class="dropdown-item fas fa-sign-out-alt" href="{{ url('logout') }}"> Log Out</a>
                  </div>
              </li>
          </ul>
      </div>
    @endif
</nav>
