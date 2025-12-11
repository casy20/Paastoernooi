<x-base-layout>
        <div class="team_text">
            <h1>Maak een team aan</h1>
            <form action="{{ route('teams.store') }}" method="POST">
                @csrf
                <div class="team_form">
                    <label for="school_id">School naam</label>
                    <select name="school_id" required class="team_input">
                        <option value="">kies een school</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </select>   
                </div>

                <div class="team_form">
                    <label for="referee">Scheidsrechter naam</label>
                    <input name="referee" type="text" required class="team_input">
                </div>

                <div class="team_form">
                    <label for="name">team naam</label>
                    <input name="name" type="text" required class="team_input">
                </div>

                <div class="team_form">
                    <label for="pool_id">pool</label>
                    <select name="pool_id" required class="team_input">
                            <option value="">kies een pool</option>
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