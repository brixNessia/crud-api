<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /** @var App\Services\ProductService */
    protected $productService;

    /**
     * ProductController constructor.
     * 
     * @param App\Services\ProductService $productService
     * 
     */
    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $products = $this->productService->all();
            $this->response['data'] =  $products;
            $this->response['code'] = 200;
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'code'  => 500,
                'error' => $e->getMessage(),
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateProductRequest $request)
    {
        $request->validated();

        try {
            $formData = [
                'product_name'           => $request->getProductName(),
                'product_description'    => $request->getProductDescription(),
            ];
            $products = $this->productService->create($formData);
            $this->response['data'] = new ProductResource($products);
            $this->response['code'] = 200;
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'code'  => 500,
                'error' => $e->getMessage(),
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request)
    {
        $request->validated();
        try {
            $formData = [
                'id'                     => $request->getId(),
                'product_name'           => $request->getProductName(),
                'product_description'    => $request->getProductDescription(),
            ];
            $products = $this->productService->update($formData);
            $this->response['data'] = new ProductResource($products);
            $this->response['code'] = 200;
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'code'  => 500,
                'error' => $e->getMessage(),
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            // perform user delete
            $this->response['deleted'] = $this->productService->delete((int) $id);
            $this->response['code'] = 200;
        } catch (Exception $e) {
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        }

        return response()->json($this->response, $this->response['code']);
    }
}
