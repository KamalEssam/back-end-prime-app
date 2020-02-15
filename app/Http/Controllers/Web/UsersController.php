<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use App\Http\Repositories\UsersRepository;
use App\Http\Requests\SaleRequest;
use App\Http\Traits\MailTrait;
use App\Mail\NewSaleMail;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;
use Validator;

class UsersController extends WebController
{

    use MailTrait;
    public $userRepo;

    public function __construct(UsersRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    /**
     *  get all sales of the app
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sales = $this->userRepo->sales();
        return view('admin.sales.index', ['users' => $sales]);
    }


    /**
     *  get all users
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allUsers()
    {
        $users = $this->userRepo->users();
        return view('admin.users.index', ['users' => $users]);
    }


    /**
     *  create sale
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.sales.create');

    }

    /**
     *  register sale in database and send email with the new credentials
     *
     * @param SaleRequest $request
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function store(SaleRequest $request)
    {


        $request['role_id'] = self::ROLE_SALE;
        // register new sale
        $sale = $this->userRepo->createUser($request);

        try {
            // send mail to user with credentials
            Mail::to($sale->email)
                ->send(new NewSaleMail($sale, $request['password']));
        } catch (\Exception $e) {
            self::catchExceptions($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.sale_add_err'), 'sales.index');

        }

        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.sale_add_ok'), 'sales.index');
    }

    /**
     *  edit sale
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $sale = $this->userRepo->getUserById($id);
        return view('admin.sales.edit', compact('sale'));
    }

    /**
     *  update sale
     *
     * @param SaleRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SaleRequest $request, $id)
    {
        $sale = $this->userRepo->getUserById($id);

        try {
            $this->userRepo->update($sale, $request);
        } catch (\Exception $e) {
            self::catchExceptions($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.sale_edit_err'), 'sales.index');
        }

        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.sale_edit_ok'), 'sales.index');
    }

    /**
     *  delete sale
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->deleteItem($this->userRepo->user, $id);
    }

    /**
     *  set password
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSetPassword(Request $request)
    {
        $user_id = $request->segment(2);
        $token = $request->segment(4);

        if (!$user_id || !$token) {
            return view('frontend.index', ['alert' => 'danger', 'message' => 'invalid link']);
        }
        $user = User::find($user_id);

        // user not found
        if (!$user) {
            return view('frontend.index', ['alert' => 'danger', 'message' => 'invalid link']);
        }

        // verify the code using

        if ($user->pin !== $token) {
            return view('frontend.index', ['alert' => 'danger', 'message' => 'link is expired']);
        }

        return view('auth.passwords.reset');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function SetSetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed'
        ]);

        if (!$request['user_id'] || !$request['token']) {
            return view('frontend.index')->with(['alert' => 'danger', 'message' => 'invalid link']);
        }
        // check user existence
        $user = User::where('id', $request['user_id'])->first();
        if (!$user) {
            return view('frontend.index')->with(['alert' => 'danger', 'message' => 'invalid link']);
        }

        $token = $request['token'];

        // check pin
        if ($user->pin !== $token) {
            return view('frontend.index')->with(['alert' => 'danger', 'message' => 'invalid link']);
        }

        try {
            $user->update([
                'password' => $request['password'],
                'pin' => null
            ]);
        } catch (\Exception $e) {
            return view('frontend.index')->with(['alert' => 'danger', 'message' => 'failed to set password please contact support']);
        }

        if ($user->role_id == self::ROLE_ADMIN) {
            \Auth::loginUsingId($user->id);
            return redirect()->route('admin.dashboard');
        }
        return view('frontend.index')->with(['alert' => 'success', 'message' => 'new password set successfully']);
    }

    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.validation_err'), $validator->errors());
        }

        try {
            $user = User::where('email', $request->email)->where('role_id', self::ROLE_ADMIN)->first();
            if (!$user) {
                return $this->messageAndRedirect(self::STATUS_ERR, 'user doesnt exist or not an admin');
            }
            // in order for more security we will send a verification code
            $user->update([
                'pin' => bin2hex(random_bytes(60))
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
            return $this->messageAndRedirect(self::STATUS_ERR, 'failed to send reset password mail');
        }

        return $this->messageAndRedirect(self::STATUS_OK, 'reset password mail sent to your mail');
    }
}
