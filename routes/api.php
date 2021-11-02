<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\OrderTypeController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\AdminController;
//customer
Route::post('/customerRegister' , [CustomerController::class , 'register']);
Route::post('/customerLoging', [CustomerController::class, 'login']);
Route::get("/allCustomers" , [CustomerController::class , 'displayAllCustomers']);
Route::get("/customer/{id}" , [CustomerController::class , 'displayCustomerById']);
Route::get("/newCustomers" , [CustomerController::class , 'displayNewCustomers']);
Route::put("/updateCustomer/{id}" , [CustomerController::class , 'updateCustomer']);


//order
Route::get("/getOrderById/{id}",[OrderController::class , 'getOrderById']);
Route::put("/updateOrder/{id}" , [OrderController::class , 'updateOrder']);
Route::post("/createOrder" , [OrderController::class , 'createOrder']);
Route::delete("/deleteOrder/{id}" , [OrderController::class , 'deleteOrderById']);
Route::get('/allOrders' , [OrderController::class , 'displayAllOrders']);
Route::get('/getOrderByCustomerId/{id}' , [OrderController::class , 'getOrderByCustomerId']);
Route::get("/newOrders" , [OrderController :: class , 'displayNewOrders'] );


// order status
Route::post("/createOrderStatus" , [OrderStatusController::class , 'createOrderStatus']);
Route::get("/orderStatus" , [OrderStatusController::class , 'displayAllOrderStatuses']);
Route::delete('/deleteOrderStatus/{id}' , [OrderStatusController::class , 'deleteOrderStatusById']);
Route::put("/updateOrderStatus/{id}",[OrderStatusController::class , 'updateOrderStatusById']);


//order type
Route::post("/createOrderType" , [OrderTypeController::class , 'create']);
Route::get("/orderType" , [OrderTypeController::class , 'displayAllOrderTypes']);
Route::delete('/deleteOrderType/{id}' , [OrderTypeController::class , 'deleteOrderTypeById']);
Route::put("/updateOrderType/{id}",[OrderTypeController::class , 'updateOrderTypeById']);


//pricing
Route::get("/getPricing" , [PricingController::class , 'getPricing']);


//version
Route::post("/getVersion" , [VersionController::class , 'getVersion']);

//admins
Route::post("/adminRegister" , [AdminController::class , 'register']);
Route::post("/adminLoging" , [AdminController::class , 'login']);
Route::get("/allAdmins" , [AdminController::class , 'displayAllAdmins']);

Route::post("/orderResponse" , [OrderController::class , 'orderResponse']);

//notification
Route::post("/notification" , [NotificationController::class , 'send']);


Route::group(['prefix'=>'paypal'], function(){
    Route::post('/order/create',[\App\Http\Controllers\PaypalController::class,'create']);
    Route::post('/order/capture/',[\App\Http\Controllers\PaypalController::class,'capture']);
});
