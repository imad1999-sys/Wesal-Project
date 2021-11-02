<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pricing;

class PricingController extends Controller
{
    function getPricing()
    {
        return ['price'=> Pricing::all()];
    }
}
