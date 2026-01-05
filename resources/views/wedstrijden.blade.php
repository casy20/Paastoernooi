<x-base-layout>
    <div class="team_text match-generator match-container">
        <h1 class="match-title">Wedstrijden</h1>

        <h2 class="matches-heading">Alle Teams ({{ $teams->count() }})</h2>
        <div class="matches-table-wrapper">
            <table class="matches-table">
                <thead>
                    <tr>
                        <th>Team Naam</th>
                        <th>School</th>
                        <th class="col-pool">Pool</th>
                        <th>Scheidsrechter</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teams as $team)
                        <tr>
                            <td>{{ $team->name ?? 'Onbekend' }}</td>
                            <td>{{ $team->school->name ?? 'Onbekend' }}</td>
                            <td class="col-pool">{{ $team->pool->name ?? 'Onbekend' }}</td>
                            <td>{{ $team->referee ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="matches-table-empty">Geen teams gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h2 class="matches-heading">Gegenereerde wedstrijden</h2>
        <hr class="matches-divider">
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
                        <th>Type</th>
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
                            <td>{{ $match->type ?? '-' }}</td>
                            <td>{{ $match->referee }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="matches-table-empty">Nog geen wedstrijden beschikbaar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-base-layout>
