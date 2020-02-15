<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Repositories\UsersRepository;
use App\Http\Traits\MailTrait;
use App\Models\Permission;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Validator;

class AuthController extends ApiController
{

    use MailTrait;

    public function __construct(Request $request)
    {
        $this->setLang($request);
    }

    /**
     *  sign up new user
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function signUp(Request $request)
    {
        $permissions = Permission::select('column', 'is_visible')->pluck('is_visible', 'column');

        // validate fields
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|regex:/(01)[0-9]{9}/',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.failed-sign-up'), $validator->errors());
        }

        DB::beginTransaction();
        // create new user
        $request['role_id'] = self::ROLE_USER;
        $user = (new UsersRepository())->createUser($request);
        if ($user == false) {
            DB::rollBack();
            return self::jsonResponse(false, self::CODE_FAILED, trans('api.failed-sign-up'));
        }

        // create Token
        try {
            $token = $user->createToken('premi')->accessToken;   // create token
        } catch (\Exception $e) {
            DB::rollBack();
            self::logErr($e->getMessage());
            return self::jsonResponse(false, self::CODE_INTERNAL_ERR, [], $e->getMessage());
        }

        DB::commit();

        $user->permissions = $permissions;
        return self::jsonResponse(true, self::CODE_CREATED, trans('api.signup_success'), new \stdClass(), $user, $token);
    }

    /**
     *  login user to application
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function login(Request $request)
    {

        $permissions = Permission::select('column', 'is_visible')->pluck('is_visible', 'column');
        // get social register request data
        $types = [0 => 'facebook', 1 => 'google'];
        if ($request->has('social_id') && $request->has('type') && $request->get('type') != -1) {
            if (!in_array($request->type, [0, 1])) {
                return self::jsonResponse(false, self::CODE_FAILED, trans('api.we-accept-only-google-and-facebook'));
            }
            $column = $types[$request->type] . '_id';
            $user = (new UsersRepository())->getUserBySocial($request, $column);
            if ($user && in_array($user->role_id, [self::ROLE_USER, self::ROLE_SALE])) {
                $token = $user->createToken('rk-anjel')->accessToken;   // create token
                $user->permissions = $permissions;
                return self::jsonResponse(true, self::CODE_CREATED, trans('api.signup_success'), new \stdClass(), $user, $token);
            }
            $request[$column] = $request->get('social_id');
            // create social login
            unset($request['password']);
            $request['role_id'] = self::ROLE_USER;
            DB::beginTransaction();
            // create new user
            $user = (new UsersRepository())->createUser($request);
            if ($user == false) {
                DB::rollBack();
                return self::jsonResponse(false, self::CODE_FAILED, trans('api.failed-sign-up'));
            }
        } else {
            // validate fields
            $validator = Validator::make($request->all(), [
                'login' => 'required',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.failed-sign-up'), $validator->errors());
            }

            $login = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

            // login the user to the Application
            auth()->attempt([$login => request('login'), 'password' => request('password')]);
            $user = auth()->user();
            // Check if patient
            if (!$user || !in_array($user->role_id, [self::ROLE_USER, self::ROLE_SALE])) {
                return self::jsonResponse(false, self::CODE_FAILED, trans('api.wrong_combination'));
            }
        }

        // create Token
        try {
            $token = $user->createToken('premi')->accessToken;   // create token
        } catch (\Exception $e) {
            DB::rollBack();
            self::logErr($e->getMessage());
            return self::jsonResponse(false, self::CODE_INTERNAL_ERR, [], $e->getMessage());
        }
        $user->permissions = $permissions;
        return self::jsonResponse(true, self::CODE_OK, trans('api.login-success'), new \stdClass(), $user, $token);
    }

    /**
     *  edit profile
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function editProfile(Request $request)
    {
        $auth = auth()->guard('api')->user();
        if ($auth == null) {
            return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('api.unauthorized'));
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $auth->id,
            'mobile' => 'required|regex:/(01)[0-9]{9}/|unique:users,mobile,' . $auth->id,
        ]);

        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.failed-to-update-profile'), $validator->errors());
        }

        DB::beginTransaction();
        try {
            $auth->update($request->only(['name', 'email', 'mobile']));
        } catch (\Exception $e) {
            DB::rollBack();
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.failed-to-update-profile'), $validator->errors());
        }

        DB::commit();
        return self::jsonResponse(true, self::CODE_OK, trans('api.update-profile-success'), new \stdClass(), $auth);
    }


    /**
     *  change the password of the user
     *
     * @param Request $request
     * @return mixed
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('admin.edit'), $validator->errors());
        }

        $auth = $request->user();
        // check if user exists
        if (!$auth) {
            $validator->getMessageBag()->add('authorization', trans('api.unauthorized'));
            return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('api.unauthorized'), $validator->errors());
        }

        // if user exists then check the old password
        if ($auth != null) {
            // check old password
            if (!password_verify($request['old_password'], $auth->password)) {
                $validator->getMessageBag()->add('error', trans('api.old-password-wrong'));
                return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('api.old-password-wrong'), $validator->errors());
            }

            // change the password to the new one
            $auth->password = $request['new_password'];
            $auth->save();


            return self::jsonResponse(true, self::CODE_OK, trans('api.update-profile-success'), new \stdClass(), $auth);
        }
        return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('api.unauthorized'), '');
    }

    /**
     *  switch notifications api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function switchNotification(Request $request)
    {
        $auth = auth()->guard('api')->user();
        if ($auth == null) {
            return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('api.unauthorized'));
        }

        $validator = Validator::make($request->all(), [
            'switch-notification' => 'required|numeric|in:0,1',
        ]);

        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.not_found'), $validator->errors());
        }

        DB::beginTransaction();
        try {
            $auth->update([
                'is_notification' => $request['switch-notification'],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return self::jsonResponse(false, self::CODE_FAILED, trans('api.not_found'), $validator->errors());
        }

        DB::commit();
        return self::jsonResponse(true, self::CODE_OK, trans('admin.notifications'), new \stdClass(), $auth);
    }

    /**
     *  forget password service
     *
     * @param Request $request
     * @return mixed
     */
    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.validation_err'), $validator->errors());
        }

        try {
            $user = User::where('email', $request->email)->first();
            // in order for more security we will send a verification code
            $user->update([
                'pin' => bin2hex(random_bytes(65))
            ]);

            // send activation link to the user
            $data = [
                'view' => 'emails.setPassword',
                'subject' => 'set password',
                'to' => $user->email,
                'name' => $user->name,
                'id' => $user->id,
                'pin' => $user->pin,
            ];
            $this->sendContactMail($data);

        } catch (\Exception $ex) {
            self::logErr($ex->getMessage());
            return self::jsonResponse(false, self::CODE_FAILED, trans('api.validation_err'));
        }

        return self::jsonResponse(true, self::CODE_OK, trans('api.correct'));
    }
}
