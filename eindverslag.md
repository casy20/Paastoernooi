# Persoonlijk Reflectieverslag - Paastoernooi Praktijkopdracht

## Inleiding

Tijdens deze praktijkopdracht heb ik een webapplicatie ontwikkeld voor het beheren van Paastoernooien in Bergen op Zoom. De applicatie is gebouwd met Laravel en biedt functionaliteiten voor het registreren van scholen en teams, het automatisch genereren van wedstrijdschema's en het bijhouden van scores. In dit reflectieverslag beschrijf ik de belangrijkste leermomenten die ik meeneem naar mijn aankomende stage.

---

## Leermoment 1: Complexe Algoritmes Stapsgewijs Opbouwen

### Situatie
Tijdens de ontwikkeling van de wedstrijdgenerator stuitte ik op een complexe uitdaging: het automatisch genereren van round-robin toernooien waarbij elk team precies één keer tegen elk ander team moet spelen. Daarnaast moesten de wedstrijden worden ingepland met correcte start- en eindtijden, rekening houdend met verschillende speeltijden per pool (voetbal 15 minuten, lijnbal 10-12 minuten) en pauzetijden tussen wedstrijden.

### Acties
In eerste instantie probeerde ik het hele algoritme in één keer te schrijven, wat resulteerde in verwarrende en moeilijk te debuggen code. Na enkele mislukte pogingen besloot ik de aanpak te veranderen. Ik heb het probleem opgedeeld in kleinere, behapbare stappen:

1. Eerst de logica voor het genereren van alle teamcombinaties (elke team tegen elke andere team)
2. Vervolgens de tijdberekening per pool type
3. Daarna de veldtoewijzing en planning
4. Tot slot de integratie met de database

Door deze stapsgewijze aanpak kon ik elke component eerst testen voordat ik deze integreerde in het grotere geheel. Ik gebruikte ook veel commentaar in de code om de logica te documenteren.

### Reflectie
Dit leermoment heeft me geleerd dat complexe problemen altijd opgedeeld moeten worden in kleinere, behapbare delen. Door stapsgewijs te werken en elke stap te testen, voorkom ik dat ik overweldigd raak door de complexiteit. Tijdens mijn stage zal ik deze aanpak toepassen bij het ontwikkelen van complexe features. Ik zal altijd beginnen met het analyseren van het probleem, het opdelen in subproblemen, en dan pas beginnen met coderen. Dit bespaart tijd en voorkomt frustratie.

**Wat ik volgende keer anders doe:**
- Altijd eerst een plan maken voordat ik begin met coderen
- Complexe algoritmes opdelen in kleinere functies die ik individueel kan testen
- Vaker gebruik maken van pseudocode of flowcharts om de logica te visualiseren voordat ik begin met implementeren

**Wat ik wil behouden:**
- Het gebruik van uitgebreide commentaren in complexe code
- Het stapsgewijs testen van elke component voordat ik deze integreer

---

## Leermoment 2: Autorisation en Security van Begin Af Aan Meenemen

### Situatie
Aan het begin van het project had ik de focus vooral op het werkend krijgen van de functionaliteit. Ik had authenticatie geïmplementeerd, maar de autorisatie (wie mag wat doen) was niet volledig uitgewerkt. Pas later realiseerde ik me dat bepaalde routes en acties niet goed beveiligd waren. Bijvoorbeeld: de wedstrijdgenerator was alleen via de frontend afgeschermd, maar de routes zelf hadden geen middleware checks.

### Acties
Ik heb toen een grondige security audit uitgevoerd van de hele applicatie. Ik heb Laravel Policies geïmplementeerd voor de verschillende resources (matches, teams, schools, pools) en middleware checks toegevoegd aan alle admin routes. Daarnaast heb ik in de controllers expliciete checks toegevoegd voor admin functionaliteiten, zoals bij de `generate()` en `clear()` methodes in de MatcheController. Ik heb ook de frontend checks behouden als extra laag van beveiliging.

### Reflectie
Dit leermoment heeft me geleerd dat security niet iets is dat je achteraf toevoegt, maar dat het vanaf het begin een integraal onderdeel moet zijn van het ontwikkelproces. Het kost veel meer tijd om achteraf alle security issues te fixen dan om het vanaf het begin goed te implementeren. Tijdens mijn stage zal ik bij elk nieuw feature direct nadenken over wie toegang moet hebben en welke beveiligingsmaatregelen nodig zijn.

**Wat ik volgende keer anders doe:**
- Bij het plannen van een feature direct meenemen welke autorisatie nodig is
- Security checks implementeren parallel met de functionaliteit, niet achteraf
- Regelmatig security audits uitvoeren tijdens de ontwikkeling, niet alleen aan het einde
- Gebruik maken van Laravel's ingebouwde security features (Policies, Gates) vanaf het begin

**Wat ik wil behouden:**
- Het gebruik van meerdere lagen van beveiliging (middleware, controller checks, en frontend checks)
- Het documenteren van security beslissingen in code comments

---

## Leermoment 3: Database Relaties en Eager Loading Optimaliseren

