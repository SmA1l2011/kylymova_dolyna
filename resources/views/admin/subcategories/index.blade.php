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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subcategories as $subcategory)
                        <tr>
                            <td>{{ $subcategory->title }}</td>
                            <td>{{ $subcategory->description }}</td>
                            <td><a href="{{ route('subcategoryEdit', [request('category_id'), $subcategory->id]) }}">update</a></td>
                            <td>
                                <form action="{{ route('subcategoryDelete', $subcategory->id) }}" method="post">
                                    @csrf
                                    @method("delete")
                                    <input class="table-submit" type="submit" value="delete">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('subcategoryCreate', request('category_id')) }}">create</a>
        </div>
    </x-slot>
</x-app-layout>