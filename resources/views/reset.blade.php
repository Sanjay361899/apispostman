<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body style="margin: 100px;">
<h1>you have requested to reset a password</h1>
    <hr>
    <p>
        we cannot simply send you your old password. a unique link to reset your password. <br>
        click the following link to reset your password.
    </p>
    <h1>
        <a href="http://127.0.0.1:3000/api/user/reset/{{$token}}">click here to reset your password</a>
    </h1>
</body>
</html>