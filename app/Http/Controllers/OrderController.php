<?php

namespace App\Http\Controllers;

use App\Models\OrderResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Orders;
use App\Models\Pricing;
use App\Models\OrderTypes;
use Carbon\Carbon;
use DateTime;
class OrderController extends Controller
{
    //
    function createOrder(Request $request)
    {
        date_default_timezone_set("Asia/Damascus");
        $dt = new DateTime(Carbon::now()->toDateTimeString());
        $order = new Orders;
        $order->customer_id = $request->input('customer_id');
        $order->beneficiary_no = $request->input('beneficiary_no');
        $order->status = 'قيد معالجة الطلب';
        $order->country = $request->input('country');
        $order->type_id = $request->input('type_id');
        $order->price_id = $request->input('price_id');
        $order->send_message = $request->input('send_message');

        $order->paymentmethod_id = $request->input('paymentmethod_id');
        $order->on_time = $dt->format('H:i:s');
        $order->save();
        $ordertype = OrderTypes::where('id', $order->type_id)->get();
        $price = Pricing::where('id', $order->price_id)->get();
        return  ['order' => $order, 'price' => $price, 'order type' => $ordertype];
    }
    function displayAllOrders(){
        $data =  Orders::join('pricings', 'pricings.id', '=', 'Orders.price_id')
            ->join('Order_Types', 'Order_Types.id', '=', 'Orders.type_id')
            ->join('customers', 'customers.id', '=', 'Orders.customer_id')
            ->join('order_responses', 'order_responses.order_id', '=', 'Orders.id')
            ->get(['Orders.*', 'pricings.units', 'pricings.price_in_eur', 'pricings.price_in_usd', 'Order_Types.name', 'customers.first_name', 'customers.last_name' , 'order_responses.result']);
        return $data;
    }
    function deleteOrderById($id){
        $result = Orders::where('id' , $id)->delete();
        if($result){
            return ["result" => "order has been deleted"];
        }else{
            return ["result" => "operation failed"];
        }
    }
    function getOrderById($id){
        $data =  Orders::join('pricings', 'pricings.id', '=', 'Orders.price_id')
            ->join('Order_Types', 'Order_Types.id', '=', 'Orders.type_id')
            ->join('customers', 'customers.id', '=', 'Orders.customer_id')
            ->join('order_responses', 'order_responses.order_id', '=', 'Orders.id')
            ->where('Orders.id',  $id)
            ->get(['Orders.*', 'pricings.units', 'pricings.price_in_eur', 'pricings.price_in_usd', 'Order_Types.name', 'customers.first_name', 'customers.last_name','order_responses.result']);
        return ['orders' => $data];
    }
    function getOrderByCustomerId($customerId){

        $data =  DB::table('Orders')->join('pricings', 'Orders.price_id', '=', 'pricings.id')
            ->join('Order_Types', 'Orders.type_id', '=', 'Order_Types.id')
            ->join('order_responses', 'order_responses.order_id', '=', 'Orders.id')
            ->where('Orders.customer_id',  $customerId)
            ->get(['Orders.*', 'pricings.units', 'pricings.units', 'pricings.price_in_eur', 'pricings.price_in_usd', 'Order_Types.name', 'order_responses.result']);
        return ['order' => $data];
    }
    function updateOrder($id , Request $request){
		date_default_timezone_set("Asia/Damascus");
		$dt = new DateTime(Carbon::now()->toDateTimeString());
        $order = Orders::find($id);
        $order->customer_id = $request->input('customer_id');
        $order->country = $request->input('country');
        $order->type_id = $request->input('type_id');
        $order->price_id = $request->input('price_id');
        $order->send_message = $request->input('send_message');
        $order->status = $request->input('status');
        $order->paymentmethod_id = $request->input('paymentmethod_id');
		$order->updated_at = $dt->format('H:i:s');
        $start = Carbon::parse($order->updated_at);
        $end = Carbon::parse($order->on_time);
        $duration = $end->diffInMinutes($start);
        $order->waiting_time = $duration;
        $order->save();
        return $order;
    }
    function orderResponse(Request $request)
    {
        $order = new OrderResponse();
        $order->order_id = $request->input('order_id');
        $order->payment_method = $request->input('payment_method');
        $order->result = $request->input('result');
        $order->save();
        return ['result' => true];
    }
	  public function displayNewOrders()
    {
        $myTime = Carbon::now();
        $order = Orders::join('pricings', 'pricings.id', '=', 'Orders.price_id')
            ->join('Order_Types', 'Order_Types.id', '=', 'Orders.type_id')
            ->join('customers', 'customers.id', '=', 'Orders.customer_id')
            ->join('order_responses', 'order_responses.order_id', '=', 'Orders.id')
            ->where("Orders.created_at", substr($myTime, 0, 10))
            ->get(['Orders.*', 'pricings.units', 'pricings.price_in_eur', 'pricings.price_in_usd', 'Order_Types.name', 'customers.first_name', 'customers.last_name', 'order_responses.result']);
        return $order;
    }
}
