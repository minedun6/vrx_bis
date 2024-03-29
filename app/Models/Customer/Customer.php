<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address'];
}
