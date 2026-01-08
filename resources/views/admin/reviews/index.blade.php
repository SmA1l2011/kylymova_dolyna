<x-app-layout>
    <x-slot name="header">
        <nav class="filter-sort">
            <form action="{{ route('adminProductIndex') }}" method="get" class="search-block"> 
                <div class="search">
                    <span class="search-icon"></span>
                    <input type="text" name="title" placeholder="Я шукаю..." value="{{ $_GET['title'] ?? '' }}">
                    <input type="submit" value="Знайти">
                    <div class="search-filter__block">
                        <svg class="filters-button" width="39px" height="39.5px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 11.1707L6 4C6 3.44771 5.55228 3 5 3C4.44771 3 4 3.44771 4 4L4 11.1707C2.83481 11.5825 2 12.6938 2 14C2 15.3062 2.83481 16.4175 4 16.8293L4 20C4 20.5523 4.44772 21 5 21C5.55228 21 6 20.5523 6 20L6 16.8293C7.16519 16.4175 8 15.3062 8 14C8 12.6938 7.16519 11.5825 6 11.1707ZM5 13C4.44772 13 4 13.4477 4 14C4 14.5523 4.44772 15 5 15C5.55228 15 6 14.5523 6 14C6 13.4477 5.55228 13 5 13Z"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9 9C9 7.69378 9.83481 6.58254 11 6.17071V4C11 3.44772 11.4477 3 12 3C12.5523 3 13 3.44772 13 4V6.17071C14.1652 6.58254 15 7.69378 15 9C15 10.3113 14.1586 11.4262 12.9863 11.8341C12.9953 11.8881 13 11.9435 13 12L13 20C13 20.5523 12.5523 21 12 21C11.4477 21 11 20.5523 11 20L11 12C11 11.9435 11.0047 11.8881 11.0137 11.8341C9.84135 11.4262 9 10.3113 9 9ZM11 9C11 8.44772 11.4477 8 12 8C12.5523 8 13 8.44772 13 9C13 9.55229 12.5523 10 12 10C11.4477 10 11 9.55229 11 9Z"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M19 21C18.4477 21 18 20.5523 18 20L18 18C18 17.9435 18.0047 17.8881 18.0137 17.8341C16.8414 17.4262 16 16.3113 16 15C16 13.6887 16.8414 12.5738 18.0137 12.1659C18.0047 12.1119 18 12.0565 18 12L18 4C18 3.44771 18.4477 3 19 3C19.5523 3 20 3.44771 20 4L20 12C20 12.0565 19.9953 12.1119 19.9863 12.1659C21.1586 12.5738 22 13.6887 22 15C22 16.3113 21.1586 17.4262 19.9863 17.8341C19.9953 17.8881 20 17.9435 20 18V20C20 20.5523 19.5523 21 19 21ZM18 15C18 14.4477 18.4477 14 19 14C19.5523 14 20 14.4477 20 15C20 15.5523 19.5523 16 19 16C18.4477 16 18 15.5523 18 15Z"/>
                            <rect class="rect rect1" x="4" y="2.5" rx="1" ry="1" width="2" height="19" fill="#fff"/>
                            <rect class="rect rect2" x="11" y="2.5" rx="1" ry="1" width="2" height="19" fill="#fff"/>
                            <rect class="rect rect3" x="18" y="2.5" rx="1" ry="1" width="2" height="19" fill="#fff"/>
                        </svg>
                        <p>Фільтри</p>
                    </div>
                </div>
            </form>
            <div class="filter-sort__block active">
                <form action="{{ route('adminReviewIndex') }}" method="get" class="sort-block">
                    <p>Сортувати:</p>
                    @isset ($_GET['sortBy'])
                        @if ($_GET['sortBy'] == 'id')
                            <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="sortBy" value="id">
                        @else
                            <input type="submit" name="sortBy" value="id">
                        @endif
        
                        @if ($_GET['sortBy'] == 'product_id')
                            <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="sortBy" value="product_id">
                        @else
                            <input type="submit" name="sortBy" value="product_id">
                        @endif
        
                        @if ($_GET['sortBy'] == 'rating')
                            <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="sortBy" value="rating">
                        @else
                            <input type="submit" name="sortBy" value="rating">
                        @endif
                    @else
                        <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="sortBy" value="id">
                        <input type="submit" name="sortBy" value="product_id">
                        <input type="submit" name="sortBy" value="rating">
                    @endif
        
                    @foreach ($_GET as $key => $value)
                        @if ($key !== "sortBy" && $key !== "clear")
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                </form>
                <form action="{{ route('adminReviewIndex') }}" method="get" class="filter-block">
                    <p>Чи підтверджений:</p>
                    @isset ($_GET["is_active"])
                        @if ($_GET["is_active"] == "all")
                            <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="is_active" value="all">
                        @else
                            <input type="submit" name="is_active" value="all">
                        @endif
                        @if ($_GET["is_active"] == "yes")
                            <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="is_active" value="yes">
                        @else
                            <input type="submit" name="is_active" value="yes">
                        @endif
                        @if ($_GET["is_active"] == "no")
                            <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="is_active" value="no">
                        @else
                            <input type="submit" name="is_active" value="no">
                        @endif
                    @else
                        <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="is_active" value="all">
                        <input type="submit" name="is_active" value="yes">
                        <input type="submit" name="is_active" value="no">
                    @endif
                    <p>Фільтрувати:</p>
                    <select name="product_id">
                        <option value="all">all</option>
                        @foreach ($allProducts as $product)
                            @if (isset($_GET["product_id"]) && $product->id == $_GET["product_id"])
                                <option selected value="{{ $product->id }}">{{ $product->id }}. {{ $product->title }}</option>
                            @else
                                <option value="{{ $product->id }}">{{ $product->id }}. {{ $product->title }}</option>
                            @endif
                        @endforeach
                    </select>
                    @isset ($_GET["sortBy"]) 
                        <input type="hidden" name="sortBy" value="{{ $_GET['sortBy'] }}">
                    @endif
                    <input type="submit" value="sand">
                </form>
            </div>
            <form action="{{ route('adminReviewIndex') }}" method="get" class="clear-filter__block clear-filter__block-active">
                <span></span>
                <span></span>
                <input type="submit" name="clear" value="Відмінити фільтри">
            </form>
        </nav>  
    </x-slot>
    <x-slot name="slot">
        <div class="wrapper">
            <table class="table reviews__table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>product_id</th>
                        <th>name</th>
                        <th>rating</th>
                        <th>comment</th>
                        <th>is_active</th>
                        <th>action</th>
                        <th>subreviews</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allReviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td><a href="{{ route('adminProduct', $review->product_id) }}">{{ $review->product_id }}</a></td>
                            <td>{{ $review->name }}</td>
                            <td>{{ $review->rating }}</td>
                            <td>{{ $review->comment }}</td>
                            <td>{{ $review->is_active ? "yes" : "no" }}</td>
                            <td>
                                <form class="review__form" action="{{ route('adminReviewStore') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $review->id }}">
                                    <input type="submit" name="is_active" value="{{ $review->is_active ? 'not approve' : 'approve' }}">
                                </form>
                            </td>
                            <td><a class="subreviewsButton" href="{{ route('adminSubreviewIndex', $review->id) }}">subreviews</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>