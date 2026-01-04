<x-app-layout>
    <x-slot name="slot">
        <a class="backButton" href="{{ route('product', request('id')) }}">Back</a>
        <div class="wrapper">
            @foreach ($allReviews as $review)
                <a href="{{ route('subreviewIndex', [request('id'), $review->id]) }}" class="review-block">
                    <div class="review__user-rating">
                        <span class="review__user-img"></span>
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
                </a>
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
            <textarea name="comment" cols="90" rows="1.5"></textarea>
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