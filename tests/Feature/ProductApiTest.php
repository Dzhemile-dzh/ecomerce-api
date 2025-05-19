<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;

class ProductApiTest extends TestCase
{
    public function test_guest_can_list_products()
    {
        Category::factory()->hasProducts(5)->create();
        $res = $this->getJson('/api/products');
        $res->assertStatus(200)
            ->assertJsonStructure(['data','links','meta']);
    }

    public function test_authenticated_user_can_create_product()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $cat = Category::factory()->create();
        $payload = [
            'category_id'   => $cat->id,
            'name'          => 'Test',
            'description'   => 'Desc',
            'price'         => 9.99,
            'stock_quantity'=> 10,
        ];
        $this->postJson('/api/products', $payload)
             ->assertStatus(201)
             ->assertJsonFragment(['name'=>'Test']);
    }
}
