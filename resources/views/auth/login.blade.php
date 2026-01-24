<!doctype html>
<html lang="en">
<head>
<title>Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
</head>
<body class="img js-fullheight" style="background-image: url({{ asset('img/badminton.jpg') }});">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section text-white">Login</h2>
				</div>
			</div>
			<div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Have an account?</h3>
                        @if ($errors->any())
                            <p class="text-danger text-center">{{ $errors->first() }}</p>
                        @endif
                        <form action="{{ route('login') }}" class="signin-form" method="POST">
                            @csrf

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email" name="email" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" class="form-control" placeholder="Password" name="password" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
                            </div>
                        </form>
                    </div>
				</div>
			</div>
		</div>
	</section>

    <script src="{{ asset('js/login-jquery.js') }}"></script>
    <script src="{{ asset('js/login-script.js') }}"></script>
</body>
</html>

