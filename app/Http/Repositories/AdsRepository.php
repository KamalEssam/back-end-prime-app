<?php

namespace App\Http\Repositories;

use App\Models\Ad;

class AdsRepository extends BaseRepository
{
    public $ad;


    public function __construct()
    {
        $this->ad = new Ad();
    }

    /**
     *  get all ad
     *
     * @return mixed
     */
    public function all()
    {
        try {
            return $this->ad::all();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  add ad
     *
     * @param $request
     * @return mixed
     */
    public function createAd($request)
    {
        try {
            return $this->ad->create($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get ad by id
     *
     * @param $id
     * @return mixed
     */
    public function getAdById($id)
    {
        try {
            return $this->ad->find($id);
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }


    /**
     *  update ad
     *
     * @param $ad
     * @param $request
     * @return mixed
     */
    public function update($ad, $request)
    {
        try {
            return $ad->update($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }


    /**
     *  get list of ads by Api
     *
     * @return mixed
     */
    public function getAdsApi()
    {
        try {
            return $this->ad->orderBy('created_at', 'desc')->select('id', 'product_id', 'image')->get();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }
}
