<?php

namespace App\Http\Controllers\Site;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        if (Session::get("orders") !== null) {
            $count = key(Session::get("orders"));
            $orderProduct = Product::getAllProducts("id", [], Session::get("orders"));
        } else {
            $count = null;
            $orderProduct = [];
        }
        $sumPrice = 0;
        $allOrders = Order::getAllOrders();
        return view("site/orders/index", compact("allOrders", "orderProduct", "count", "sumPrice"));
    }

    public function store(OrderRequest $request)
    {
        $orders = Session::get("orders");
        if ($request->validated("order") !== null) {
            foreach ($orders as $key => $order) {
                if (auth()->user() == null) {
                    $data = [
                        "product_id" => $order[0],
                        "user_id" => NULL,
                        "user_info" => $request->validated("user_info"),
                        "count" => $order[1],
                        "price" => ($order[2] * $order[1]),
                        "created_at" => now(),
                        "updated_at" => now(),
                    ];
                } else {
                    $data = [
                        "product_id" => $order[0],
                        "user_id" => auth()->user()->id,
                        "user_info" => NULL,
                        "count" => $order[1],
                        "price" => ($order[2] * $order[1]),
                        "created_at" => now(),
                        "updated_at" => now(),
                    ];
                }
                Order::ordersCreate($data);
            }
        }

        $message = "нове замовлення, контактна інформація: " . $request->validated("user_info");
        $token = "6869369349:AAGc0XqU9uwzs2g7WeOFgk2lM7znV9KcSjc";
        $id = "5192419572";
        $message = urlencode("$message");
        $urlQuery = "https://api.telegram.org/bot$token/sendMessage?chat_id=$id&text=$message";

        $result = file_get_contents($urlQuery);
        Session::forget("orders");
        Session::put("is_order", true);
        return to_route("orderIndex");
    }

    public function storeApply(Request $request)
    {
        $orders = Session::get("orders");
        if ($request->post("id") !== null) {
            if ($request->post("count") == null || $request->post("count") < 0) {
                $orders[$request->post("id")][1] = 1;
            } else {
                if ($request->post("plus") !== null) {
                    $orders[$request->post("id")][1] = $request->post("count") + 1;
                } elseif ($request->post("minus") !== null) {
                    $orders[$request->post("id")][1] = $request->post("count") - 1;
                } else {
                    $orders[$request->post("id")][1] = $request->post("count");
                }
            }
        }
        if ($request->post("delete") !== null) {
            foreach ($orders as $key => $order) {
                if ($order[0] == $request->post("product_id")) {
                    unset($orders[$key]);
                    break;
                }
            }
        }
        if (!empty($orders)) {
            Session::put("orders", $orders);
        } else {
            Session::forget("orders");
        }
        return to_route("orderIndex");
    }
}
