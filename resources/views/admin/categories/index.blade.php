<x-app-layout>
    <x-slot name="slot">
        <div class="wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>title</th>
                        <th>description</th>
                        <th>update</th>
                        <th>delete</th>
                        <th>subcategory</th>
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
            <a href="{{ route('categoryCreate') }}">create</a>
        </div>
    </x-slot>
</x-app-layout>