<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <p>Hi,</p>
    <p>Klik link berikut untuk reset password Anda:</p>
    <a href="{{ url('/api/reset-password?token=' . $token) }}">Reset Password</a>
</body>
</html>
