<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $products = [];

    /**
    * description
    *
    * @return void
    **/
    public function add($product)
    {
       $this->products[] = $product;
    }

    /**
    * description
    *
    * @return 
    **/
    public function products()
    {
        return $this->products;
    }

    /**
    * @test
    *
    * @return void
    **/
    public function total()
    {
        // $total = 0;

        // foreach($this->products as $product){
        //     $total += $product->cost();
        // }
        // return $total;
        
        return array_reduce($this->products, fn($carry, $product)=> $carry += $product->cost());
    }


}
