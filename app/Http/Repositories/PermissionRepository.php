<?php


namespace App\Http\Repositories;


use App\Models\Permission;

class PermissionRepository extends BaseRepository
{
    public $permission;

    public function __construct()
    {
        $this->permission = new Permission();
    }

    /**
     *  get all permissions
     *
     * @return mixed
     */
    public function all()
    {
        try {
            return $this->permission::all();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }


    /**
     *  update permission using column name
     *
     * @param $name
     * @param $value
     * @return mixed
     */
    public function updateByColumnName($name, $value)
    {
        $permission = $this->permission->where('column', $name)->first();
        try {
            return $permission->update([
                'is_visible' => $value
            ]);
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }
}
