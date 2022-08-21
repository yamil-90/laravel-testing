<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Product;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function an_oder_contains_products()
    {
        $order = $this->createOrderWithProducts();

        $this->assertCount(2, $order->products());
    }

    /**
    * @test
    *
    * @return void
    **/
    public function an_order_can_calculate_the_total_cost_of_the_products()
    {
        $order = $this->createOrderWithProducts();

        $this->assertEquals(6, $order->total());
    }

    private function createOrderWithProducts()
    {
        $order = new Order;
        $product1 = new Product('batteries', 2);
        $product2 = new Product('spoon', 4);

        $order->add($product1);
        $order->add($product2);

        return $order;
    }
}
