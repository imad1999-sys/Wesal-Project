<?php

namespace App\Http\Controllers;

use App\Models\OrderStatuses;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    function createOrderStatus(Request $request)
    {
        $orderStatus = new OrderStatuses;
        $orderStatus->name = $request->input('name');
        $orderStatus->save();
        return $request->input();
    }
    function displayAllOrderStatuses()
    {
        return OrderStatuses::all();
    }
    function deleteOrderStatusById($id)
    {
        $result = OrderStatuses::where('id', $id)->delete();
        if ($result) {
            return ["result" => "order status has been deleted"];
        } else {
            return ["result" => "operation failed"];
        }
    }
    function updateOrderStatusById($id , Request $request)
    {
        $orderStatus = OrderStatuses::find($id);
        $orderStatus->name = $request->input('name');
        $orderStatus->save();
        return $orderStatus;
    }
}
