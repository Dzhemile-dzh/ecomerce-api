<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Categories",
 *     description="Category management"
 * )
 * @OA\PathItem(path="/api/categories")
 */
class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/categories",
     *      summary="List categories",
     *      tags={"Categories"},
     *      @OA\Parameter(
     *          name="per_page",
     *          in="query",
     *          description="Items per page",
     *          @OA\Schema(type="integer", default=15)
     *      ),
     *      @OA\Response(response=200, description="OK")
     * )
     */
    public function index(Request $request)
    {
        $categories = Category::paginate($request->get('per_page', 15))->withQueryString();

        return CategoryResource::collection($categories);
    }

    /**
     * @OA\Post(
     *      path="/api/categories",
     *      summary="Create category",
     *      tags={"Categories"},
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(required=true),
     *      @OA\Response(response=201, description="Created"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/categories/{id}",
     *      summary="Show category",
     *      tags={"Categories"},
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
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * @OA\Put(
     *      path="/api/categories/{id}",
     *      summary="Update category",
     *      tags={"Categories"},
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
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return new CategoryResource($category);
    }

    /**
     * @OA\Delete(
     *      path="/api/categories/{id}",
     *      summary="Delete category",
     *      tags={"Categories"},
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
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
