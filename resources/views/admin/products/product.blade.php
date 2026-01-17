<x-app-layout>
<x-slot name="header">
        <nav class="filter-sort">
            <form action="{{ route('productIndex') }}" method="get" class="search-block"> 
                <div class="search">
                    <span class="search-icon"></span>
                    <input type="text" name="title" placeholder="Я шукаю..." value="{{ $_GET['title'] ?? '' }}">
                    <input type="submit" value="Знайти">
                </div>
            </form>
        </nav>
    </x-slot>
    <x-slot name="slot">
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
                <div class="price-block">
                    <p class="price"><b>{{ $product->price }}₴</b></p>
                </div>
                <div class="product-page__review">
                    <p class="reviews-p"><a href="{{ route('productReviews', $product->id) }}">Відгуки {{ count($allReviews) }} шт:</a></p>
                    <p class="rating-p">Оцінка користувачів<b>
                        @if ($avgRating == 0)
                            Оцінки немає</b>
                        @else
                            {{ $avgRating }}/5</b><span class="star"></span>
                        @endif
                    </p>
                    <div class="rating-blocks">
                        <div class="five-stars__block">
                            <p>5</p>
                            <span class="star"></span>
                            @if (count($allReviews) == 0)
                                <div class="scale"><span></span></div>
                            @else
                                <div class="scale"><span style="width: {{ (100 / count($allReviews)) * $ratingCount[5] }}%;"></span></div>
                            @endif
                            <p>{{ $ratingCount[5] }}</p>
                        </div>
                        <div class="four-stars__block">
                            <p>4</p>
                            <span class="star"></span>
                            @if (count($allReviews) == 0)
                                <div class="scale"><span></span></div>
                            @else
                                <div class="scale"><span style="width: {{ (100 / count($allReviews)) * $ratingCount[4] }}%;"></span></div>
                            @endif
                            <p>{{ $ratingCount[4] }}</p>
                        </div>
                        <div class="three-stars__block">
                            <p>3</p>
                            <span class="star"></span>
                            @if (count($allReviews) == 0)
                                <div class="scale"><span></span></div>
                            @else   
                                <div class="scale"><span style="width: {{ (100 / count($allReviews)) * $ratingCount[3] }}%;"></span></div>
                            @endif
                            <p>{{ $ratingCount[3] }}</p>
                        </div>
                        <div class="two-stars__block">
                            <p>2</p>
                            <span class="star"></span>
                            @if (count($allReviews) == 0)
                                <div class="scale"><span></span></div>
                            @else
                                <div class="scale"><span style="width: {{ (100 / count($allReviews)) * $ratingCount[2] }}%;"></span></div>
                            @endif
                            <p>{{ $ratingCount[2] }}</p>
                        </div>
                        <div class="one-stars__block">
                            <p>1</p>
                            <span class="star"></span>
                            @if (count($allReviews) == 0)
                                <div class="scale"><span></span></div>
                            @else
                                <div class="scale"><span style="width: {{ (100 / count($allReviews)) * $ratingCount[1] }}%;"></span></div>
                            @endif
                            <p>{{ $ratingCount[1] }}</p>
                        </div>
                    </div>
                    <form action="{{ route('adminReviewIndex') }}" method="get">
                        <input type="submit" value="Дивитись відгуки">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                    </form>
                    <a class="send-review" href="{{ route('adminProductEdit', $product->id) }}"><b>редагувати</b></a>
                    <form action="{{ route('adminProductDelete', $product->id) }}" method="post">
                        @csrf
                        @method("delete")
                        <input type="submit" value="видалити">
                    </form>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            window.dataLayer.push(@json($productGTM))
                            console.log(dataLayer)
                        })
                    </script>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>