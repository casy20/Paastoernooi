<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PaasToernooi</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <header>
        <div class="navbar">
            <div class="logo">
                <h2>PaasToernooi</h2>
            </div>
            <div class="links">
                <a href="{{ route('home') }}">Home</a>
                <a href="#">Contact</a>
                <a href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </header>
    <main>
        {{ $slot }}
    </main>

    <footer>

    </footer>
</body>

</html>