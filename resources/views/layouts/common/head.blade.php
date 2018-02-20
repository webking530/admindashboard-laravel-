<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
  <title>@yield('title') - LOLA</title>
  <!-- This page CSS -->
  <!-- chartist CSS -->
  <link href="css/system/morris.css" rel="stylesheet">
  <!--Toaster Popup message CSS -->
  <link href="css/system/jquery.toast.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="css/system/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="css/system/sweetalert.css" rel="stylesheet">
  <link href="css/system/style.min.css" rel="stylesheet">
  
  <link href="css/system/daterangepicker.css" rel="stylesheet">
  <link href="css/system/dropify.min.css" rel="stylesheet">
  <link href="css/my-style.css" rel="stylesheet">
  
  @yield('styles')
</head>