<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
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

    public function test_guest_cannot_create_product()
    {
        $cat = Category::factory()->create();
        $payload = [
            'category_id'   => $cat->id,
            'name'          => 'Test',
            'description'   => 'Desc',
            'price'         => 9.99,
            'stock_quantity'=> 10,
        ];
        $this->postJson('/api/products', $payload)
             ->assertStatus(401);
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
             ->assertJsonFragment(['name' => 'Test']);
             
    }

    public function test_guest_can_show_product()
    {
        $product = Product::factory()->create();
        $this->getJson("/api/products/{$product->id}")
             ->assertStatus(200)
             ->assertJsonFragment(['id' => $product->id]);
    }

    public function test_authenticated_user_can_update_product()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $product = Product::factory()->create([
            'name' => 'Old Name',
            'price'=> 5.00,
        ]);

        $payload = ['name' => 'New Name', 'price' => 7.50];
        $this->putJson("/api/products/{$product->id}", $payload)
             ->assertStatus(200)
             ->assertJsonFragment(['name' => 'New Name','price' => 7.50]);
    }

    public function test_guest_cannot_update_product()
    {
        $product = Product::factory()->create();
        $this->putJson("/api/products/{$product->id}", ['name'=>'X'])
             ->assertStatus(401);
    }

    public function test_authenticated_user_can_delete_product()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $product = Product::factory()->create();
        $this->deleteJson("/api/products/{$product->id}")
             ->assertStatus(204);

        $this->getJson("/api/products/{$product->id}")
             ->assertStatus(404);
    }

    public function test_guest_cannot_delete_product()
    {
        $product = Product::factory()->create();
        $this->deleteJson("/api/products/{$product->id}")
             ->assertStatus(401);
    }

}
