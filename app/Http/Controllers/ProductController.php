<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Submodules\PhpHelpers\Traits\ApiResponse;

class ProductController extends Controller
{
  use ApiResponse;

  public function index()
  {
    try {
      return $this->successResponse(Product::all());
    } catch (\Throwable $th) {
      return $this->errorResponse($th->getMessage());
    }
  }

  public function store(ProductRequest $request)
  {
    try {
      DB::beginTransaction();
      Product::create($request->all());
      DB::commit();
      return $this->successResponse([]);
    } catch (\Throwable $th) {
      DB::rollBack();
      return $this->errorResponse($th->getMessage());
    }
  }

  public function show(Product $product)
  {
    try {
      return $this->successResponse($product->toArray());
    } catch (\Throwable $th) {
      return $this->errorResponse($th->getMessage());
    }
  }

  public function update(ProductRequest $request, Product $product)
  {
    try {
      DB::beginTransaction();
      $product->update($request->all());
      DB::commit();
      return $this->successResponse([]);
    } catch (\Throwable $th) {
      DB::rollBack();
      return $this->errorResponse($th->getMessage());
    }
  }

  public function destroy(Product $product) {
    try {
      DB::beginTransaction();
      $product->delete();
      DB::commit();
      return $this->successResponse([]);
    } catch (\Throwable $th) {
      DB::rollBack();
      return $this->errorResponse($th->getMessage());
    }
  }
}
