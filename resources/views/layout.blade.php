<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('head_data')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ config('app.name') }}</title>
</head>
<body data-bs-theme="dark">
    <header>
        <nav class="primaryMenu">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/auctioneer">Auctioneer</a></li>
                <li><a href="{{ route('auctions') }}">Auctions</a></li>
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
