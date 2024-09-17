<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Google Auth Callback</title>
</head>

<body>
    <script>
        const allowedOrigins = [
            "http://localhost:3000",
            "https://prj-r2auction.vercel.app/"
        ];

        allowedOrigins.forEach(origin => {
            if (window.opener) {
                window.opener.postMessage(userData, origin);
            }
        });

        setTimeout(() => {
            window.close();
        }, 1000);
    </script>
</body>

</html>
