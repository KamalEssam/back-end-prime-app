<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission1 = new Permission();
        $permission1->create(
            [
                'column' => 'price',
                'is_visible' => 1
            ]);

        $permission2 = new Permission();
        $permission2->create(
            [
                'column' => 'quantity',
                'is_visible' => 1
            ]);
    }
}
