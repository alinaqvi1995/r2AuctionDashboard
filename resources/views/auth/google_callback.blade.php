<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Google Auth Callback</title>
</head>

<body>
    <script>
        // User data passed from the backend
        const userData = @json($userData);

        // Send the user data to the original window
        window.opener.postMessage(userData, window.location.origin);

        // Close this window after sending the message
        setTimeout(() => {
            window.close();
        }, 1000);
    </script>
</body>

</html>
