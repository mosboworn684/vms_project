<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <title>Login Form | CodingLab</title> -->
	<link rel="stylesheet" href="css/login.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
</head>

<body>
	<div class="container">
		<div class="wrapper">
			<div class="title"><span>Vehicle Management System</span></div>
			<form method="post" action="{{ route('login.perform') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				@include('auth.partials.messages')
				<div class="row">
					<i class="fas fa-user"></i>
					<input type="text" name="username" value="{{ old('username') }}" placeholder="Username or E-mail" required="required" autofocus>
				</div>
				<div class="row">
					<i class="fas fa-lock"></i>
					<input type="password" name="password" placeholder="Password" value="{{ old('password') }}" required>
				</div>
				<div class="pass">
					<a data-toggle="modal" href="/forgetpassword">Forgot Password?</a>
				</div>
				<div class="row button">
					<input type="submit" value="Login">
				</div>
				@if ($message = Session::get('cannot'))
				<script>
					Swal.fire({
						icon: 'error',
						title: '{{$message}}',
					})
				</script>
					@elseif ($message = Session::get('reset'))
						<script>
							Swal.fire({
								icon: 'success',
								title: '{{$message}}',
							})
						</script>
				@endif
			</form>
		</div>
	</div>
	<!-- Modal -->
</body>
</html>
