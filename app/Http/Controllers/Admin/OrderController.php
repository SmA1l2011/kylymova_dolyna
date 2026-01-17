<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        if (isset($_GET["sortBy"])) {
            switch ($_GET["sortBy"]) {
                case "Ціна вниз":
                    $sortBy = "priceD";
                    break;

                case "Ціна вгору":
                    $sortBy = "priceU";
                    break;

                case "id товару":
                    $sortBy = "product_id";
                    break;

                case "кількість":
                    $sortBy = "count";
                    break;
                    
                case "Найдавніше":
                    $sortBy = "oldest";
                    break;

                default:
                    $sortBy = "newest";
                    break;
            }
        } else {
            $sortBy = "newest";
        }
        $filters = [];
        foreach ($_GET as $key => $value) {
            $filters[$key] = $value;
        }
        $allUsers = User::getAllUsers();
        $allOrders = Order::getAllOrders($sortBy, $filters);
        return view("admin/orders/index", compact("allOrders", "allUsers"));
    }

    public function delete($id)
    {
        Order::orderDelete($id);
        return back();
    }
}
