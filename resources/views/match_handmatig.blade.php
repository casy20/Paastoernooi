<x-base-layout>
    <div class="team_text match-generator match-container">
        <h1 class="match-title">Handmatig wedstrijd aanmaken</h1>

        @if(session('success'))
            <div class="alert alert-success match-alert">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger match-alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('match.storeManualMatch') }}" method="POST" style="max-width: 600px; margin: 0 auto;">
            @csrf
            
            <div style="margin-bottom: 20px;">
                <label for="team_1_id" style="display: block; margin-bottom: 5px; font-weight: bold;">Team 1:</label>
                <select name="team_1_id" id="team_1_id" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="">-- Selecteer Team 1 --</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->pool->name ?? 'Onbekend' }})</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="team_2_id" style="display: block; margin-bottom: 5px; font-weight: bold;">Team 2:</label>
                <select name="team_2_id" id="team_2_id" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="">-- Selecteer Team 2 --</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->pool->name ?? 'Onbekend' }})</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="type" style="display: block; margin-bottom: 5px; font-weight: bold;">Type:</label>
                <select name="type" id="type" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="Eerste ronde">Eerste ronde</option>
                    <option value="Kwartfinale">Kwartfinale</option>
                    <option value="Halve Finale">Halve Finale</option>
                    <option value="Finale">Finale</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="field" style="display: block; margin-bottom: 5px; font-weight: bold;">Veld:</label>
                <input type="number" name="field" id="field" min="1" max="10" value="1" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="referee" style="display: block; margin-bottom: 5px; font-weight: bold;">Scheidsrechter:</label>
                <select name="referee" id="referee" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="">-- Selecteer Scheidsrechter --</option>
                    @foreach($referees as $referee)
                        <option value="{{ $referee }}">{{ $referee }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="start_time" style="display: block; margin-bottom: 5px; font-weight: bold;">Starttijd:</label>
                <input type="time" name="start_time" id="start_time" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="end_time" style="display: block; margin-bottom: 5px; font-weight: bold;">Eindtijd:</label>
                <input type="time" name="end_time" id="end_time" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="pause_minutes" style="display: block; margin-bottom: 5px; font-weight: bold;">Pauze (minuten):</label>
                <input type="number" name="pause_minutes" id="pause_minutes" min="0" value="5" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <button type="submit" class="submit" style="padding: 12px 30px; font-size: 16px;">Wedstrijd aanmaken</button>
                <a href="{{ route('matches.list') }}" class="submit" style="background-color: #6c757d; display: inline-block; text-decoration: none; padding: 12px 30px; margin-left: 10px;">Terug</a>
            </div>
        </form>
    </div>
</x-base-layout>

