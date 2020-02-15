<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Traits\MailTrait;
use App\Models\Order;
use App\Models\Permission;
use DB;
use Illuminate\Http\Request;
use Validator;

class HomeController extends ApiController
{
    use MailTrait;

    public function __construct(Request $request)
    {
        $this->setLang($request);
    }

    /**
     *  get list of categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories()
    {
        $categories = (new CategoryRepository())->getCategoriesApi();
        if (!$categories) {
            return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('admin.category_not_found'), '', '');
        }
        return self::jsonResponse(true, self::CODE_OK, trans('admin.categories'), '', $categories);
    }

    /**
     *  get list of products
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function products(Request $request)
    {
        $categories = (new ProductRepository())->getProductsApi($request);

        if (!$categories) {
            return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('admin.product_not_found'), '', '');
        }

        return self::jsonResponse(true, self::CODE_OK, trans('admin.products'), '', $categories);
    }


    /**
     *  get product details
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function productDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric|exists:products,id'
        ]);

        // raise errors if validation errors ..
        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.validation_err'), $validator->errors());
        }


        $product = (new ProductRepository())->getProductDetails($request->get('product_id'));
        if (!$product) {
            return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('admin.product_not_found'), '', '');
        }

        return self::jsonResponse(true, self::CODE_OK, trans('admin.product'), '', $product);
    }


    /**
     *  create new order
     *
     * @param Request $request
     * @return Request
     * @throws \Throwable
     */
    public function createOrder(Request $request)
    {

        $auth = auth()->guard('api')->user();

        $is_sale = 0;

        // check if user exists
        if ($auth) {
            $validator = Validator::make($request->all(), [
                'orders' => 'required'
            ]);
            $name = $auth->name;
            $email = $auth->email;
            $mobile = $auth->mobile;
            $is_sale = $auth->role_id == self::ROLE_SALE ? 1 : 0;
        } else {
            $validator = Validator::make($request->all(), [
                'orders' => 'required',
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required',
            ]);
            $name = $request->get('name');
            $email = $request->get('email');
            $mobile = $request->get('mobile');
        }

        // raise errors if validation errors ..
        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.validation_err'), $validator->errors());
        }

        DB::beginTransaction();
        try {
            $the_order = Order::create([
                'name' => $name,
                'email' => $email,
                'mobile' => $mobile,
                'status' => 0,
                'is_sale' => $is_sale
            ]);

            // add the order
            foreach ($request['orders'] as $order) {
                $the_order->products()->attach($order['id'], ['quantity' => $order['qty']]);
            }

            // Send Email to the Premi management
            // send activation link to the user
            $data = [
                'view' => 'emails.requestAlert',
                'subject' => 'new order',
                'to' => 'm.fathy@rkanjel.com',
                'name' => $name,
                'id' => $the_order->id,
            ];

            $this->sendMailTraitFun($data);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            DB::rollBack();
            return self::jsonResponse(false, self::CODE_INTERNAL_ERR, trans('api.internal_err'), $validator->errors());

        }

        DB::commit();
        // if ok send an empty class
        return self::jsonResponse(true, self::CODE_OK, trans('api.order-sent-successfully'));
    }


    /**
     *  permissions of users to see or not to see (price or quality)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function splash(Request $request)
    {
        $permissions = Permission::select('column', 'is_visible')->pluck('is_visible', 'column');

        if (!$permissions) {
            return self::jsonResponse(false, self::CODE_INTERNAL_ERR, trans('api.internal_err'));
        }
        return self::jsonResponse(true, self::CODE_OK, '', '', $permissions);
    }
}
