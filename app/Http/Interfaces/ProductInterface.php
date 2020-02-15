<?php


namespace App\Http\Interfaces;


use Illuminate\Http\Request;

interface ProductInterface
{

    /**
     *  get all products
     *
     * @param $request
     * @return mixed
     */
    public function all($request);


    /**
     *  get count of all products
     *
     * @return mixed
     */
    public function count();

    /**
     *  add product
     *
     * @param $request
     * @return mixed
     */
    public function createProduct($request);


    /**
     *  update product
     *
     * @param $product
     * @param $request
     * @return mixed
     */
    public function update($product, $request);


    /**
     *  get product by id
     *
     * @param $id
     * @return mixed
     */
    public function getProductById($id);

    /**
     *  get list of products by Api
     *
     * @param $request
     * @return mixed
     */
    public function getProductsApi($request);

    /**
     * @return mixed
     */
    public function getProductsList();
}
