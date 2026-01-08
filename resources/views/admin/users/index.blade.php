<x-app-layout>
    <x-slot name="header">
        <nav class="filter-sort">
            <form action="{{ route('adminProductIndex') }}" method="get" class="search-block"> 
                <div class="search">
                    <span class="search-icon"></span>
                    <input type="text" name="title" placeholder="Я шукаю..." value="{{ $_GET['title'] ?? '' }}">
                    <input type="submit" value="Знайти">
                </div>
            </form>
        </nav>
    </x-slot>
    <x-slot name="slot">
        <div class="wrapper user-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>surname</th>
                        <th>email</th>
                        <th>phone</th>
                        <th>password</th>
                        <th>role</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                        <th>apply</th>
                        <th>delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allUsers as $user)
                            <tr>
                                <form action="{{ route('userEdit', $user->id) }}" method="post">
                                    @csrf
                                    <td>{{ $user->id }}</td>
                                    <td><input class="table-input" type="text" name="name" value="{{ $user->name }}"></td>
                                    <td><input class="table-input" type="text" name="surname" value="{{ $user->surname }}"></td>
                                    <td><input class="table-input" type="email" name="email" value="{{ $user->email }}"></td>
                                    <td><input class="table-input" type="phone" name="phone" value="{{ $user->phone }}"></td>
                                    <td><input class="table-input" type="password" name="password" placeholder="edit password"></td>
                                    <td>
                                        <select class="table-select" name="role">
                                            @if ($user->role == "admin")
                                                <option selected value="admin">admin</option>
                                                <option value="user">user</option>
                                            @else
                                                <option selected value="user">user</option>
                                                <option value="admin">admin</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td><input class="table-submit" type="submit" value="apply"></td>
                                </form>
                                <td>
                                    @if (auth()->user()->email !== $user->email)
                                        <form action="{{ route('userDelete', $user->id) }}" method="post">
                                            @csrf
                                            @method("delete")
                                            <input class="table-submit" type="submit" value="delete">
                                        </form>
                                    @else
                                        <p>this is your account</p>
                                    @endif
                                </td>
                            </tr> 
                    @endforeach
                </tbody>
            </table>
            @error("name")
                <p class="err">{{ $message }}</p>
            @enderror

            @error("surname")
                <p class="err">{{ $message }}</p>
            @enderror
            
            @error("email")
                <p class="err">{{ $message }}</p>
            @enderror

            @error("phone")
                <p class="err">{{ $message }}</p>
            @enderror

            @error("password")
                <p class="err">{{ $message }}</p>
            @enderror
        </div>
    </x-slot>
</x-app-layout>