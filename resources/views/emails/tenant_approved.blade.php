<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Site is Ready!</title>
</head>
<body>
    <h2>Hello {{ $tenantName }}!</h2>

    <p>Congratulations — your tenant registration has been approved!</p>

    <p>You now have your own pharmacy system site. Click the link below to access your site:</p>

    <p>
        <a href="{{ $tenantLink }}">{{ $tenantLink }}</a>
    </p>

    <p>Log in with your admin credentials to get started.</p>

    <p>Thanks for joining us!</p>
</body>
</html>


