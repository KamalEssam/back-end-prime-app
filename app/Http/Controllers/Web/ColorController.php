<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use App\Http\Repositories\ColorRepository;
use App\Http\Requests\ColorRequest;
use DB;

class ColorController extends WebController
{

    public $colorRepo;

    public function __construct(ColorRepository $colorRepository)
    {
        $this->colorRepo = $colorRepository;
    }

    /**
     *  list all colors we have got
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $colors = $this->colorRepo->all();
        return view('admin.colors.index', compact('colors'));
    }

    /**
     *  create new color
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     *  store the new color
     *
     * @param ColorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(ColorRequest $request)
    {
        // add Color
        DB::beginTransaction();
        try {
            $color = $this->colorRepo->createColor($request);
            if ($color) {
                DB::commit();
            } else {
                DB::rollback();
                // log error
                return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.color_add_err'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            // log error
            self::logErr($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.color_add_err'));
        }

        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.color_add_ok'), 'colors.index');
    }

    /**
     *  get one color to edit
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $color = $this->colorRepo->getColorById($id);
        if ($color) {
            return view('admin.colors.edit', compact('color'));
        }
        return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.color_not_found'));
    }

    /**
     * Update the color
     *
     * @param ColorRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(ColorRequest $request, $id)
    {

        $color = $this->colorRepo->getColorById($id);
        if (!$color) {
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.color_not_found'));
        }

        DB::beginTransaction();
        // update color data
        try {
            $this->colorRepo->update($color, $request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // log error
            self::logErr($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.color_edit_err'));
        }
        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.color_edit_ok'), 'colors.index');
    }

    /**
     * Remove the color
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->deleteItem($this->colorRepo->color, $id);
    }
}
