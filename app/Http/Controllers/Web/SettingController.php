<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
//use App\Models\Setting;
use App\Http\Repositories\PermissionRepository;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Session;

class SettingController extends WebController
{
    /**
     *  change the language of the application
     *
     * @param $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setLang($lang)
    {
        if (in_array($lang, ['en', 'ar'])) {
            Session::put('applocale', $lang);
            return redirect()->back();
        }
        Session::put('applocale', 'en');
        return redirect()->back();
    }

    /**
     *  show change password view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePasswordView()
    {
        return view('admin.settings.change_password');
    }

    /**
     *  change password store
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function changePasswordStore(Request $request)
    {
        $this->validate($request, [
            'old_pass' => 'required|min:6',
            'password' => 'required|confirmed|min:6',
        ]);

        // check if the the password is right or not
        if (!password_verify($request['old_pass'], auth()->user()->password)) {
            return $this->messageAndRedirect(self::STATUS_ERR, 'the old password is wrong');
        }

        // change the password to the new password
        auth()->user()->password = $request['password'];
        auth()->user()->update();

        return $this->messageAndRedirect(self::STATUS_OK, 'password has been changed successfully', 'admin.dashboard');
    }

    /**
     *  show about us form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings_form()
    {
        return view('admin.settings.settings');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function permissions(Request $request)
    {

        $premissionRepo = new PermissionRepository();

        if ($request->has('price')) {
            $premissionRepo->updateByColumnName('price', 1);
        } else {
            $premissionRepo->updateByColumnName('price', 0);
        }

        if ($request->has('quantity')) {
            $premissionRepo->updateByColumnName('quantity', 1);
        } else {
            $premissionRepo->updateByColumnName('quantity', 0);
        }
        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.permission-updated-ok'));
    }

    /**
     *  bout us
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAboutUs()
    {
        return view('admin.settings.about_us');
    }

    /**
     *  update about us
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postAaboutUs(Request $request)
    {
        $this->validate($request, [
            'en_about_us' => 'required',
//            'ar_about_us' => 'required'
        ]);

        $settings = AboutUs::first();
        if ($settings) {
            $settings->update($request->all());
            return $this->messageAndRedirect(self::STATUS_OK, 'about us has been updated successfully');
        }

        AboutUs::create($request->all());
        return $this->messageAndRedirect(self::STATUS_OK, 'about us has been created successfully');
    }
}
