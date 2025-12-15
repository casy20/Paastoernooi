<x-base-layout>

    <div class="admin_page">
        <!-- Linker navigatie -->
        <aside class="admin_nav">
            <h2 class="admin_nav__title">Navigatie</h2>
            <ul class="admin_nav__menu">
                <li><a href="">School</a></li>
                <li><a href="">Team</a></li>
                <li><a href="" class="active">Gebruikers</a></li>
            </ul>
        </aside>

        <!-- Rechter content -->
        <div class="admin_users">
            <h1 class="admin_users__title">Beheer van gebruikers</h1>

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
                        <th>E-mailadres</th>
                        <th>Wachtwoord</th>
                        <th>Telefoonnummer</th>
                        <th>Admin</th>
                        <th>Edit</th>
                        <th>Verwijder</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <!-- Update-form -->
                            <form action="{{ route('admin_Users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <td>
                                    <input type="text" name="name" value="{{ $user->name }}" class="admin_users__input">
                                </td>
                                <td>
                                    <input type="email" name="email" value="{{ $user->email }}" class="admin_users__input">
                                </td>
                                <td>
                                    <input type="password" name="password" class="admin_users__input">
                                </td>
                                <td>
                                    <input type="text" name="phone" value="{{ $user->phone }}" class="admin_users__input">
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="admin" value="1" {{ $user->admin ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <button type="submit" class="admin_users__button">
                                        bewerk
                                    </button>
                                </td>
                            </form>

                            <!-- Delete-form -->
                            <td>
                                <form action="{{ route('admin_Users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin_users__button admin_users__button--delete"
                                        onclick="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">
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
