<body class="skin-default-dark fixed-layout">
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <div class="preloader">
      <div class="loader">
          <div class="loader__figure"></div>
          <p class="loader__label">Loading...</p>
      </div>
  </div>
  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper">
    @include('layouts.common.nav-top')
    @include('layouts.common.nav-aside')
    <div class="page-wrapper">
      <div class="container-fluid">
        <div class="row page-titles">
          <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">@yield('page-title')</h4>
          </div>
          <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">@yield('page-title')</li>
              </ol>
            </div>
          </div>
        </div>
        @yield('content')
      </div>
    </div>
    @include('layouts.common.footer')
  </div>
  <script src="js/system/jquery-3.2.1.min.js"></script>
  <!-- Bootstrap popper Core JavaScript -->
  <script src="js/system/popper.min.js"></script>
  <script src="js/system/bootstrap.min.js"></script>
  <!-- slimscrollbar scrollbar JavaScript -->
  <script src="js/system/perfect-scrollbar.jquery.min.js"></script>
  <!--Wave Effects -->
  <script src="js/system/waves.js"></script>
  <!--Menu sidebar -->
  <script src="js/system/sidebarmenu.js"></script>
  <!--Custom JavaScript -->
  <script src="js/system/custom.min.js"></script>
  <!-- ============================================================== -->
  <!-- This page plugins -->
  <script src="js/system/datatables.min.js"></script>
  <script src="js/system/sweetalert.min.js"></script>
  <script src="js/system/moment.js"></script>
  <script src="js/system/daterangepicker.js"></script>
  <script src="js/system/dropify.min.js"></script>
  <!-- ============================================================== -->
  <!--morris JavaScript -->
  <script src="js/system/raphael-min.js"></script>
  <script src="js/system/morris.min.js"></script>
  <script src="js/system/jquery.sparkline.min.js"></script>

  <script src="{{ asset('js/password.js') }}"></script>

  @yield('scripts')
</body>