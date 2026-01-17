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
        <div class="wrapper">
            <h2 class="attention-h2">Увага!!! Ваш відгук не буде відображатися на сайті відразу, він з'явиться після перевірки адміністрацією сайту.</h2>
            @foreach ($allReviews as $review)
                <div class="review-block">
                    <div class="review__user-rating">
                        <p>{{ $review->name }}</p>
                        <div class="review__stars">
                            <?php $count = $review->rating ?>
                            @for ($i = 0; $i < 5; $i++)
                                @if ($count > 0)
                                    <span class="star active"></span>
                                @else
                                    <span class="star"></span>
                                @endif
                                <?php $count-- ?>
                            @endfor
                        </div>
                    </div>
                    <p class="review__comment">{{ $review->comment }}</p>
                </div>
            @endforeach
        </div>
        <form action="{{ route('productReviewsStore') }}" method="post" class="createReviewsForm">
            @csrf
            <div class="range-star">
                <input type="range" name="rating" id="rating" min="1" max="5" value="5">
                <span class="star" id="star"></span>
                <span class="star" id="star"></span>
                <span class="star" id="star"></span>
                <span class="star" id="star"></span>
                <span class="star" id="star"></span>
            </div>
            <textarea name="comment" cols="90" rows="1.5" maxlength="500"></textarea>
            <input type="hidden" name="product_id" value="{{ request('id') }}">
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <input type="submit" name="send" value="">
            @error("product_id")
                <p class="err">{{ $message }}</p>
            @enderror
            @error("user_id")
                <p class="err">{{ $message }}</p>
            @enderror
            @error("rating")
                <p class="err">{{ $message }}</p>
            @enderror
            @error("comment")
                <p class="err">{{ $message }}</p>
            @enderror
        </form>
    </x-slot>
</x-app-layout>