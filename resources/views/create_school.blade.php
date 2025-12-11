<x-base-layout>
        <div class="team_text">
            <h1>maak een school aan</h1>
            <form action="{{ route('schools.store') }}" method="POST">
                @csrf
                <div class="team_form">
                    <label for="name"></label>
                    <input name="name" type="text" required class="team_input">
                </div>

                <div class="team_form">
                    <label for="school_type"></label>
                    <select name="school_type" required class="team_input">
                        <option value="">kies een school type</option>
                        <option value="basisschool">basisschool</option>
                        <option value="middelbare school">middelbare school</option>
                    </select>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="submit">Maak team aan</button>
                </div>
            </form>
        </div>
</x-base-layout>