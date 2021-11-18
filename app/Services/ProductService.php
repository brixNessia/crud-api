<?php

namespace App\Services;

use DB;
use Exception;
use App\Models\Product;
use Carbon\Carbon;

class ProductService
{
    /**
     * @var App\Models\Product
     */
    protected $product;

    /**
     * ProductsService constructor.
     *
     * @param App\Models\Product $product
     */
    public function __construct( Product $product ) {
        $this->product = $product;
    }

    public function create(array $params)
    {
        DB::beginTransaction();

        try {
            $product = $this->product->create($params);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        return $product;
    }

    public function update(array $params)
    {
        DB::beginTransaction();

        try {
            $products = $this->product->where('id',$params['id'])->first();
            // update table data
            $products->update($params);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }

        return $products;
    }

    public function delete(int $id): bool
    {
        DB::beginTransaction();

        try {
            $products = $this->product->where('id',$id)->first();
            $products->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }

        return true;
    }

    public function all()
    {
        $product = $this->product->all();

        return $product->toArray();
    }
}