### Situatie
Tijdens het testen van de applicatie merkte ik dat de wedstrijden pagina erg traag laadde, vooral wanneer er veel wedstrijden en teams in de database stonden. Bij het debuggen ontdekte ik dat er een N+1 query probleem was: voor elke wedstrijd werden aparte queries uitgevoerd om de team- en poolgegevens op te halen.

### Acties
Ik heb de code geanalyseerd en gezien dat in de `list()` methode van de MatcheController de relaties niet werden eager loaded. Ik heb dit opgelost door `with()` te gebruiken om de benodigde relaties in één keer op te halen: `Matche::with(['team1', 'team1.pool', 'team2', 'team2.pool'])`. Dit reduceerde het aantal database queries drastisch van honderden naar slechts enkele queries.

### Reflectie
Dit leermoment heeft me geleerd hoe belangrijk het is om aandacht te besteden aan database performance, zelfs in relatief kleine applicaties. Het N+1 query probleem is een veelvoorkomende fout die grote impact kan hebben op de performance. Tijdens mijn stage zal ik altijd letten op database queries en gebruik maken van Laravel's eager loading waar mogelijk. Ik zal ook regelmatig de query logs checken om te zien of er onnodige queries worden uitgevoerd.

**Wat ik volgende keer anders doe:**
- Altijd nadenken over welke relaties ik nodig heb voordat ik een query schrijf
- Gebruik maken van Laravel Debugbar of Telescope om query performance te monitoren tijdens ontwikkeling
- Eager loading standaard gebruiken bij het ophalen van models met relaties
- Leren over andere performance optimalisaties zoals database indexing

**Wat ik wil behouden:**
- Het gebruik van `with()` voor eager loading van relaties
- Het regelmatig checken van de performance van database queries

---

## Leermoment 4: Code Organisatie en Hergebruik

### Situatie
Tijdens de ontwikkeling merkte ik dat ik bepaalde logica meerdere keren had geschreven, zoals het bepalen van de speeltijd en pauzetijd per pool type. Deze logica stond verspreid over verschillende delen van de code, wat het onderhoud moeilijk maakte. Toen ik de speeltijden moest aanpassen, moest ik dit op meerdere plekken doen.

### Acties
Ik heb de herhaalde logica geëxtraheerd naar een private methode `getDurationAndPauseForPool()` in de MatcheController. Deze methode bevat een mapping van pool namen naar hun respectievelijke speeltijden en pauzetijden. Nu staat deze logica op één centrale plek, wat het onderhoud veel eenvoudiger maakt. Als de speeltijden veranderen, hoef ik dit maar op één plek aan te passen.

### Reflectie
Dit leermoment heeft me geleerd dat code organisatie en het voorkomen van code duplicatie cruciaal zijn voor onderhoudbare applicaties. Het DRY (Don't Repeat Yourself) principe is niet alleen een best practice, maar maakt het leven als developer veel eenvoudiger. Tijdens mijn stage zal ik altijd letten op herhaalde code en deze proberen te extraheren naar herbruikbare functies of classes. Ik zal ook meer aandacht besteden aan code organisatie vanaf het begin van een project.

**Wat ik volgende keer anders doe:**
- Regelmatig code reviews doen op mijn eigen code om duplicatie te identificeren
- Vaker gebruik maken van helper functies, service classes of traits voor herbruikbare logica
- Code organisatie meenemen in de planning fase, niet alleen achteraf refactoren
- Leren over design patterns die code organisatie verbeteren

**Wat ik wil behouden:**
- Het extraheren van herhaalde logica naar centrale functies
- Het gebruik van duidelijke, beschrijvende namen voor functies en variabelen

---

## Algemene Reflectie en Toepassing op Stage

Deze praktijkopdracht heeft me waardevolle ervaring opgeleverd met het ontwikkelen van een volledige webapplicatie. De belangrijkste lessen die ik meeneem naar mijn stage zijn:

1. **Planning en structuur**: Complexe problemen opdelen in kleinere stappen voorkomt overweldiging en maakt ontwikkeling efficiënter.

2. **Security first**: Beveiliging moet vanaf het begin meegenomen worden, niet achteraf toegevoegd.

3. **Performance awareness**: Aandacht voor database queries en performance optimalisaties is essentieel, ook in kleinere projecten.

4. **Code kwaliteit**: Goede code organisatie en het voorkomen van duplicatie maakt onderhoud veel eenvoudiger.

5. **Iteratief werken**: Stapsgewijs ontwikkelen en testen van componenten voorkomt grote problemen later.

Tijdens mijn stage zal ik deze lessen toepassen door:
- Altijd te beginnen met een duidelijke planning en probleemanalyse
- Security en autorisatie direct mee te nemen in nieuwe features
- Regelmatig te monitoren op performance issues
- Code reviews te doen op mijn eigen werk om kwaliteit te waarborgen
- Iteratief te werken en regelmatig te testen

Ik kijk ernaar uit om deze ervaringen toe te passen in een professionele omgeving tijdens mijn stage.


