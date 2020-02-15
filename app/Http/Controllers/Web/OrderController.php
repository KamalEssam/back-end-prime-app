<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use App\Models\Order;
use DB;
use Illuminate\Http\Request;
use Validator;

class OrderController extends WebController
{
    /**
     *  get list of orders sent by mobile application
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->orderBy('status', 'asc')
            ->orderBy('is_approved', 'asc')
            ->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     *  show client order details
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        // order
        $order = Order::find($id);

        // order products
        $order_products =
            DB::table('order_product')
                ->join('product_colors', 'product_colors.id', 'order_product.variant_id')
                ->join('products', 'products.id', 'product_colors.product_id')
                ->join('colors', 'colors.id', 'product_colors.color_id')
                ->where('order_product.order_id', '=', $id)
                ->select(
                    'products.id as id',
                    'products.en_name as name',
                    'products.unique_id',
                    'products.price as price',
                    'order_product.quantity',
                    'colors.en_name as color'
                )
                ->get();

        // update order status to be Read
        $order->status = 1;
        $order->update();
        $total = 0;
        return view('admin.orders.show', compact('order', 'order_products', 'total'));
    }


    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:orders,id',
            'status' => 'required|numeric|min:0|max:1'
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 404]);
        }

        try {
            if ($request->status == 0) {
                DB::table('orders')->where('id', $request->get('id'))->update([
                    'is_approved' => 2
                ]);
            } else {
                $result = $this->checkOrderVariantsExistances($request->get('id'));
                if ($result['status'] && !empty($result['products'])) {
                    return response()->json(['code' => 600, 'products' => $result['products']]);
                }
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return response()->json(['code' => 500]);
        }
        return response()->json(['code' => 200]);
    }

    /**
     *  check products existence
     *
     * @param $order_id
     * @return array
     * @throws \Exception
     */
    public function checkOrderVariantsExistances($order_id)
    {

        $result = ['status' => false, 'products' => []];

        $products = DB::table('order_product')->where('order_id', $order_id)->get();

        if (count($products) === 0) {
            return $result;
        }

        DB::beginTransaction();
        foreach ($products as $product) {
            $product_qty = DB::table('product_colors')
                ->join('products', 'products.id', 'product_colors.product_id')
                ->join('colors', 'colors.id', 'product_colors.color_id')
                ->where('product_colors.id', $product->variant_id)
                ->select('product_colors.*', 'products.en_name as product_name', 'colors.en_name as color_name')
                ->first();

            if ($product_qty) {
                if ($product_qty->quantity >= $product->quantity) {
                    $new_quantity = $product_qty->quantity - $product->quantity;
                    DB::table('product_colors')->where('id', $product->variant_id)->update([
                        'quantity' => $new_quantity
                    ]);
                } else {
                    $result['status'] = true;
                    $result['products'][] = [
                        'exists' => $product_qty->quantity,
                        'wants' => $product->quantity,
                        'product' => $product_qty->product_name,
                        'color' => $product_qty->color_name,
                    ];
                }
            }
        }

        if ($result['status']) {
            DB::rollBack();
            return $result;
        }
        DB::table('orders')->where('id', $order_id)->update([
            'is_approved' => 1
        ]);

        DB::commit();
        return $result;
    }
}
