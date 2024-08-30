<!DOCTYPE html>
<html>
<head>
    <title>Welcome to {{ env('APP_NAME') }}!</title>
</head>
<body>
    @include('emails.partials.includes.header')
    
    @yield('content')

    @include('emails.partials.includes.footer')
</body>
</html>
