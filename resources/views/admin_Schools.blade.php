<x-base-layout>

    <div class="admin_page">
        <!-- Linker navigatie -->
        <aside class="admin_nav">
            <h2 class="admin_nav__title">Navigatie</h2>
            <ul class="admin_nav__menu">
                <li><a href="{{ route('admin_Schools') }}" class="active">School</a></li>
                <li><a href="">Team</a></li>
                <li><a href="{{ route('admin_Users') }}">Gebruikers</a></li>
            </ul>
        </aside>

        <!-- Rechter content -->
        <div class="admin_users">
            <h1 class="admin_users__title">Beheer van school</h1>

            @if ($errors->any() || session('status'))
                <div id="alert-message" class="alert {{ $errors->any() ? 'alert-danger' : 'alert-success' }}">
                    @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @else
                        Gebruiker succesvol bijgewerkt!
                    @endif
                </div>

                <script>
                    setTimeout(function() {
                        const alert = document.getElementById('alert-message');
                        if(alert) {
                            alert.style.transition = 'opacity 0.5s';
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 5000);
                </script>
            @endif

            <table class="admin_users__table">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>schooltype</th>
						<th>Edit</th>
                        <th>Verwijder</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schools as $school)
                        <tr>
                            <!-- Update-form -->
                            <form action="{{ route('admin_Schools.update', $school->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <td>
                                    <input type="text" name="name" value="{{ $school->name }}" class="admin_users__input">
                                </td>
                                <td>
                                    <select name="school_type" class="admin_users__input">
                                        <option value="" disabled selected>-- kies --</option>
                                        <option value="Basisschool" {{ $school->school_type === 'Basisschool' ? 'selected' : '' }}>Basisschool</option>
                                        <option value="Middelbare school" {{ $school->school_type === 'Middelbare school' ? 'selected' : '' }}>Middelbare school</option>
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" class="admin_users__button">
                                        bewerk
                                    </button>
                                </td>
                            </form>

                            <!-- Delete-form -->
                            <td>
                                <form action="{{ route('admin_Schools.destroy', $school->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin_users__button admin_users__button--delete"
                                        onclick="return confirm('Weet je zeker dat je deze school wilt verwijderen?');">
                                        verwijder
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-base-layout>
