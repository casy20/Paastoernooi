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
                <a href="{{ route('informatie') }}">Over</a>
                <a href="{{ route('contact') }}">Contact</a>
                <a href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </header>
    <main>
        {{ $slot }}
    </main>

    <footer>
       
        <p>telefoon nummer : 06-12345678</p>
        <p>emailadres : passtoernooi@gmail.com </p>
        <p>locatie : albertlaan 67</p>
         <p>&copy; 2026 PaasToernooi. All rights reserved.</p>
    </footer>
</body>

</html>