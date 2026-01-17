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
        <div class="wrapper category-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>назва</th>
                        <th>опис</th>
                        <th>редагувати</th>
                        <th>видалити</th>
                        <th>підкатегорія</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allCategories as $category)
                        <tr>
                            <td>{{ $category->title }}</td>
                            <td>{{ $category->description }}</td>
                            <td><a href="{{ route('categoryEdit', $category->id) }}">update</a></td>
                            <td>
                                <form action="{{ route('categoryDelete', $category->id) }}" method="post">
                                    @csrf
                                    @method("delete")
                                    <input class="table-submit" type="submit" value="delete">
                                </form>
                            </td>
                            <td><a href="{{ route('subcategoryIndex', $category->id) }}">subcategory</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('categoryCreate') }}">Створити</a>
        </div>
    </x-slot>
</x-app-layout>