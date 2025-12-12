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
    <title>Register</title>
</head>

<body>
<!-- wrapper -->
<div class="wrapper">
    <div class="authentication-reset-password d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <div class="card">
                          <form method="POST" action="{{ route('register') }}">
            @csrf
                    <div class="row g-0">
                        <div class="col-lg-7 d-flex align-self-center">
                            <img src="{{asset('assets/images/login-images/forgot-password-frent-img.jpg')}}" class="card-img login-img" alt="...">
                            </div>
                        <div class="col-lg-5 border-end" style="background: rgb(249, 251, 254);">
                            <div class="card-body">

                                <div class="pt-3 px-5">
                                    <div class="text-start">
                                        <img src="{{asset('assets/images/logo-img.png')}}" width="180" alt="">
                                    </div>
                                      <x-jet-validation-errors class="mb-4" />
                                    <h4 class="mt-3 font-weight-bold">Register to Dashboard</h4>
                                    <div><label class="form-label w-100">User Type:</label>
                                        <div class="form-check d-inline-block me-3">
                                            <input class="form-check-input" type="radio" checked="" name="flexRadioDefault" id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">User</label>
                                        </div>
                                        <div class="form-check d-inline-block me-3">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                            <label class="form-check-label" for="flexRadioDefault2">Admin</label>
                                        </div>
                                        <div class="form-check d-inline-block me-3">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                                            <label class="form-check-label" for="flexRadioDefault3">Corporate</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <input type="text" name="" class="form-control" placeholder="Generate Login ID" />
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <input type="text" name="name" class="form-control" placeholder="Enter Fullname" />
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <input type="text" name="email" class="form-control" placeholder="Enter Email" />
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <input type="text" name="" class="form-control" placeholder="Enter Mobile Number" />
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group" id="show_hide_password">
                                            <input type="text" class="form-control border-end-0" id="inputChoosePassword"  placeholder="Enter Password" name="password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group" id="show_hide_password">
                                            <input type="text" class="form-control border-end-0" id="inputChoosePassword" placeholder="Enter Confirm Password" name="password_confirmation"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                        </div>
                                    </div>
                            <!--         <div class="d-grid gap-2">
                                        <div class="d-grid form-control p-0 position-relative" style="padding-left:100px !important;">
                                            <img src="assets/images/captcha.jpg" height="34" alt="" style="position: absolute; left: 2px;
                                            z-index: 99; top: 1px;" />
                                            <input type="text" class="form-control d-inline-block" style="border:none;" placeholder="Enter Code" />
                                        </div>
                                    </div> -->
                                    <div class="d-grid gap-2 mt-3">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Register</button>
                                        </div>
                                    </div>
                                    <p class="mt-4 text-center">Don't have an account yet? <a href="{{route('login')}}">Sign In here</a> </p>
                                </div>
                            </div>
                        </div>

                        </form>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end wrapper -->
</body>
</html>
