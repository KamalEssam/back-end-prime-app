<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\WebController;
use App\Http\Repositories\AdsRepository;
use App\Http\Requests\AdsRequest;
use DB;

class AdsController extends WebController
{

    public $adsRepo;

    public function __construct(AdsRepository $adsRepository)
    {
        $this->adsRepo = $adsRepository;
    }

    /**
     *  list all ads we have got
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $ads = $this->adsRepo->all();
        return view('admin.ads.index', compact('ads'));
    }

    /**
     *  create new ad
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.ads.create');
    }

    /**
     *  store the new ad
     *
     * @param AdsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(AdsRequest $request)
    {
        // add Category
        DB::beginTransaction();
        try {
            $ad = $this->adsRepo->createAd($request);
            if ($ad) {
                DB::commit();
            } else {
                DB::rollback();
                // log error
                return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.ad_add_err'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            // log error
            self::logErr($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.ad_add_err'));
        }
        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.ad_add_ok'), 'ads.index');
    }

    /**
     *  get one ad to edit
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $ad = $this->adsRepo->getAdById($id);
        if ($ad) {
            return view('admin.ads.edit', compact('ad'));
        }
        return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.ad-not-found'));
    }

    /**
     * Update the category
     *
     * @param AdsRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(AdsRequest $request, $id)
    {
        $ad = $this->adsRepo->getAdById($id);
        if (!$ad) {
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.ad-not-found'));
        }

        DB::beginTransaction();
        // update category data
        try {
            $this->adsRepo->update($ad, $request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // log error
            self::logErr($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.ad_edit_err'));
        }
        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.ad_edit_ok'), 'ads.index');
    }

    /**
     * get Ads Api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAdsApi()
    {
        return ApiController::jsonResponse(self::STATUS_OK, 20, trans('admin.ads'), '', $this->adsRepo->getAdsApi());
    }

    /**
     * Remove the ad
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->deleteItem($this->adsRepo->ad, $id);
    }
}
