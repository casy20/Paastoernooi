<x-base-layout>
    <div class="home_body">
        <div class="text1">
            <div>
                <h1>Stichting Paastoernooien</h1>
                <h3>
                    Doe mee aan de jaarlijkse Paastoernooien in Bergen op Zoom en omgeving!  
                    We organiseren sportieve en gezellige voetbal- en lijnbaltoernooien voor leerlingen van groep 3 t/m 8 en de eerste klas van de middelbare school.  
                    Vorm samen met je klasgenoten een team en beleef een dag vol sport, plezier en fair play!
                </h3>
                <a href="{{ route('team_create') }}">Inschrijven</a>
                <a href="{{ route('create_school') }}">school toevoegen</a>
                <a href="{{ route('match.generator') }}">Genereer wedstrijden</a>
                <a href="{{ route('matches.list') }}">Wedstrijden</a>
                
            </div>
            <img src="{{ asset('img/logo.png') }}" alt="Stichting Paastoernooien Bergen op Zoom">
        </div>

        <div class="text2">
            <img src="{{ asset('img/pngegg.png') }}" alt="Paastoernooien Bergen op Zoom">
            <div>
                <h1>Over de toernooien</h1>
                <h3>
                    Elk jaar organiseren wij zeven toernooien: voetbal voor groep 3/4, 5/6 en 7/8 (gemengd), voetbal voor de eerste klas jongens/gemengd en meiden, en lijnbal voor groep 7/8 en de eerste klas meiden.  
                    De toernooien vinden rond Pasen plaats op verschillende sportlocaties in Bergen op Zoom en omgeving, en staan garant voor sportiviteit, plezier en een gezellige sfeer voor alle deelnemers.
                </h3>
                <a href="{{ route('voetbal') }}">voetbal</a>
                <a href="{{ route('lijnbal') }}">lijnbal</a>
            </div>
        </div>

        <div class="text3">
            <h1>Scholen kunnen zich vanaf januari inschrijven!</h1>
            <div class="text3_1">
                <div class="text3_2">
                    <h2>Inschrijven</h2>
                    <p>
                        Vanaf begin januari kunnen scholen hun teams eenvoudig via deze website inschrijven.  
                        Bij het inschrijfformulier vragen we om de naam van de school, de contactgegevens van de coach, het aantal teams dat wordt aangemeld per toernooi en de gegevens van de scheidsrechter die de school aanlevert.  
                        Na het verzenden ontvangt de school automatisch een bevestiging met een kopie van het ingevulde formulier.
                    </p>
                </div>

                <div class="text3_2">
                    <h2>Speelschema’s</h2>
                    <p>
                        Na de sluitingsdatum worden de speelschema’s opgesteld. Hierbij houden we rekening met situaties waarin teams van dezelfde school niet tegen elkaar mogen spelen.  
                        De schema’s worden overzichtelijk en goed leesbaar op de website geplaatst, en kunnen eenvoudig worden aangepast wanneer er wijzigingen optreden.
                    </p>
                </div>

                <div class="text3_2">
                    <h2>Live scores</h2>
                    <p>
                        Tijdens de toernooien worden de uitslagen direct ingevoerd in een afgesloten omgeving.  
                        De live standen worden automatisch bijgewerkt op de website, zodat teams en supporters de resultaten en ranglijsten gedurende de dag kunnen volgen.  
                        Zo blijft iedereen op de hoogte van de spannende strijd om de overwinning!
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
