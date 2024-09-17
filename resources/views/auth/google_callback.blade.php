<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Google Auth Callback</title>
</head>

<body>
    <script>
        console.log('Window Opener:', window.opener);
        console.log('userData:', $userData);
        if (!window.opener) {
            console.error('window.opener is null.');
        } else {
            const userData = @json($userData);
            window.opener.postMessage(userData, window.location.origin);
            // setTimeout(() => {
            //     window.close();
            // }, 1000);
        }
    </script>
</body>

</html>
