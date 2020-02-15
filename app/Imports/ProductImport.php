<?php

namespace App\Imports;

use App\Http\Repositories\ProductRepository;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!empty($row[0]) && !empty($row[1]) && !empty($row[3]) && !empty($row[4])) {
            $category_id = Category::where('en_name', strtolower($row[2]))->first()->id ?? 1;

            if ($category_id) {
                return (new ProductRepository())->addProductsFromImport([
                    'en_name' => $row[0],
                    'unique_id' => $row[1],
                    'en_desc' => $row[3],
                    'quantity' => $row[4],
                    'price' => $row[5],
                    'image' => 'default.png',
                    'category_id' => $category_id,
                ]);
            }
        }
    }
}
