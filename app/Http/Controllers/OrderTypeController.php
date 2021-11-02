<?php

namespace App\Http\Controllers;

use App\Models\OrderTypes;
use Illuminate\Http\Request;

class OrderTypeController extends Controller
{
    function create(Request $request)
    {
        $orderType = new OrderTypes;
        $orderType->name = $request->input('name');
        $orderType->save();
        return $request->input();
    }
    function displayAllOrderTypes()
    {
        return['ordertype' =>OrderTypes::all()];
    }
    function deleteOrderTypeById($id)
    {
        $result = OrderTypes::where('id', $id)->delete();
        if ($result) {
            return ["result" => "order type has been deleted"];
        } else {
            return ["result" => "operation failed"];
        }
    }
    function updateOrderTypeById($id , Request $request)
    {
        $orderType = OrderTypes::find($id);
        $orderType->name = $request->input('name');
        $orderType->save();
        return $orderType;
    }
}
