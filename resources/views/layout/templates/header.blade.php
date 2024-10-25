    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
  
      <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
          <img src="assets/img/logo.png" alt="">
          <span class="d-none d-lg-block">NiceAdmin</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
      </div><!-- End Logo -->

      <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
  
          <li class="nav-item dropdown pe-3">
  
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
              <img src="{{ asset ('assets/img/whatsapp-img.jpeg') }}" alt="Profile" class="rounded-circle">
              <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->nama; }}</span>
            </a><!-- End Profile Iamge Icon -->
  
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
              <li class="dropdown-header">
                <h6>{{ Auth::user()->nama; }}</h6>
                <span>{{ Auth::user()->pekerjaan; }}</span>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
  
              <li>
                <a class="dropdown-item d-flex align-items-center" href="/user/profile">
                  <i class="bi bi-person"></i>
                  <span>My Profile</span>
                </a>
              </li>
              
              <li>
                <form  method='POST' action="/logout">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-item-center"> <i class="bi bi-box-arrow-right">
                  </i>Logout</button>
                </form>
              </li>
  
            </ul><!-- End Profile Dropdown Items -->
          </li><!-- End Profile Nav -->
  
        </ul>
      </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->