<x-base-layout>
    <div class="home_body">

        <!-- HERO / INTRO SECTION -->
        <div class="text1">
            <div>
                <h1>Lijnbal</h1>
                <h3>
                    Welkom op de informatiepagina over lijnbal!  
                    Lijnbal is een snelle, dynamische en toegankelijke teamsport die voornamelijk op basisscholen en tijdens toernooien wordt gespeeld.  
                    Het spel vraagt om teamwork, beweeglijkheid en tactisch inzicht. Op deze pagina lees je alles over de spelregels, speelwijze en wat je nodig hebt om mee te doen.
                </h3>
            </div>
            <img class="lijnbalimg" src="{{ asset('img/lijnbal1.png') }}" alt="Lijnbal">
        </div>

        <div class="text2">
            <div class="text2-voetbal">
                <img src="{{ asset('img/lijnbal2.png') }}" alt="Lijnbal afbeelding">
                <div>
                    <h1>Over lijnbal</h1>
                    <h3>
                        Lijnbal wordt gespeeld op een rechthoekig veld met aan beide uiteinden een lijn die verdedigd of aangevallen wordt.  
                        Twee teams proberen door de bal over te gooien en zich vrij te lopen een punt te scoren door de bal op of over de achterlijn van de tegenstander te krijgen.  
                        De sport is eenvoudig te leren, snel in tempo en ideaal voor grotere groepen leerlingen.
                    </h3>
                </div>
            </div>
        </div>

        <!-- INFORMATIE BLOKKEN -->
        <div class="text3">
            <h1>Leer alles over lijnbal</h1>

            <div class="text3_1">

                <!-- SPELREGELS -->
                <div class="text3_2">
                    <h2>Spelregels</h2>
                    <p>
                        Lijnbal wordt gespeeld met twee teams die elkaar de bal overspelen zonder dat deze valt.  
                        Een punt wordt gescoord wanneer een speler de bal controleert op of over de achterlijn van de tegenstander.  
                        Spelers mogen niet lopen met de bal, waardoor samenwerken en goed vrijlopen essentieel zijn.  
                        Als de bal op de grond valt, gaat het balbezit naar de tegenpartij.
                    </p>
                </div>

                <!-- POSITIES / TACTIEK -->
                <div class="text3_2">
                    <h2>Spelers en speelwijze</h2>
                    <p>
                        Teams bestaan vaak uit 6 tot 10 spelers.  
                        Omdat spelers niet mogen dribbelen, draait het spel om slimme posities innemen, snel passen en op tijd vrijlopen.  
                        Aanvallers proberen ruimte te maken richting de achterlijn, terwijl verdedigers proberen passen te onderscheppen en ruimtes klein te houden.
                    </p>
                </div>

                <!-- MATERIALEN -->
                <div class="text3_2">
                    <h2>Benodigdheden</h2>
                    <p>
                        Voor lijnbal is een zachte, handzame bal nodig, vaak een foam- of softbal zodat iedereen veilig kan meedoen.  
                        Verder volstaan een vlak speelveld en twee duidelijke achterlijnen.  
                        Sportkleding en gymschoenen zijn aanbevolen om veilig te kunnen rennen en bewegen.
                    </p>
                </div>

            </div>
        </div>

        <!-- WEDSTRIJDEN TABEL -->
        @if($matches->count() > 0)
        <div class="team_text match-generator match-container">
            <h2 class="matches-heading">Lijnbal Wedstrijden ({{ $matches->count() }})</h2>
            <hr class="matches-divider">
            <div class="matches-table-wrapper">
                <table class="matches-table">
                    <thead>
                        <tr>
                            <th>Team 1</th>
                            <th>Score 1</th>
                            <th>Team 2</th>
                            <th>Score 2</th>
                            <th class="col-pool">Pool</th>
                            <th>Veld</th>
                            <th>Starttijd</th>
                            <th>Eindtijd</th>
                            <th>Pauze</th>
                            <th>Type</th>
                            <th>Scheidsrechter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matches as $match)
                            <tr>
                                <td>{{ $match->team1->name ?? 'Onbekend' }}</td>
                                <td><strong>{{ $match->team_1_score ?? '-' }}</strong></td>
                                <td>{{ $match->team2->name ?? 'Onbekend' }}</td>
                                <td><strong>{{ $match->team_2_score ?? '-' }}</strong></td>
                                <td class="col-pool">{{ $match->team1->pool->name ?? 'Onbekend' }}</td>
                                <td>{{ $match->field ?? '-' }}</td>
                                <td>{{ $match->start_time }}</td>
                                <td>{{ $match->end_time ?? '-' }}</td>
                                <td>{{ $match->pause_minutes ?? '-' }} min</td>
                                <td>{{ $match->type ?? '-' }}</td>
                                <td>{{ $match->referee }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
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