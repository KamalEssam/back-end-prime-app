<?php


namespace App\Http\Repositories;


use App\Http\Interfaces\ColorInterface;
use App\Models\Color;

class ColorRepository extends BaseRepository implements ColorInterface
{
    public $color;

    public function __construct()
    {
        $this->color = new Color();
    }

    /**
     *  get all colors
     *
     * @return mixed
     */
    public function all()
    {
        try {
            return $this->color::all();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  add color
     *
     * @param $request
     * @return mixed
     */
    public function createColor($request)
    {
        try {
            return $this->color->create($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }


    /**
     *  get color by id
     *
     * @param $id
     * @return mixed
     */
    public function getColorById($id)
    {
        try {
            return $this->color->find($id);
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get count of all categories
     *
     * @return mixed
     */
    public function count()
    {
        try {
            return $this->color::count();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  update color
     *
     * @param $color
     * @param $request
     * @return mixed
     */
    public function update($color,$request)
    {
        try {
            return $color->update($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get array of colors
     *
     * @param $request
     * @return mixed
     */
    public function getColorsArray()
    {
        try {
            return $this->color->pluck(app()->getLocale() . '_name as name', 'id')->toArray();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }
}
