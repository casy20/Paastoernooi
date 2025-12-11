<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PaasToernooi</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/navbar.js') }}"></script>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
                
                <a href="{{ route('register') }}">Register</a>
            </div>
        </div>
    </header>
    <main>
        {{ $slot }}
    </main>
    {% if showFooter %}
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h3>PaasToernooi</h3>
                <p>Samen plezier en sportiviteit beleven!</p>
            </div>
            <div class="footer-column">
                <h3>Contact</h3>
                <p>Email: info@paastoernooi.nl</p>
                <p>Telefoon: 06-12345678</p>
                <p>Adres: Sportlaan 12, Bergen op Zoom</p>
            </div>
            <div class="footer-column">
                <h3>Links</h3>
                <a href="#">Home</a>
                <a href="#">Voetbal</a>
                <a href="#">Lijnbal</a>
                <a href="#">Contact</a>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2025 PaasToernooi. Alle rechten voorbehouden.
        </div>
    </footer>
</body>

</html>