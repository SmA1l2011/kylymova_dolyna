<x-app-layout>
    <x-slot name="header"></x-slot>
    <x-slot name="slot">
        <a class="backButton" href="{{ route('productIndex') }}">Back</a>
        <div class="wrapper flex product-page">
            <div class="picture-block">
                @if ($product->picture == NULL)
                    <img src="{{ Vite::asset('resources/img/carpet.jpg') }}" alt="{{ $product->title }}">
                @else
                    <img src="{{ Vite::asset('resources/img/' . $product->picture) }}" alt="{{ $product->title }}" class="picture">
                @endif
            </div>
            <div class="info-block">
                <h1>{{ $product->title }}</h1>
                <p><a href="{{ route('productReviews', $product->id) }}"><b>Відгуки...</b></a></p>
                <div class="price-block">
                    <p class="price"><b>{{ $product->price }}$</b></p>
                    <form action="{{ route('productStore') }}" method="post">
                        @csrf
                        <label>
                            <input type="submit" value="Замовити">
                        </label>
                        <input type="hidden" name="order" value="{{ $product->id }}">
                        <input type="hidden" name="price" value="{{ $product->price }}">
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>