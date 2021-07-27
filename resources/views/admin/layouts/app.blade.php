<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<meta name="generator" content="">
<title>@yield('title') - {{APLICATION_NAME}}</title>
<!-- Font -->
<link href="{{SYSTEM_SITE_URL}}assets/admin/css/fontawesome.css" rel="stylesheet" type="text/css">
<!-- Bootstrap core CSS -->
<link href="{{SYSTEM_SITE_URL}}assets/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="{{SYSTEM_SITE_URL}}assets/admin/css/style.css" rel="stylesheet" type="text/css">
<link href="{{SYSTEM_SITE_URL}}assets/admin/css/datepicker.min.css" rel="stylesheet" type="text/css">
<link href="{{SYSTEM_SITE_URL}}assets/admin/css/jquery.fileupload.css" rel="stylesheet" type="text/css">
<link href="{{SYSTEM_SITE_URL}}assets/admin/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css">
@yield('css')
</head>
<body>
    
    @yield('content')

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 
    <script type="text/javascript" src="{{SYSTEM_SITE_URL}}assets/admin/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{{SYSTEM_SITE_URL}}assets/admin/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.ui.widget@1.10.3/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="{{SYSTEM_SITE_URL}}assets/admin/js/jquery.fileupload.js"></script>
    <script type="text/javascript" src="{{SYSTEM_SITE_URL}}assets/admin/js/custom.js"></script>
    @yield('js')
</body>
</html>
