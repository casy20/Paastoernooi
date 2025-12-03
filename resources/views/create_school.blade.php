<x-base-layout>
        <div class="team_text">
            <h1>maak een school aan</h1>
            <form action="{{ route('paastoernoois.store') }}" method="POST">
                @csrf
                <div class="team_form">
                    <label for=""></label>
                    <input name="referee" type="text" required class="team_input">
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="submit">Maak team aan</button>
                </div>
            </form>
        </div>
</x-base-layout>