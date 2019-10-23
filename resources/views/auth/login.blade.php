<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login - Garments Accessories</title>
</head>
<body>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
        <h1>{{$info->name}}</h1>
    </div>
    <div class="login-box">
        <form class="login-form" action="{{ route('login') }}" method="post">
            @csrf
            <img src="{{asset('uploads/logo.png')}}" style="margin:0 auto;display:block;margin-bottom:10px;" alt="">
            <div class="form-group">
                <label class="control-label">EMAIL</label>
                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : ''}}" type="text" name="email" placeholder="Email" autofocus>
                @if ($errors->has('email'))
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $errors->first('email') }}</strong>
                     </span>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label">PASSWORD</label>
                <input class="form-control" type="password" name="password" placeholder="Password">
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                         <strong>{{ $errors->first('password') }}</strong>
                     </span>
                @endif
            </div>
            <div class="form-group">
                <div class="utility">
                    <div class="animated-checkbox">
                        <label>
                            <input type="checkbox"><span class="label-text">Stay Signed in</span>
                        </label>
                    </div>
                    <p class="semibold-text mb-2"><a href="{{route('password.request')}}" data-toggle="flip">Forgot Password ?</a></p>
                </div>
            </div>
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
            </div>
        </form>
    </div>
</section>

<script src="{{'js/app.js'}}"></script>
</body>
</html>