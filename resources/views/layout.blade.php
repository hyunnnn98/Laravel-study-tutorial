<!DOCTYPE html>
<html lang="kr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="b{{ csrf_token() }}">
    <title>@yield('title', 'Laravel')</title>
</head>

<body>
    <ul>
        <li><a href="/">Welcome</a></li>
        <li><a href="/contact">contact</a></li>
        <li><a href="/hello">Hello</a></li>
    </ul>
    @yield('content')
</body>

</html>
