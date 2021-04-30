<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  <script type="text/javascript">
    var url = "{{ asset("") }}";
    var postToken = '{{csrf_token()}}';
    var AdminUrl = url + "admin/";
</script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        <div id="headerMsg" class="error_msg">
            @if(session()->has("error") || session()->has("success"))
                <div class="alert {{session()->has('error') ? 'alert-danger' : 'alert-success' }}">
                    <h4><i class="icon fa{{ session()->has('error') ? ' fa-false' : ' fa-check'}} "></i>{{session()->has('error') ? 'Warning' : 'Success'}}</h4>
                   
                    {{session()->has('error') ? session()->get('error') : session()->get('success') }}
                </div>
            @endif
        </div><br>
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="{{route('hasLogin')}}" method="post" id="login-form">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="User Name" id="user_name" name="user_name" value="{{ old('user_name') }}">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            @if ($errors->has('user_name'))
                <label><span class="error text-danger ">{{ $errors->first('user_name') }}</span></label>
            @endif

            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            @if ($errors->has('password'))
                <label><span class="error text-danger ">{{ $errors->first('password') }}</span></label>
            @endif
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                    {{-- <input type="checkbox" id="remember"> --}}
                    <label for="remember">
                        {{-- Remember Me --}}
                    </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
      </form>
{{-- 
      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> --}}

      {{-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> --}}
    </div>
  
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

{{--  jequery validation  --}}
<script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<script src="{{ asset('resources/js/admin/login/login.js') }}" type="text/javascript"></script>

</body>
</html>
