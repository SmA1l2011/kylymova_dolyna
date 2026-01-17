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
        <div class="wrapper order-wrapper">
            @foreach ($orderProduct as $product)
                <div class="order-block">
                    <a href="{{ route('product', $product->id) }}" class="order-block__info">
                        @if ($product->picture == NULL)
                            <img src="{{ Vite::asset('resources/img/carpet.jpg') }}" alt="{{ $product->title }}" class="picture">
                        @else
                            <img src="{{ Vite::asset('resources/img/' . $product->picture) }}" alt="{{ $product->title }}" class="picture">
                        @endif
                        <p>{{ $product->title }}</p>
                    </a>
                    <form action="{{ route('orderStoreApply') }}" class="order-block__count" method="post">
                        @csrf
                        @if (Session::get('orders')[$count][1] == 1)
                            <label class="minus"><input type="submit" name="minus" value="minus" disabled></label>
                        @else
                            <label class="minus"><input type="submit" name="minus" value="minus"></label>
                        @endif
                        <input type="number" name="count" class="input-count" value="{{ Session::get('orders')[$count][1] }}" onchange="this.form.submit()">
                        <label class="plus"><input type="submit" name="plus" value="plus"></label>
                        <input type="hidden" name="id" value="{{ $count }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                    </form>
                    <p class="price">{{ $product->price * Session::get('orders')[$count][1] }}₴</p>
                    <?php $sumPrice += $product->price * Session::get('orders')[$count][1] ?>
                    <form action="{{ route('orderStoreApply') }}" method="post">
                        @csrf
                        <label class="order-block__delete">
                            <svg fill="none" height="24px" width="24px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 458.5 458.5" xml:space="preserve">
                                <path d="M382.078,57.069h-89.78C289.128,25.075,262.064,0,229.249,0S169.37,25.075,166.2,57.069H76.421
                                    c-26.938,0-48.854,21.916-48.854,48.854c0,26.125,20.613,47.524,46.429,48.793V399.5c0,32.533,26.467,59,59,59h192.508
                                    c32.533,0,59-26.467,59-59V154.717c25.816-1.269,46.429-22.668,46.429-48.793C430.933,78.985,409.017,57.069,382.078,57.069z
                                    M229.249,30c16.244,0,29.807,11.673,32.76,27.069h-65.52C199.442,41.673,213.005,30,229.249,30z M354.503,399.501
                                    c0,15.991-13.009,29-29,29H132.995c-15.991,0-29-13.009-29-29V154.778c12.244,0,240.932,0,250.508,0V399.501z M382.078,124.778
                                    c-3.127,0-302.998,0-305.657,0c-10.396,0-18.854-8.458-18.854-18.854S66.025,87.07,76.421,87.07h305.657
                                    c10.396,0,18.854,8.458,18.854,18.854S392.475,124.778,382.078,124.778z"/>
                                <path d="M229.249,392.323c8.284,0,15-6.716,15-15V203.618c0-8.284-6.715-15-15-15c-8.284,0-15,6.716-15,15v173.705
                                    C214.249,385.607,220.965,392.323,229.249,392.323z"/>
                                <path d="M306.671,392.323c8.284,0,15-6.716,15-15V203.618c0-8.284-6.716-15-15-15s-15,6.716-15,15v173.705
                                    C291.671,385.607,298.387,392.323,306.671,392.323z"/>
                                <path d="M151.828,392.323c8.284,0,15-6.716,15-15V203.618c0-8.284-6.716-15-15-15c-8.284,0-15,6.716-15,15v173.705
                                    C136.828,385.607,143.544,392.323,151.828,392.323z"/>
                            </svg>
                            <input type="submit" name="delete" value="delete">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </label>
                    </form>
                </div>
                <?php $count++ ?>
            @endforeach
            @if (!empty($orderProduct))
                <form class="order-submit" action="{{ route('orderStore') }}" method="post">
                    @csrf
                    @if (auth()->user() == null)
                        <label>
                            <!-- <p>Вкажіть свою контактну інформацію</p> -->
                            <input type="text" name="user_info" placeholder="Вкажіть контактну інформацію">
                            @error("user_info")
                                <p class="err">{{ $message }}</p>
                            @enderror
                        </label>
                        <p class="order-submit__info">Незабаром після оформлення замовлення адміністрація веб-сайту зателефонує вам або надішле листа, використовуючи контактну інформацію, яку ви вказали раніше, щоб підтвердити ваше замовлення.</p>
                    @else
                        <p class="order-submit__info">Незабаром після оформлення замовлення адміністрація веб-сайту зателефонує вам або надішле листа, використовуючи контактну інформацію, яку ви вказали під час реєстрації, щоб підтвердити ваше замовлення.</p>
                    @endif
                    <div class="order-submit__price">
                        <p class="price">{{ $sumPrice }}₴</p>
                        <input type="submit" name="order" value="Оформити замовлення">
                    </div>
                </form>
            @else
                <p>Кошик порожній</p>
                @if (Session::get('is_order') == true) 
                    <p>Ваше замовлення приннято. Незабаром адміністрація веб-сайту зателефонує вам або надішле листа</p>
                @endif
            @endif
        </div>
    </x-slot>
</x-app-layout>