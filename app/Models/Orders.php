<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
          'beneficiary_no',
          'status',
        'country',
        'type_id',
        'status_id',
        'price',
        'send_message',
        'paymentmethod_id',
    ];
}
