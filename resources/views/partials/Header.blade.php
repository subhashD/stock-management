    <div class="main-panel">
      <!-- top header -->
      <div class="header navbar">
        <div class="brand visible-xs">
          <!-- toggle offscreen menu -->
          <div class="toggle-offscreen">
            <a href="javascript:;" class="hamburger-icon visible-xs" data-toggle="offscreen" data-move="ltr">
              <span></span>
              <span></span>
              <span></span>
            </a>
          </div>
          <!-- /toggle offscreen menu -->
          <!-- logo -->
          <a class="brand-logo">
            <span>Stock Management</span>
          </a>
          <!-- /logo -->
        </div>
        <ul class="nav navbar-nav hidden-xs">
          <li>
            <a href="javascript:;" class="small-sidebar-toggle ripple" data-toggle="layout-small-menu">
              <i class="icon-toggle-sidebar"></i>
            </a>
          </li>

        </ul>
        <ul class="nav navbar-nav navbar-right hidden-xs">

          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Admin <span class="caret"></span>
              </a>

              <ul class="dropdown-menu" role="menu">
                  <li>
                      <a href="">
                          Change Password
                      </a>
                  </li>

                  <li>
                      <a href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                          Logout
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                  </li>
              </ul>
          </li>
          <!-- <li>
            <a href="javascript:;" class="ripple" data-toggle="layout-chat-open">
              <i class="icon-user"></i>
            </a>
          </li> -->
        </ul>
      </div>

      <!--main content-->

      <div class="main-content">
        @if(Session::has('success'))
          <div class="alert alert-success" role="alert">
            <span class="glyphicon glyphicon-saved" aria-hidden="true"> <strong>Success:</strong> </span>
            {{ Session::get('success') }}
          </div>
          @endif

        @if(Session::has('error'))
          <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-alert" aria-hidden="true"> <strong>Error:</strong> </span>
            {{ Session::get('error') }}
          </div>
          @endif


          @if(!$errors->isEmpty())
          <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-alert" aria-hidden="true"><strong> Error:</strong></span>
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
