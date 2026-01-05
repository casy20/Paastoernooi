<x-base-layout>
    <div class="team_text match-generator match-container">
        <h1 class="match-title">Wedstrijd automatisch genereren</h1>

        @if(session('success'))
            <div class="alert alert-success match-alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger match-alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="match-actions match-buttons">
            <form action="{{ route('match.generate') }}" method="POST">
                @csrf
                <button type="submit" class="submit">Genereer wedstrijd</button>
            </form>
            <form action="{{ route('match.clear') }}" method="POST" onsubmit="return confirm('Weet je zeker dat je alle wedstrijden wilt verwijderen?');">
                @csrf
                <button type="submit" class="submit danger">Verwijder alle</button>
            </form>
        </div>

        <h2 class="matches-heading">Laatst gegenereerde wedstrijden</h2>
        <div class="matches-table-wrapper">
            <table class="matches-table">
                <thead>
                    <tr>
                        <th>Team 1</th>
                        <th>Team 2</th>
                        <th class="col-pool">Pool</th>
                        <th>Veld</th>
                        <th>Starttijd</th>
                        <th>Eindtijd</th>
                        <th>Pauze</th>
                        <th>Scheidsrechter</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($matches as $match)
                        <tr>
                            <td>{{ $match->team1->name ?? 'Onbekend' }}</td>
                            <td>{{ $match->team2->name ?? 'Onbekend' }}</td>
                            <td class="col-pool">{{ $match->team1->pool->name ?? 'Onbekend' }}</td>
                            <td>{{ $match->field ?? '-' }}</td>
                            <td>{{ $match->start_time }}</td>
                            <td>{{ $match->end_time ?? '-' }}</td>
                            <td>{{ $match->pause_minutes ?? '-' }} min</td>
                            <td>{{ $match->referee }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="matches-table-empty">Nog geen wedstrijden gegenereerd.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-base-layout>
