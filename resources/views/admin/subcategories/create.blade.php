<x-app-layout>
    <x-slot name="slot">
        <form action="{{ route('subcategoryStore') }}" method="post">
            @csrf
            <div>
                <input type="text" name="title" placeholder="title">
                @error("title")
                    <p class="err">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input type="text" name="description" placeholder="description">
                @error("description")
                    <p class="err">{{ $message }}</p>
                @enderror
            </div>
            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            <input type="submit" name="Create">
        </form>
    </x-slot>
</x-app-layout>