<x-app-layout>
    <x-slot name="slot">
        <nav class="filter-sort">
            <form action="{{ route('adminOrderIndex') }}" method="get" class="sort-block">
                <p>sort:</p>
                @isset ($_GET['sortBy'])
                    @if ($_GET['sortBy'] == 'default')
                        <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="sortBy" value="default">
                    @else
                        <input type="submit" name="sortBy" value="default">
                    @endif

                    @if ($_GET['sortBy'] == 'product_id')
                        <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="sortBy" value="product_id">
                    @else
                        <input type="submit" name="sortBy" value="product_id">
                    @endif

                    @if ($_GET['sortBy'] == 'user_id')
                        <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="sortBy" value="user_id">
                    @else
                        <input type="submit" name="sortBy" value="user_id">
                    @endif

                    @if ($_GET['sortBy'] == 'count')
                        <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="sortBy" value="count">
                    @else
                        <input type="submit" name="sortBy" value="count">
                    @endif

                    @if ($_GET['sortBy'] == 'price down')
                        <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="sortBy" value="price down">
                    @else
                        <input type="submit" name="sortBy" value="price down">
                    @endif

                    @if ($_GET['sortBy'] == 'price up')
                        <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="sortBy" value="price up">
                    @else
                        <input type="submit" name="sortBy" value="price up">
                    @endif
                @else
                    <input style="color: #fff; border-color: #fff; background: transparent;" type="submit" name="sortBy" value="default">
                    <input type="submit" name="sortBy" value="product_id">
                    <input type="submit" name="sortBy" value="user_id">
                    <input type="submit" name="sortBy" value="count">
                    <input type="submit" name="sortBy" value="price down">
                    <input type="submit" name="sortBy" value="price up">
                @endif

                @foreach ($_GET as $key => $value)
                    @if ($key !== "sortBy" && $key !== "clear")
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
            </form>
            <form action="{{ route('adminOrderIndex') }}" method="get" class="filter-block">
                <p>filters:</p>
                <select name="user_id">
                    <option value="all">all</option>
                    @foreach ($allUsers as $user)
                        @if (isset($_GET["user_id"]) && $user->id == $_GET["user_id"])
                            <option selected value="{{ $user->id }}">{{ $user->name }}</option>
                        @else
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
                <input type="number" name="minPrice" placeholder="min price" value="{{ $_GET['minPrice'] ?? '' }}">
                <input type="number" name="maxPrice" placeholder="max price" value="{{ $_GET['maxPrice'] ?? '' }}">
                <input type="submit" value="sand">
                @isset ($_GET["sortBy"]) 
                    <input type="hidden" name="sortBy" value="{{ $_GET['sortBy'] }}">
                @endif
            </form>
            <form action="{{ route('adminOrderIndex') }}" method="get" class="filter-block">
                <input type="submit" name="clear" value="clear filters">
            </form>
        </nav>
        <div class="wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>product_id</th>
                        <th>user_id</th>
                        <th>count</th>
                        <th>price</th>
                        <th>delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td><a href="{{ route('adminProduct', $order->product_id) }}">{{ $order->product_id }}</a></td>
                            <td>
                                <form action="{{ route('userIndex') }}" method="get">
                                    <input class="admin-order_submit" type="submit" name="id" value="{{ $order->user_id }}">
                                </form>
                            </td>
                            <td>{{ $order->count }}</td>
                            <td>{{ $order->price }}</td>
                            <td>
                                <form action="{{ route('orderDelete', $order->id) }}" method="post">
                                    @csrf
                                    @method("delete")
                                    <input class="table-submit" type="submit" value="delete">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>