<x-base-layout>
    <div class="home_body">

        <!-- HERO / INTRO SECTION -->
        <div class="text1">
            <div>
                <h1>Voetbal</h1>
                <h3>
                    Welkom op de informatiepagina over voetbal!  
                    Voetbal is één van de populairste sporten ter wereld. Het spel draait om techniek, teamwork, snelheid en doorzettingsvermogen.  
                    Op deze pagina lees je alles over de geschiedenis, spelregels, posities, benodigdheden en hoe je zelf kunt beginnen met voetbal.
                </h3>
            </div>
            <img class="voetbalimg" src="{{ asset('img/voetbal1.png') }}" alt="Voetbal">
        </div>

        <div class="text2">
            <div class="text2-voetbal">
                <img src="{{ asset('img/voetbal2.png') }}" alt="Voetbal afbeelding">
                <div>
                    <h1>Over voetbal</h1>
                    <h3>
                        Voetbal wordt gespeeld met twee teams van 11 spelers op een rechthoekig veld met doelen aan beide kanten.  
                        Het doel van het spel is om meer doelpunten te maken dan de tegenstander.  
                        De sport kent wereldwijd miljoenen spelers en verenigingen en wordt gespeeld op zowel amateur- als professioneel niveau.
                    </h3>
                </div>
            </div>
        </div>

        <!-- INFORMATIE BLOKKEN -->
        <div class="text3">
            <h1>Leer alles over voetbal</h1>

            <div class="text3_1">

                <!-- SPELREGELS -->
                <div class="text3_2">
                    <h2>Spelregels</h2>
                    <p>
                        Een voetbalwedstrijd bestaat uit twee helften van 45 minuten.  
                        Spelers mogen de bal met alle lichaamsdelen raken behalve hun armen en handen (behalve de keeper).  
                        Overtredingen kunnen leiden tot vrije trappen, penalty’s of kaarten.  
                        De scheidsrechter bewaakt de regels en zorgt voor een eerlijk verloop van de wedstrijd.
                    </p>
                </div>

                <!-- POSITIES -->
                <div class="text3_2">
                    <h2>Spelers en posities</h2>
                    <p>
                        Een team bestaat uit verdedigers, middenvelders, aanvallers en een keeper.  
                        Elke positie heeft zijn eigen taak: verdedigers stoppen aanvallen, middenvelders verdelen het spel,  
                        aanvallers proberen doelpunten te maken en de keeper beschermt het doel.  
                        Teams bepalen hun tactiek op basis van hun speelstijl.
                    </p>
                </div>

                <!-- MATERIALEN -->
                <div class="text3_2">
                    <h2>Benodigdheden</h2>
                    <p>
                        Om te voetballen heb je een bal, voetbalschoenen, scheenbeschermers en sportkleding nodig.  
                        Bij officiële wedstrijden zijn doelen, een afgebakend veld en hoekvlaggen verplicht.  
                        Goede materialen zorgen voor veiligheid en verbeteren de sportervaring.
                    </p>
                </div>

            </div>
        </div>
    </div>
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
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('voetbal') }}">Voetbal</a>
                    <a href="{{ route('lijnbal') }}">Lijnbal</a>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; 2025 PaasToernooi. Alle rechten voorbehouden.
            </div>
        </footer>
</x-base-layout>
