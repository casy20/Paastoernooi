<x-base-layout>
    <div class="team_text match-generator match-container">
        <h1 class="match-title">Scorebord</h1>

        @if($completedMatches->isEmpty())
            <div class="matches-table-empty" style="text-align: center; padding: 40px;">
                <p>Nog geen voltooide wedstrijden. Scores worden hier getoond zodra wedstrijden zijn gespeeld.</p>
            </div>
        @else
            <!-- Scorebord - alle wedstrijden in één tabel -->
            <div class="matches-table-wrapper">
                <table class="matches-table">
                    <thead>
                        <tr>
                            <th>Pool</th>
                            <th>Team 1</th>
                            <th>Score</th>
                            <th>Team 2</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedMatches as $match)
                            <tr>
                                <td class="col-pool">{{ $match->team1->pool->name ?? 'Onbekend' }}</td>
                                <td>{{ $match->team1->name ?? 'Onbekend' }}</td>
                                <td><strong>{{ $match->team_1_score ?? 0 }} - {{ $match->team_2_score ?? 0 }}</strong></td>
                                <td>{{ $match->team2->name ?? 'Onbekend' }}</td>
                                <td>{{ $match->type ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-base-layout>

