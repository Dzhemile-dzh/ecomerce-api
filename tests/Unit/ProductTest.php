<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class ProductTest extends TestCase
{
    public function test_product_belongs_to_category()
    {
        $cat = Category::factory()->create();
        $prod = Product::factory()->create(['category_id' => $cat->id]);

        $this->assertTrue($prod->category->is($cat));
    }
}
