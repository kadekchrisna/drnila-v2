<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    public function attributes(){
        return $this->hasMany('App\ProductsAttribute','product_id');
    }
}
