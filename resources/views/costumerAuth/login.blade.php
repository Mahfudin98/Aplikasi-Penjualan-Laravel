@extends('layouts.layout')

@section('title')
    Login
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset("assets/vendors/linericon/style.css")}}">
    <link rel="stylesheet" href="{{asset("assets/vendors/nouislider/nouislider.min.css")}}">
@endsection

@section('section-login')
    <section class="blog-banner-area" id="category">
        <div class="container h-100">
            <div class="blog-banner">
                <div class="text-center">
                    <h1>Login / Register</h1>
                    <nav aria-label="breadcrumb" class="banner-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Login/Register</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="login_box_area section-margin">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="login_box_img">
						<div class="hover">
							<h4>New to our website?</h4>
							<p>There are advances being made in science and technology everyday, and a good example of this is the</p>
							<a class="button button-account" href="{{ route('costumer.register')}}">Create an Account</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>Log in to enter</h3>
                        <form class="row login_form" method="POST" action="{{ route('costumer.login.post') }}" id="contactForm" >
                            @csrf
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="name" name="email" placeholder = "email@example.com" value="{{ old('email') }}" required autofocus>
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="name" name="password" placeholder="Password" required>
							</div>
							<div class="col-md-12 form-group">
								<div class="creat_account">
                                    <input type="checkbox" id="f-option2" name="remember" {{ old('remember') ? 'checked' : '' }}>
									<label for="f-option2">Remember Me</label>
								</div>
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="button button-login w-100">Log In</button>
								<a href="#">Forgot Password?</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

