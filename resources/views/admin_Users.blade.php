<x-base-layout>
    <div class="admin_users">
        <h1>Admin Users Page</h1>

        @foreach ($users as $user)
            <form action="{{ route('admin_Users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="text" name="name" placeholder="name" value="{{ $user->name }}">
                <input type="email" name="email" placeholder="email" value="{{ $user->email }}">
                <input type="text" name="password" placeholder="password">
                <input type="text" name="phone" placeholder="phone" value="{{ $user->phone }}">
                <input type="checkbox" name="admin" placeholder="admin" {{ $user->admin ? 'checked' : '' }}>
                <button type="submit">Submit</button>
            </form>
        @endforeach
    </div>       
</x-base-layout>
