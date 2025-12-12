<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{asset('assets/images/favicon-32x32.png')}}" type="image/png" />
    <!-- loader-->
    <link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
    <script src="{{asset('assets/js/pace.min.js')}}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
    <title>Login</title>
</head>

<style type="text/css">
    .font-medium.text-red-600 {
    color: red;
}

ul.mt-3.list-disc.list-inside.text-sm.text-red-600 {
    color: red;
}
</style>

<body>
<!-- wrapper -->
<div class="wrapper">
    <div class="authentication-reset-password d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <div class="card">
                    <div class="row g-0">
                        <div class="col-lg-7 d-flex align-self-center">
                            <img src="{{asset('assets/images/login-images/forgot-password-frent-img.jpg')}}" class="card-img login-img" alt="...">
                            </div>
                        <div class="col-lg-5 border-end" style="background: rgb(249, 251, 254);">


                           
        <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                            <div class="card-body">
                                <div class="p-5">

                                 <div class="text-start">
                                        <h4 style="color:#008cff">efsms Admin</h4>
                                    </div>                                  </div>
                                        <x-jet-validation-errors class="mb-4" />
                                  <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>
       
           
            <div class="block">



                <label class="form-label">{{ __('Email') }}</label>



                <x-jet-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <div class="d-grid">
             <button type="submit" class="btn btn-primary" ><i class="bx bxs-lock-open"></i>Sign in</button>
                                        </div>
                                    </div>
                                   <!--  <p class="mt-4 text-center">Don't have an account yet? <a href="{{route('register')}}">Sign up here</a> </p> -->
                                </div>
                            </div>
                        </form>
                        </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end wrapper -->
</body>
</html>
