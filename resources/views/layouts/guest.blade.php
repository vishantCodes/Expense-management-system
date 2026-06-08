<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/guest.css', 'resources/js/app.js'])
    <title>@yield('title', 'Expense Manager')</title>
</head>

<body class="bg-light">
    <div class="auth-layout">
        @yield('guest-content')
    </div>
</body>

</html>