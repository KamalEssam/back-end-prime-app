<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class SettingController extends ApiController
{

    public function __construct(Request $request)
    {
        $this->setLang($request);
    }

    /**
     *  abouts us
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function about_us(Request $request)
    {
        $about_us = AboutUs::where('id', 1)->select('id', app()->getLocale() . '_about_us as about_us')->first();

        if (!$about_us) {
            return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('admin.about_us'), '', '');
        }

        return self::jsonResponse(true, self::CODE_OK, trans('admin.about_us'), '', $about_us);
    }
}
