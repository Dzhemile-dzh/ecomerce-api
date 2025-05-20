<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="Product management"
 * )
 * @OA\PathItem(path="/api/products")
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/products",
     *      summary="List products",
     *      tags={"Products"},
     *      @OA\Parameter(
     *          name="per_page",
     *          in="query",
     *          description="Items per page",
     *          @OA\Schema(type="integer", default=15)
     *      ),
     *      @OA\Parameter(
     *          name="category_id",
     *          in="query",
     *          description="Filter by category",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="min_price",
     *          in="query",
     *          description="Minimum price",
     *          @OA\Schema(type="number", format="float")
     *      ),
     *      @OA\Parameter(
     *          name="max_price",
     *          in="query",
     *          description="Maximum price",
     *          @OA\Schema(type="number", format="float")
     *      ),
     *      @OA\Parameter(
     *          name="sort_by",
     *          in="query",
     *          description="Column to sort by",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="sort_dir",
     *          in="query",
     *          description="Sort direction: asc or desc",
     *          @OA\Schema(type="string", default="asc")
     *      ),
     *      @OA\Response(response=200, description="OK")
     * )
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('sort_dir', 'asc'));
        }

        $products = $query->paginate($request->get('per_page', 15))->withQueryString();

        return ProductResource::collection($products);
    }

    /**
     * @OA\Post(
     *      path="/api/products",
     *      summary="Create a product",
     *      tags={"Products"},
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(required=true),
     *      @OA\Response(response=201, description="Created"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/products/{id}",
     *      summary="Show product",
     *      tags={"Products"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="OK"),
     *      @OA\Response(response=404, description="Not Found")
     * )
     */
    public function show(Product $product)
    {
        $product->load('category');

        return new ProductResource($product);
    }

    /**
     * @OA\Put(
     *      path="/api/products/{id}",
     *      summary="Update product",
     *      tags={"Products"},
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(required=true),
     *      @OA\Response(response=200, description="Updated"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=404, description="Not Found")
     * )
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return new ProductResource($product);
    }

    /**
     * @OA\Delete(
     *      path="/api/products/{id}",
     *      summary="Delete product",
     *      tags={"Products"},
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=204, description="No Content"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=404, description="Not Found")
     * )
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
