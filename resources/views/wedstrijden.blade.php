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

        @if(session('success'))
            <div class="alert alert-success match-alert" style="white-space: pre-line;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger match-alert" style="white-space: pre-line;">
                {{ session('error') }}
            </div>
        @endif

        @auth
            @if (Auth::user() && Auth::user()->admin == 1)
                <div class="match-actions match-buttons" style="margin-bottom: 20px; text-align: center;">
                    <form action="{{ route('match.generate') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="submit" title="Genereer alleen round-robin wedstrijden (begin van toernooi)">Eerste wedstrijden genereren</button>
                    </form>
                    <a href="{{ route('match.manualNextRound') }}" class="submit" style="background-color: #9c65c4; display: inline-block; text-decoration: none; padding: 10px 20px;" title="Handmatig volgende ronde wedstrijden maken (kies zelf teams, tijd, scheidsrechter)">Handmatig volgende ronde maken</a>
                    <form action="{{ route('match.clear') }}" method="POST" onsubmit="return confirm('Weet je zeker dat je alle wedstrijden wilt verwijderen?');" style="display: inline;">
                        @csrf
                        <button type="submit" class="submit danger">Verwijder alles</button>
                    </form>
                </div>
            @endif
        @endauth

        <h2 class="matches-heading">Gegenereerde wedstrijden</h2>
        
        @auth
            @if (Auth::user() && Auth::user()->admin == 1)
                <div style="margin-bottom: 15px; text-align: center;">
                    <button type="button" 
                            id="save-all-scores-btn" 
                            class="submit" 
                            style="padding: 10px 20px; background: #07d564; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: bold; margin-right: 15px;">
                        Opslaan alle scores
                    </button>
                    <label for="sort-select" style="margin-right: 10px;">Sorteer op:</label>
                    <select id="sort-select" onchange="window.location.href='?sort=' + this.value" style="padding: 6px 12px; border-radius: 4px; border: 1px solid #ccc;">
                        <option value="time" {{ $sortBy == 'time' ? 'selected' : '' }}>Starttijd</option>
                        <option value="score" {{ $sortBy == 'score' ? 'selected' : '' }}>Score (hoog naar laag)</option>
                        <option value="pool" {{ $sortBy == 'pool' ? 'selected' : '' }}>Pool</option>
                    </select>
                </div>
            @endif
        @endauth
        
        <hr class="matches-divider">
        <div class="matches-table-wrapper">
            <table class="matches-table">
                <thead>
                    <tr>
                        <th style="width: 8%;">Team 1</th>
                        <th style="width: 5%;">S1</th>
                        <th style="width: 8%;">Team 2</th>
                        <th style="width: 5%;">S2</th>
                        <th class="col-pool" style="width: 12%;">Pool</th>
                        <th style="width: 4%;">V</th>
                        <th style="width: 5%;">Start</th>
                        <th style="width: 5%;">Eind</th>
                        <th style="width: 4%;">P</th>
                        <th style="width: 8%;">Type</th>
                        <th style="width: 10%;">Scheids</th>
                        @auth
                            @if (Auth::user() && Auth::user()->admin == 1)
                                <th style="width: 12%;">Actie</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @forelse($matches as $match)
                        <tr data-match-id="{{ $match->id }}">
                            <td>{{ $match->team1->name ?? 'Onbekend' }}</td>
                            <td>
                                @auth
                                    @if (Auth::user() && Auth::user()->admin == 1)
                                        <input type="number" 
                                               name="team_1_score" 
                                               value="{{ $match->team_1_score ?? 0 }}" 
                                               min="0" 
                                               class="score-input"
                                               data-match-id="{{ $match->id }}"
                                               data-team="1"
                                               style="width: 40px; text-align: center; padding: 2px; font-size: 10px;">
                                    @else
                                        <strong>{{ $match->team_1_score ?? '-' }}</strong>
                                    @endif
                                @else
                                    <strong>{{ $match->team_1_score ?? '-' }}</strong>
                                @endauth
                            </td>
                            <td>{{ $match->team2->name ?? 'Onbekend' }}</td>
                            <td>
                                @auth
                                    @if (Auth::user() && Auth::user()->admin == 1)
                                        <input type="number" 
                                               name="team_2_score" 
                                               value="{{ $match->team_2_score ?? 0 }}" 
                                               min="0" 
                                               class="score-input"
                                               data-match-id="{{ $match->id }}"
                                               data-team="2"
                                               style="width: 40px; text-align: center; padding: 2px; font-size: 10px;">
                                    @else
                                        <strong>{{ $match->team_2_score ?? '-' }}</strong>
                                    @endif
                                @else
                                    <strong>{{ $match->team_2_score ?? '-' }}</strong>
                                @endauth
                            </td>
                            <td class="col-pool">{{ $match->team1->pool->name ?? 'Onbekend' }}</td>
                            <td>{{ $match->field ?? '-' }}</td>
                            <td>{{ substr($match->start_time, 0, 5) }}</td>
                            <td>{{ $match->end_time ? substr($match->end_time, 0, 5) : '-' }}</td>
                            <td>{{ $match->pause_minutes ?? '-' }}</td>
                            <td>{{ $match->type ?? '-' }}</td>
                            <td>{{ $match->referee }}</td>
                            @auth
                                @if (Auth::user() && Auth::user()->admin == 1)
                                    <td>
                                        <button type="button" 
                                                class="save-score-btn" 
                                                data-match-id="{{ $match->id }}"
                                                style="padding: 3px 6px; background: #07d564; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 9px; margin-right: 4px;">
                                            Opslaan
                                        </button>
                                        <button type="button" 
                                                class="delete-match-btn" 
                                                data-match-id="{{ $match->id }}"
                                                style="padding: 3px 6px; background: #dc3545; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 9px;">
                                            Verwijder
                                        </button>
                                    </td>
                                @endif
                            @endauth
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="matches-table-empty">Nog geen wedstrijden beschikbaar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @auth
        @if (Auth::user() && Auth::user()->admin == 1)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // CSRF token ophalen
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                     document.querySelector('input[name="_token"]')?.value;
                    
                    // Functie om een enkele score op te slaan
                    function saveSingleScore(matchId, team1Score, team2Score) {
                        return fetch(`/matches/${matchId}/score`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                team_1_score: parseInt(team1Score) || 0,
                                team_2_score: parseInt(team2Score) || 0
                            })
                        });
                    }
                    
                    // Functie om een wedstrijd te verwijderen
                    function deleteMatch(matchId) {
                        if (!confirm('Weet je zeker dat je deze wedstrijd wilt verwijderen?')) {
                            return;
                        }
                        
                        return fetch(`/matches/${matchId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        });
                    }
                    
                    // Event listeners voor individuele "Opslaan" knoppen
                    document.querySelectorAll('.save-score-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const matchId = this.getAttribute('data-match-id');
                            const row = this.closest('tr');
                            const team1Score = row.querySelector('input[data-team="1"]').value;
                            const team2Score = row.querySelector('input[data-team="2"]').value;
                            
                            saveSingleScore(matchId, team1Score, team2Score)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Score opgeslagen!');
                                        location.reload();
                                    } else {
                                        alert('Fout bij opslaan: ' + (data.message || 'Onbekende fout'));
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Fout bij opslaan van score');
                                });
                        });
                    });
                    
                    // Event listeners voor individuele "Verwijder" knoppen
                    document.querySelectorAll('.delete-match-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const matchId = this.getAttribute('data-match-id');
                            
                            deleteMatch(matchId)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Wedstrijd verwijderd!');
                                        location.reload();
                                    } else {
                                        alert('Fout bij verwijderen: ' + (data.message || 'Onbekende fout'));
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Fout bij verwijderen van wedstrijd');
                                });
                        });
                    });
                    
                    // Event listener voor "Opslaan alle scores" knop
                    const saveAllBtn = document.getElementById('save-all-scores-btn');
                    if (saveAllBtn) {
                        saveAllBtn.addEventListener('click', function() {
                            const matchesToSave = [];
                            
                            // Verzamel alle scores van rijen met data-match-id
                            document.querySelectorAll('tr[data-match-id]').forEach(row => {
                                const matchId = row.getAttribute('data-match-id');
                                const team1Input = row.querySelector('input[data-team="1"]');
                                const team2Input = row.querySelector('input[data-team="2"]');
                                
                                if (matchId && team1Input && team2Input) {
                                    const team1Score = team1Input.value || 0;
                                    const team2Score = team2Input.value || 0;
                                    
                                    matchesToSave.push({
                                        matchId: matchId,
                                        team1Score: team1Score,
                                        team2Score: team2Score
                                    });
                                }
                            });
                            
                            if (matchesToSave.length === 0) {
                                alert('Geen scores om op te slaan.');
                                return;
                            }
                            
                            // Disable knop tijdens opslaan
                            saveAllBtn.disabled = true;
                            saveAllBtn.textContent = 'Bezig met opslaan...';
                            
                            // Sla alle scores op
                            const savePromises = matchesToSave.map(match => 
                                saveSingleScore(match.matchId, match.team1Score, match.team2Score)
                            );
                            
                            Promise.all(savePromises)
                                .then(responses => {
                                    // Check of alle responses succesvol zijn
                                    const allSuccess = responses.every(response => response.ok);
                                    if (allSuccess) {
                                        alert('Alle scores opgeslagen!');
                                        location.reload();
                                    } else {
                                        alert('Sommige scores konden niet worden opgeslagen.');
                                        saveAllBtn.disabled = false;
                                        saveAllBtn.textContent = 'Opslaan alle scores';
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Fout bij opslaan van scores');
                                    saveAllBtn.disabled = false;
                                    saveAllBtn.textContent = 'Opslaan alle scores';
                                });
                        });
                    }
                });
            </script>
        @endif
    @endauth
</x-base-layout>
