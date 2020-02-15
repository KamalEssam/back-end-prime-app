<?php


namespace App\Http\Repositories;

use App\Models\User;

class UsersRepository extends BaseRepository
{
    public $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     *  get all users
     *
     * @return mixed
     */
    public function sales()
    {
        try {
            return $this->user->sale()->select('id', 'name', 'email', 'mobile')->get();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get all users
     *
     * @return mixed
     */
    public function users()
    {
        try {
            return $this->user->user()->select('id', 'name', 'email', 'mobile')->get();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  add user
     *
     * @param $request
     * @return mixed
     */
    public function createUser($request)
    {
        try {
            return $this->user->create($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }


    /**
     *  get user by id
     *
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        try {
            return $this->user->find($id);
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get count of all users
     *
     * @return mixed
     */
    public function count()
    {
        try {
            return $this->user->sale()->count();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  update user
     *
     * @param $user
     * @param $request
     * @return mixed
     */
    public function update($user, $request)
    {
        try {
            $user->update($request->all());

            return $user;
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get user by social
     *
     * @param $request
     * @param $column
     * @return bool
     */
    public function getUserBySocial($request, $column)
    {
        $email = $request->has('email') ? $request->get('email') : null;
        $mobile = $request->has('mobile') ? $request->get('mobile') : null;

        if ($email || $mobile) {
            try {
                return $this
                    ->user
                    ->where($column, $request->get($column))    // ex facebook_id or google_id
                    ->where(function ($query) use ($email) {
                        if ($email) {
                            $query->where('email', $email);
                        }
                    })->where(function ($query) use ($mobile) {
                        if ($mobile) {
                            $query->where('mobile', $mobile);
                        }
                    })
                    ->first();
            } catch (\Exception $e) {
                return self::catchExceptions($e->getMessage());
            }
        }
        return false;
    }
}
