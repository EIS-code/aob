<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login - {{APLICATION_NAME}}</title>
    <link href="{{SYSTEM_SITE_URL}}assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{SYSTEM_SITE_URL}}assets/css/metisMenu.min.css" rel="stylesheet">
    <link href="{{SYSTEM_SITE_URL}}assets/css/startmin.css" rel="stylesheet">
    <link href="{{SYSTEM_SITE_URL}}assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    @if($errors->any())
                        <div class="text-center alert alert-danger">
                            <ul style="list-style-type: none;">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session()->has('succ_msg'))
                        <div class="text-center alert alert-success">{{session()->get('succ_msg')}}</div>
                    @endif
                    @if(session()->has('fail_msg'))
                        <div class="text-center alert alert-danger">{{session()->get('fail_msg')}}</div>
                    @endif
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="{{SYSTEM_SITE_URL}}checkLogin" >
                            <fieldset>
                                @csrf
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!-- <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div> -->
                                <a href="{{SYSTEM_SITE_URL}}forgot-password">Forgot password</a>
                                <input class="btn btn-lg btn-success btn-block" name="submit" type="submit" value="Login">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{SYSTEM_SITE_URL}}assets/js/jquery.min.js"></script>
    <script src="{{SYSTEM_SITE_URL}}assets/js/bootstrap.min.js"></script>
    <script src="{{SYSTEM_SITE_URL}}assets/js/metisMenu.min.js"></script>
    <script src="{{SYSTEM_SITE_URL}}assets/js/startmin.js"></script>

</body>
</html>
