<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Token;
use Illuminate\Http\Request;
use Validator;

class TokenController extends ApiController
{
    public function __construct(Request $request)
    {
        $this->setLang($request);
    }

    /**
     *  set token device in database
     *
     * @param Request $request
     * @return string
     */
    public function setToken(Request $request)
    {
        // Validation area
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'serial' => 'required',
        ]);

        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.validation_err'), $validator->errors(), '');

        }

        $auth = auth()->guard('api')->user();

        $user_id = null;
        if ($auth) {
            $user_id = $auth->id;
        }

        // Find token with the same platform
        $token = Token::where('serial', $request->serial)->where('user_id', $user_id)->first();

        if ($token) {
            $token->token = $request->token;
            $token->update();
        } else {
            try {
                $token = Token::create([
                    'token' => $request->token,
                    'serial' => $request->serial,
                    'user_id' => $user_id ?? null
                ]);
            } catch (\Exception $ex) {
                return self::jsonResponse(false, self::CODE_INTERNAL_ERR, trans('api.failed-to-create-token'));
            }
        }
        return self::jsonResponse(false, self::CODE_OK, trans('api.token-updated-successfully'), '', $token);

    }

    /**
     *  remove device token
     *
     * @param Request $request
     * @return mixed
     */
    public function removeToken(Request $request)
    {
        // Validation area
        $validator = Validator::make($request->all(), [
            'serial' => 'required',
        ]);


        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.validation_err'), $validator->errors(), '');
        }
        // Find token with the same platform
        $token = Token::where('serial', $request->serial)->first();

        if ($token) {
            $token->token = null;
            $token->update();
        }
        return self::jsonResponse(false, self::CODE_OK, trans('api.token-deleted-successfully'));
    }
}
