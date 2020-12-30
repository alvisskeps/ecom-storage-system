<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductsController extends Controller
{
    /**
     * @return Application|ResponseFactory|Response
     */
    public function getAllProducts()
    {
        $products = Product::get()->toJson(JSON_PRETTY_PRINT);
        return response($products, 200);
    }

    /**
     * @param int $id
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function getProduct(int $id)
    {
        if (Product::where('id', $id)->exists()) {
            $product = Product::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);

            return response($product, 200);
        } else {
            return response()->json([
                'message' => 'product not found'
            ], 404);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createProduct(Request $request) {
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->amount = $request->amount;
        $product->save();

        return response()->json([
            'message' => 'Product record created'
        ], 201);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateProduct(Request $request, int $id) {
        if (Product::where('id', $id)->exists()) {
            $product = Product::find($id);

            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->amount = $request->amount;
            $product->save();

            return response()->json([
                'message' => 'Product updated successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteProduct(int $id) {
        if (Product::where('id', $id)->exists()) {
            $product = Product::find($id);
            $product->delete();

            return response()->json([
                'message' => 'Product has been deleted'
            ], 202);
        } else {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
    }

    public function getProductAmount(int $id)
    {
        if (Product::where('id', $id)->exists()) {
            $amount = Product::where('id', $id)->value('amount');

            return response($amount, 200);
        } else {
            return response()->json([
                'message' => 'product not found'
            ], 404);
        }
    }
}
