<x-app-layout>
    <x-slot name="slot">
        <form action="{{ route('adminProductStore') }}" method="post" enctype="multipart/form-data">
            @csrf
            <select name="subcategory_id">
                @foreach ($allSubcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->title }}</option>
                @endforeach
            </select>
            @error("subcategory_id")
                <p class="err">{{ $message }}</p>
            @enderror
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
            <div>
                <input type="number" name="price" placeholder="price">
                @error("price")
                    <p class="err">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input type="file" name="picture">
                @error("picture")
                    <p class="err">{{ $message }}</p>
                @enderror
            </div>
            <input type="submit" name="Create">
        </form>
    </x-slot>
</x-app-layout>