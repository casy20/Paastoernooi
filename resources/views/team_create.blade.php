<x-base-layout>
        <div class="team_text">
            <h1>Maak een team aan</h1>
            <form action="{{ route('paastoernoois.store') }}" method="POST">
                @csrf
                <div class="team_form">
                    <label for="school_id">School naam</label>
                    <input name="school_id" required class="team_input">
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </input>   
                </div>

                <div class="team_form">
                    <label for="referee">Scheidsrechter</label>
                    <input name="referee" type="text" required class="team_input">
                </div>

                <div class="team_form">
                    <label for="name">naam</label>
                    <input name="name" type="text" required class="team_input">
                </div>

                <div class="team_form">
                    <label for="pool_id">naam</label>
                    <select name="pool_id" required class="team_drop">
                        <option value="">kies een pool</option>
                        <option value="Voetbal groep 3/4">Voetbal groep 3/4 (gemengd)</option>
                        <option value="Voetbal groep 5/6">Voetbal groep 5/6 (gemengd)</option>
                        <option value="Voetbal groep 7/8">Voetbal groep 7/8 (gemengd)</option>
                        <option value="Voetbal 1e klas">Voetbal 1e klas (jongens/gemengd)</option>
                        <option value="Voetbal 1e klas">Voetbal 1e klas (meiden)</option>
                        <option value="Lijnbal groep 7/8">Lijnbal groep 7/8 (meiden)</option>
                        <option value="Lijnbal 1e klas">Lijnbal 1e klas (meiden)</option>
                        @foreach($pools as $pool)
                            <option value="{{ $pool->id }}">{{ $pool->name }}</option>
                        @endforeach
                    </select>   
                </div>
                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="submit">Maak team aan</button>
                </div>
            </form>
        </div>
</x-base-layout>