<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VersionController extends Controller
{
  public function  getVersion(Request $request){
    $this->validate($request, ['token' => 'required|string']);

    $token= $request->input('token');
      return response()->json([ "android-version"=> "1",
      "android-link"=>"1",
      "ios-version"=>"1",
      "ios-link"=>"1"]);
  }
}
