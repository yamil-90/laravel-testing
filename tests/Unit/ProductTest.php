<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function a_product_has_a_name()
    {
        $name = 'first product';

        $product = new Product($name);

        $this->assertEquals($name, $product->name());
    }

    /**
     * @test
     *
     * @return void
     */
    public function a_product_has_a_cost()
    {

        $name = 'first product';
        $cost = 40;

        $product = new Product($name, $cost);

        $this->assertEquals($cost, $product->cost());
    }
    
}
