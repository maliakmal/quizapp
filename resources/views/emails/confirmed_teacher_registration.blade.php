<!DOCTYPE html>
<html>
<head>
	<title>Quiz App</title>
</head>
<body>
	<p>Dear {{ $user->first_name.' '.$user->last_name }},</p>
    <p>Thank you for the registration. Your registration is approved, please reset your password to continue with your account</p>
	<p>Your Login email address is:  {{ $user->email }} </p>
	
	<p>You can change your password by <a href="{{ URL::to('password/reset/'.$token) }}">clicking here</a></p>
</body>
</html>