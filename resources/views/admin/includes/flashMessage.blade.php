
<!-- Sign in message -->

@if (\Session::has('login_error'))

<div class="alert alert-danger">
<ul>
   <li>{!! \Session::get('login_error') !!}</li>
</ul>
</div>
 @endif

@if(session()->has('login_message'))
<div class="alert alert-success  alert-block">

{{ Session::get('login_message') }}
</div>
@endif


@if(session()->has('login_both_invalid'))


<div class="alert alert-danger  alert-block">

{{ Session::get('login_both_invalid') }}
</div>
@endif


<!-- Sign up Error -->


 @if (\Session::has('register_error'))

<div class="alert alert-danger">
<ul>
   <li>{!! \Session::get('register_error') !!}</li>
</ul>
</div>
 @endif


<!-- Forgot password  -->
@if (\Session::has('forgot_error'))

<div class="alert alert-danger">
<ul>
   <li>{!! \Session::get('forgot_error') !!}</li>
</ul>
</div>
 @endif

@if(session()->has('forgot_message'))
<div class="alert alert-success  alert-block">

{{ Session::get('forgot_message') }}
</div>
@endif


@if(session()->has('success'))
<div class="alert alert-success  alert-block">

{{ Session::get('success') }}
</div>
@endif



@if(session()->has('error'))


<div class="alert alert-danger  alert-block">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
   <span aria-hidden="true">&times;</span>
</button>
{{ Session::get('error') }}
</div>
@endif




