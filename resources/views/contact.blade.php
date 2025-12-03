<x-layout>
 

    <section class="contact-wrapper">
        <h1>Contact</h1>

        <form method="POST" action="#">
            @csrf

            <div>
                <label for="name">Naam</label>
                <input type="text" id="name" name="name" placeholder="Uw naam" required>
            </div>

            <div>
                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" placeholder="uw@email.nl" required>
            </div>

            <div>
                <label for="complaint">Uw vraag of klacht</label>
                <textarea id="complaint" name="complaint" placeholder="Beschrijf uw vraag of klacht" required></textarea>
            </div>

            <button type="submit">Verstuur</button>
        </form>

    </section>
</x-layout>

