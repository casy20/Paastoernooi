<x-layout>

    <style>
        :root {
            --purple-dark: #4c1d95;
            --purple: #7c3aed;
            --purple-light: #ede9fe;
            --text-dark: #1f1b2e;
        }

        .info-wrapper {
            max-width: 960px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
            background: linear-gradient(135deg, #ffffff, var(--purple-light));
            border: 1px solid rgba(124, 58, 237, 0.2);
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(76, 29, 149, 0.15);
            color: var(--text-dark);
        }

        .info-wrapper h1 {
            color: var(--purple-dark);
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .info-wrapper h2 {
            color: var(--purple);
            border-bottom: 2px solid rgba(124, 58, 237, 0.25);
            padding-bottom: 0.35rem;
        }

        .info-wrapper h3 {
            color: var(--purple-dark);
        }

        .info-wrapper ul {
            background: #fff;
            border-left: 4px solid var(--purple);
            padding: 1.1rem 1.5rem;
            border-radius: 0 14px 14px 0;
            box-shadow: inset 0 0 10px rgba(124, 58, 237, 0.08);
        }

        .info-wrapper a {
            color: var(--purple);
            font-weight: 600;
        }

        .info-wrapper a:hover {
            color: var(--purple-dark);
            text-decoration: underline;
        }
    </style>

    <section class="info-wrapper">

        <h1 class="text-4xl font-bold mb-6">Stichting Paastoernooien Bergen op Zoom</h1>

        <p class="mb-6">
            Wij organiseren jaarlijks voetbal- en lijnbaltoernooien voor basisschoolleerlingen (groep 3 t/m 8)
            en leerlingen uit de 1e klas van de middelbare school, in Bergen op Zoom en omgeving.
            In totaal worden er 7 toernooien georganiseerd.
        </p>

        <h2 class="text-3xl font-semibold mt-10 mb-3">Onze Toernooien</h2>

        <ul class="list-disc ml-6 space-y-1">
            <li>Voetbal groep 3/4 (gemengd)</li>
            <li>Voetbal groep 5/6 (gemengd)</li>
            <li>Voetbal groep 7/8 (gemengd)</li>
            <li>Voetbal 1e klas (jongens/gemengd)</li>
            <li>Voetbal 1e klas (meiden)</li>
            <li>Lijnbal groep 7/8 (meiden)</li>
            <li>Lijnbal 1e klas (meiden)</li>
        </ul>


        {{-- INSCHRIJVEN --}}
        <h2 class="text-3xl font-semibold mt-10 mb-3">Inschrijvingen</h2>

        <p class="mb-4">
            Scholen kunnen vanaf het begin van januari hun teams inschrijven via de website.
            Bij het inschrijven worden direct alle benodigde gegevens opgevraagd.
        </p>

        <h3 class="text-2xl font-semibold mb-2">Benodigde informatie</h3>
        <ul class="list-disc ml-6 space-y-1">
            <li>Naam van de school</li>
            <li>E-mailadres van de coach</li>
            <li>Aantal teams per toernooi</li>
            <li>Naam en e-mailadres van de scheidsrechter (verplicht)</li>
        </ul>

        <p class="mt-4">
            Na inschrijving ontvangt de school automatisch een bevestigingsmail,
            inclusief een kopie van het inschrijfformulier.
        </p>


        {{-- SCHEMA'S --}}
        <h2 class="text-3xl font-semibold mt-10 mb-3">Speelschema’s</h2>

        <p class="mb-4">
            Na de sluitingsdatum worden speelschema’s samengesteld voor alle toernooien.
            Hierbij houden we rekening met uitsluitingen, zoals:
        </p>

        <ul class="list-disc ml-6 mb-4">
            <li>Twee teams van dezelfde school niet in dezelfde poule.</li>
        </ul>

        <p>
            De schema’s worden op een overzichtelijke manier gepubliceerd op de website
            en zijn gemakkelijk aan te passen bij afmeldingen of late inschrijvingen.
        </p>


        {{-- LIVE SCORES --}}
        <h2 class="text-3xl font-semibold mt-10 mb-3">Live Scores</h2>

        <p class="mb-4">
            Tijdens de toernooien is er een afgesloten beheeromgeving beschikbaar voor vrijwilligers,
            waar de scores live kunnen worden ingevoerd.
        </p>

        <p>
            De tussenstanden worden automatisch bijgewerkt en zijn publiek zichtbaar op de website,
            zodat teams en bezoekers de voortgang kunnen volgen.
        </p>


        {{-- CONTACT --}}
        <h2 class="text-3xl font-semibold mt-10 mb-3">Contact</h2>

        <p class="mb-4">
            Voor vragen of opmerkingen kunt u ons bereiken via het contactformulier op de website.
        </p>

        <a href="{{ route('contact') }}" class="text-blue-600 underline">Ga naar het contactformulier</a>

    </section>
</x-layout>