<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use App\Imports\ProductImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColors;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends WebController
{
    public $productRepo;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepo = $productRepository;
    }

    /**
     *  list all products we have got
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $category = null;
        if ($request->has('category') && is_numeric($request->get('category'))) {
            $category = (new CategoryRepository())->getCategoryById($request->get('category'));
        }
        $products = $this->productRepo->all($request);
        return view('admin.products.index', compact('products', 'category'));
    }

    /**
     *  create new products
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     *  store the new product
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(ProductRequest $request)
    {
        // add product
        DB::beginTransaction();
        try {
            $product = $this->productRepo->createProduct($request);
            if (!$product) {
                DB::rollback();
                // log error
                return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.product_add_err'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            // log error
            self::logErr($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.product_add_err'));
        }

        DB::commit();
        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.product_add_ok'), 'products.index');
    }

    /**
     *  get one product to edit
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $product = $this->productRepo->getProductById($id);
        if ($product) {
            return view('admin.products.edit', compact('product'));
        }
        return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.product'));
    }

    /**
     * Update the product
     *
     * @param ProductRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(ProductRequest $request, $id)
    {
        $product = $this->productRepo->getProductById($id);
        if (!$product) {
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.product_not_found'));
        }

        DB::beginTransaction();
        // update product data
        try {
            $this->productRepo->update($product, $request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // log error
            self::logErr($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.product_edit_err'));
        }
        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.product_edit_ok'), 'products.index');
    }

    /**
     * show product details
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        // check if found or not
        if (!$id) {
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.product_not_found'));
        }
        // get the product
        $product = Product::find($id);

        if (!$product) {
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.product_not_found'));
        }
        return view('admin.products.show', compact('product'));
    }


    /**
     * Remove the product
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->deleteItem($this->productRepo->product, $id);
    }

    /**
     * import data from excel
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        if (!$request['products']) {
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.product_not_found'));
        }

        try {
            Excel::import(new ProductImport(), $request['products']);
            return $this->messageAndRedirect(self::STATUS_OK, trans('admin.product_add_ok'), 'products.index');
        } catch (\Exception $e) {
            $e->getMessage();
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.product_not_found'));
        }
    }

    /**
     *  add new variant
     *
     * @param $product_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addVariant($product_id)
    {
        return view('admin.products.add_variant', ['product_id' => $product_id]);
    }

    public function StoreVariants(Request $request)
    {
        $product_id = $request['product_id'];

        if (!$product_id) {
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.product_not_found'));
        }

        $product = $this->productRepo->getProductById($product_id);
        if (!$product_id) {
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.product_not_found'));
        }

        if ($request['color'] && $request['quantity']) {
            // getting array of current services
            $product_colors = array_values(DB::table('product_colors')->where('product_id', $product_id)->select('color_id')->pluck('color_id')->toArray());
            $data = array();
            // get old services first
            for ($i = 0, $iMax = count($request['color']); $i < $iMax; $i++) {
                if (!in_array($request['color'][$i], $product_colors) && !empty($request['quantity'])) {
                    $data[] = array(
                        'color_id' => $request['color'][$i],
                        'quantity' => $request['quantity'][$i]
                    );
                }
            }
            if (count($data)) {
                try {
                    $product->colors()->attach($data);
                } catch (\Exception $e) {
                    $e->getMessage();
                }
            }
        }

        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.variant_add_ok'), 'products.index');
    }

    /**
     *  get list of all product variants
     *
     * @param $product_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getVariants($product_id)
    {
        $variants = DB::table('product_colors')
            ->leftJoin('colors', 'product_colors.color_id', 'colors.id')
            ->where('product_colors.product_id', $product_id)
            ->select('product_colors.id', 'colors.en_name as color', 'product_colors.quantity')->get();

        return view('admin.products.variants-list', compact('variants'));
    }

    /**
     *  get one variant of product
     *
     * @param $varaint_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getVariant($varaint_id)
    {
        $variant = DB::table('product_colors')
            ->leftJoin('colors', 'product_colors.color_id', 'colors.id')
            ->where('product_colors.id', $varaint_id)
            ->select('product_colors.id as id', 'colors.en_name as color', 'product_colors.quantity')->first();

        return view('admin.products.variant', ['variant' => $variant]);
    }

    /**
     *  delete product variant
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteVariant($id)
    {
        return $this->deleteItem(ProductColors::class, $id);
    }

    /**
     *  update variant
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateVaraint($id, Request $request)
    {
        $variant = $this->productRepo->getVaraintById($id);
        if (!$variant) {
            return response()->json(['status' => false]);
        }

        try {
            $this->productRepo->updateVaraintQuantity($id, $request['quantity']);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }

        return response()->json(['status' => true]);
    }
}







