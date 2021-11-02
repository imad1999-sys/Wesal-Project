<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Customers;
use Illuminate\Support\Facades\Hash;
class CustomerController extends Controller
{

    public function register(Request $req)
    {
        $customer =new Customers();
        $this->validate($req, [
            'first_name' => 'required|string', 'last_name' => 'required|string', 'email' => 'required|string',
            'phone' => 'required|string', 'birthday' => 'required|string', 'country' => 'required|string',
            'gender' => 'required|string', 'password' => 'required|string'
        ]);

        $customer->first_name = $req->input('first_name');
        $customer->last_name = $req->input('last_name');

        $customer->phone = $req->input('phone');
        $customer->birthday = $req->input('birthday');
        $customer->country = $req->input('country');
        $customer->gender = $req->input('gender');
        $customer->password = Hash::make($req->input('password'));
        $customer->email = $req->input('email');
        try{
            $customer->save();
            }
            catch(\Exception $e)
            {
                return response()->json(['msg'=>'Email is founded']);
            }


        $token = $customer->createToken('my-app-token')->plainTextToken;

        $response = [
            'customer' => $customer,
            'token' => $token,
            'id' => $customer->id
        ];


        return self::getResponse(true , "Customer has been Registerd" , $response , 200 );




    }


    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $customer =new Customers();

        $customer = customers::where('email', $request->email)->first();
        if (!$customer || !Hash::check($request->password, $customer->password)) {
           return self::getResponse(false , "error email or password" , null , 401 );
        }

        $token = $customer->createToken('my-app-token')->plainTextToken;

        $response = [
            'customer' => $customer,
            'token' => $token,
            'id' => $customer->id
        ];

        return self::getResponse(true , "You are logged in" ,  $response , 200);
    }
	    public function displayAllCustomers(){
        return Customers::all();
    }
    public function displayCustomerById($id){
$data =  Customers::find($id);
		return $data;
    }
    public function displayNewCustomers(){
 $myTime = Carbon::now();

        return Customers::where("Customers.created_at" , substr($myTime,0,10))->get(["customers.*"]);
    }
	    public function updateCustomer(Request $req , $id)
    {
        $customer = Customers::find($id);
        $customer->first_name = $req->input('first_name');
        $customer->last_name = $req->input('last_name');
        $customer->email = $req->input('email');
        $customer->phone = $req->input('phone');
        $customer->birthday = $req->input('birthday');
        $customer->country = $req->input('country');
        $customer->gender = $req->input('gender');
        $customer->password = Hash::make($req->input('password'));
        $customer->save();
        return $customer;
    }
}
