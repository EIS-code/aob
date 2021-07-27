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
<link href="{{SYSTEM_SITE_URL}}assets/user/css/fontawesome.css" rel="stylesheet" type="text/css">
<!-- Bootstrap core CSS -->
<link href="{{SYSTEM_SITE_URL}}assets/user/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="{{SYSTEM_SITE_URL}}assets/user/css/style.css" rel="stylesheet" type="text/css">
<link href="{{SYSTEM_SITE_URL}}assets/user/css/jquery.fileupload.css" rel="stylesheet" type="text/css">
<link href="{{SYSTEM_SITE_URL}}assets/user/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css">
@yield('css')
</head>
<body>
    
    @yield('content')

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 
    <script type="text/javascript" src="{{SYSTEM_SITE_URL}}assets/user/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> 
    <script type="text/javascript" src="{{SYSTEM_SITE_URL}}assets/user/js/jquery.fileupload.js"></script> 
    <script type="text/javascript" src="{{SYSTEM_SITE_URL}}assets/user/js/custom.js"></script>
    @yield('js')
</body>
</html>
