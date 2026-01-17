<x-app-layout>
    <x-slot name="slot">
        <form action="{{ route('categoryStore') }}" method="post">
            @csrf
            <div>
                <input type="text" name="title" placeholder="назва">
                @error("title")
                    <p class="err">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input type="text" name="description" placeholder="опис">
                @error("description")
                    <p class="err">{{ $message }}</p>
                @enderror
            </div>
            <input type="submit" name="Create">
        </form>
    </x-slot>
</x-app-layout>