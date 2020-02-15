<?php


namespace App\Http\Interfaces;


interface ColorInterface
{

    /**
     *  get all colors
     *
     * @return mixed
     */
    public function all();


    /**
     *  get count of all colors
     *
     * @return mixed
     */
    public function count();

    /**
     *  add color
     *
     * @param $request
     * @return mixed
     */
    public function createColor($request);


    /**
     *  update color
     *
     * @param $color
     * @param $request
     * @return mixed
     */
    public function update($color,$request);


    /**
     *  get color by id
     *
     * @param $id
     * @return mixed
     */
    public function getColorById($id);

    /**
     *  get array of colors
     *
     * @param $request
     * @return mixed
     */
    public function getColorsArray();
}
