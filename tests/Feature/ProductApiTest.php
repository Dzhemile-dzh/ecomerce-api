<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;

class ProductApiTest extends TestCase
{
    public function test_guest_can_list_products(): void
    {
        Category::factory()->hasProducts(5)->create();

        $this->getJson('/api/products')
             ->assertStatus(200)
             ->assertJsonStructure(['data','links','meta']);
    }

    public function test_guest_can_show_product(): void
    {
        $product = Product::factory()->create();

        $this->getJson("/api/products/{$product->id}")
             ->assertStatus(200)
             ->assertJsonFragment(['id' => $product->id]);
    }

    public function test_guest_cannot_create_product(): void
    {
        $cat = Category::factory()->create();

        $payload = [
            'category_id'    => $cat->id,
            'name'           => 'Test',
            'description'    => 'Desc',
            'price'          => 9.99,
            'stock_quantity' => 10,
        ];

        $this->postJson('/api/products', $payload)
             ->assertStatus(401);          // unauthenticated
    }

    public function test_guest_cannot_update_product(): void
    {
        $product = Product::factory()->create();

        $this->putJson("/api/products/{$product->id}", ['name' => 'X'])
             ->assertStatus(401);
    }

    public function test_guest_cannot_delete_product(): void
    {
        $product = Product::factory()->create();

        $this->deleteJson("/api/products/{$product->id}")
             ->assertStatus(401);
    }


    public function test_user_cannot_create_product(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);

        $cat = Category::factory()->create();

        $payload = [
            'category_id'    => $cat->id,
            'name'           => 'Test',
            'description'    => 'Desc',
            'price'          => 9.99,
            'stock_quantity' => 10,
        ];

        $this->postJson('/api/products', $payload)
             ->assertStatus(403);          // forbidden
    }

    public function test_user_cannot_update_product(): void
    {
        $user    = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);

        $product = Product::factory()->create();

        $this->putJson("/api/products/{$product->id}", ['name' => 'X'])
             ->assertStatus(403);
    }
}